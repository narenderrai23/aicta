<?php

require '../../vendor/autoload.php';
include('../model/connection.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelExporter
{
    private $spreadsheet;
    private $dbConnection;

    function __construct()
    {
        $this->spreadsheet = new Spreadsheet();
        $this->dbConnection = new Connection();
    }

    function fetchStudentData()
    {
        $conn = $this->dbConnection->getConnection();

        // Initialize query and parameters
        $query = "SELECT 
        students.*,
        tblbranch.name AS branch_name, tblbranch.code AS branch_code,
        district.district,
        education_level.level,
        courses.course_name,
        states.state_name
        FROM students 
        LEFT JOIN tblbranch ON tblbranch.id = students.branch_id
        LEFT JOIN district ON district.id = students.student_district
        LEFT JOIN education_level ON education_level.id = students.qualification
        LEFT JOIN courses ON courses.id = students.course
        LEFT JOIN states ON states.id = students.student_state";

        $params = array();
        $whereClause = [];

        // Check user role and set conditions accordingly
        $branchId = $_SESSION['role'] === 'branch' ? $_SESSION['loggedin'] : ($_POST['branch'] ?? null);
        if ($branchId !== null) {
            $whereClause[] = "branch_id = :branchId";
            $params[':branchId'] = ['value' => $branchId, 'type' => PDO::PARAM_INT];
        }

        if (isset($_POST['join_date'])) {
            $value = $_POST['join_date'];
            if (strpos($value, 'to') !== false) {
                list($startDate, $endDate) = explode(" to ", $value);
                $whereClause[] = " students.join_date BETWEEN '$startDate' AND '$endDate'";
            } else {
                $whereClause[] = " students.join_date = '$value'";
            }
        }

        if (!empty($whereClause)) {
            $query .= " WHERE " . implode(" AND ", $whereClause);
        }

        if (!empty($_POST['limit'])) {
            $query .= " LIMIT :limit";
            $params[':limit'] = ['value' => $_POST['limit'], 'type' => PDO::PARAM_INT];
        }
        return $this->executeQuery($conn, $query, $params);
    }

    function executeQuery($conn, $query, $params = [])
    {
        $stmt = $conn->prepare($query);
        foreach ($params as $paramName => $paramData) {
            $stmt->bindParam($paramName, $paramData['value'], $paramData['type']);
        }
        $stmt->execute();
        return $stmt;
    }

    function exportStudents()
    {
        $worksheet = $this->spreadsheet->getActiveSheet();

        // Set column headers
        $worksheet->setCellValue('A1', 'Branch Code');
        $worksheet->setCellValue('B1', 'Student Enrollment');
        $worksheet->setCellValue('C1', 'Student Name');
        $worksheet->setCellValue('D1', 'Father Name');
        $worksheet->setCellValue('E1', 'Student Phone');
        $worksheet->setCellValue('F1', 'Student Email');
        $worksheet->setCellValue('G1', 'Student Status');
        $worksheet->setCellValue('H1', 'Student WhatsApp Phone');
        $worksheet->setCellValue('I1', 'Course');
        $worksheet->setCellValue('J1', 'Branch Name');
        $worksheet->setCellValue('K1', 'Admission Date');
        $worksheet->setCellValue('L1', 'Approve');
        $worksheet->setCellValue('M1', 'State');
        $worksheet->setCellValue('N1', 'Status');
        $worksheet->setCellValue('O1', 'Address1');
        $worksheet->setCellValue('P1', 'Address2');
        $worksheet->setCellValue('Q1', 'PQualification');
        $worksheet->setCellValue('R1', 'District');

        $stmt = $this->fetchStudentData();

        $rowNumber = 2;

        foreach ($stmt as $row) {
            $worksheet->setCellValue('A' . $rowNumber, $row['branch_code']);
            $worksheet->setCellValue('B' . $rowNumber, $row['enrollment']);
            $worksheet->setCellValue('C' . $rowNumber, $row['student_name']);
            $worksheet->setCellValue('D' . $rowNumber, $row['father_name']);
            $worksheet->setCellValue('E' . $rowNumber, $row['student_phone']);
            $worksheet->setCellValue('F' . $rowNumber, $row['student_email']);
            $worksheet->setCellValue('G' . $rowNumber, $row['student_status']);
            $worksheet->setCellValue('H' . $rowNumber, $row['w_phone']);
            $worksheet->setCellValue('I' . $rowNumber, $row['course_name']);
            $worksheet->setCellValue('J' . $rowNumber, $row['branch_name']);
            $worksheet->setCellValue('K' . $rowNumber, $row['date_admission']);
            $worksheet->setCellValue('L' . $rowNumber, $row['approve']);
            $worksheet->setCellValue('M' . $rowNumber, $row['state_name']);
            $worksheet->setCellValue('N' . $rowNumber, $row['status']);
            $worksheet->setCellValue('O' . $rowNumber, $row['address1']);
            $worksheet->setCellValue('P' . $rowNumber, $row['address2']);
            $worksheet->setCellValue('Q' . $rowNumber, $row['pqualification']);
            $worksheet->setCellValue('R' . $rowNumber, $row['district']);

            $rowNumber++;
        }

        // Save the spreadsheet to a file
        $writer = new Xlsx($this->spreadsheet);
        $filename = 'students_export.xlsx';
        $writer->save($filename);

        // Output the Excel file to the user
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        readfile($filename);

        // Delete the file after sending
        unlink($filename);
    }

}



if (isset($_POST['action']) && $_POST['action'] === 'excelExport') {
    $exporter = new ExcelExporter();
    $exporter->exportStudents();
}
