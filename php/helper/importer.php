<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require '../../vendor/autoload.php';
include('../model/connection.php');

use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelImporter
{
    private $targetDir;
    private $dbConnection;

    public function __construct()
    {
        $this->targetDir = "../../assets/excel/";
        $this->dbConnection = new Connection();
    }

    public function importExcel()
    {
        $response = array(); // Associative array to store the response

        $targetFile = $this->targetDir . basename($_FILES["import_file"]["name"]);

        if (!$this->isValidFileType($targetFile)) {
            $response['success'] = false;
            $_SESSION['error_message'] = "Sorry, only Excel files are allowed.";
            return $response;
        }

        $this->createTargetDirectory();

        if (move_uploaded_file($_FILES["import_file"]["tmp_name"], $targetFile)) {
            $excelData = $this->readExcelData($targetFile);
            $response['success'] = true;
            $response['data'] = $excelData;
            return $response;
        }

        $response['success'] = false;
        $_SESSION['error_message'] = "Sorry, there was an error uploading your file.";
        return $response;
    }

    private function isValidFileType($targetFile)
    {
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        return $fileType == "xls" || $fileType == "xlsx";
    }
    private function createTargetDirectory()
    {
        if (!file_exists($this->targetDir)) {
            mkdir($this->targetDir, 0777, true);
        }
    }

    // Helper function to get existing columns in a table
    private function getExistingColumns($tableName)
    {
        $conn = $this->dbConnection->getConnection();
        $stmt = $conn->query("DESCRIBE $tableName");
        $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $columns;
    }

    public function insertData($tableName, $excelData)
    {
        $conn = $this->dbConnection->getConnection();
        $columns = array_shift($excelData);
        $response = array(); // Associative array to store the response

        try {
            $existingColumns = $this->getExistingColumns($tableName);
            $nonExistingColumns = array_diff($columns, $existingColumns);
            $jsonData = json_encode(array_values($nonExistingColumns));

            if (!empty($nonExistingColumns)) {
                return ['success' => false, 'message' => "Columns do not exist in table: " . $jsonData];
            }

            $columnNames = implode(', ', $columns);
            $namedPlaceholders = implode(', ', array_map(function ($column) {
                return ":$column";
            }, $columns));

            $stmt = $conn->prepare("INSERT INTO $tableName ($columnNames) VALUES ($namedPlaceholders)");

            $isFirstRow = true;
            $columnNames = array();
            $excelDataAssoc = array();

            foreach ($excelData as $index => $rowData) {
                if ($isFirstRow) {
                    // If it's the first row, store the column names
                    $columnNames = $rowData;
                    $isFirstRow = false;
                } else {
                    // If it's not the first row, create an associative array
                    $rowAssoc = array_combine($columns, $rowData);
                    $excelDataAssoc[$index] = $rowAssoc;
                }
            }

            // Now, execute the insert statement for each row
            foreach ($excelDataAssoc as $row) {
                $row = array_map(function ($value) {
                    return $value !== '' ? $value : null;
                }, $row);

                try {
                    // Binding parameters before executing the statement
                    foreach ($columns as $column) {
                        $stmt->bindParam(":$column", $row[$column]);
                    }

                    $stmt->execute();
                } catch (PDOException $e) {
                    if ($e->getCode() == '23000' && strpos($e->getMessage(), 'Duplicate entry') !== false) {
                        continue;
                    } else {
                        throw $e;
                    }
                }

                if ($stmt->rowCount() == 0) {
                    return ['success' => false, 'message' => "Some entries failed to insert."];
                }
            }

            if (empty($response)) {
                $response['success'] = true;
                $response['message'] = "All entries inserted successfully.";
            } else {
                $response['success'] = false;
                $response['message'] = "Some entries failed to insert.";
            }
        } catch (PDOException $e) {
            $response['success'] = false;
            $response['message'] = "Error: " . $e->getMessage();
        }

        return $response;
    }

    private function readExcelData($file)
    {
        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        $excelData = array();

        for ($row = 1; $row <= $highestRow; $row++) {
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
            $excelData[] = $rowData[0];
        }
        return $excelData;
    }

    private function convertDaysToDate(&$excelData)
    {
        foreach ($excelData as &$row) {
            if (is_numeric($row[7])) {
                $row[7] = $this->convertSingleDayToDate($row[7]);
            }
        }
    }

    private function convertSingleDayToDate($days)
    {
        $referenceDate = new DateTime('1896-12-29');
        return $referenceDate->add(new DateInterval('P' . $days . 'D'))->format('Y-m-d');
    }
}