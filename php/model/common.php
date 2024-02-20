<?php
require_once 'connection.php';

class Common
{
    protected $db;

    function __construct()
    {
        $this->db = new Connection();
    }

    function delete($table, $column, $value)
    {
        $conn = $this->db->getConnection();
        $response = array();

        $sql = "DELETE FROM $table WHERE $column = :value";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':value', $value, PDO::PARAM_STR);
        if ($table === 'students') {
            $this->deleteStudentQualifications($value);
        }

        if ($stmt->execute()) {
            $response['status'] = true;
            $response['message'] = 'Record deleted successfully';
        } else {
            $response['status'] = false;
            $response['message'] = 'Error deleting record';
        }

        // Encode the response array to JSON and send it
        echo json_encode($response);
    }


    function fetch($table, $column, $value)
    {
        $conn = $this->db->getConnection();
        $sql = "SELECT $column FROM $table WHERE id = :value";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':value', $value, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function fetch1($table, $column, $value)
    {
        $conn = $this->db->getConnection();
        $sql = "SELECT $column FROM $table WHERE id = $value";
        $stmt = $conn->query($sql);
        return $sql;
    }

    function statusUpdate($id, $table, $value = null)
    {
        $conn = $this->db->getConnection();
        // Fetch the current status and toggle it
        $post = $this->fetch($table, 'status', $id);
        if ($value === null) {
            $status = $post['status'] === 'active' ? 'deactive' : 'active';
        } else {
            $status = $value;
        }


        // Prepare the SQL statement and bind parameters
        $sql = "UPDATE `$table` SET `status`=:status WHERE `id`=:id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Execute the query and check for success or failure
        if ($stmt->execute()) {
            // Change the success message here
            return ['status' => 'success', 'message' => 'Status updated successfully!'];
        } else {
            return ['status' => 'fails', false => 'Error updating data in the database: ' . $stmt->errorInfo()];
        }
    }

    function deleteStudentQualifications($studentId)
    {
        $conn = $this->db->getConnection();
        $sql = "DELETE FROM students_qualification WHERE student_id = :studentId";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':studentId', $studentId, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $image = $this->fetch('students', 'profile_image', $studentId);
            $this->deleteImage($image['profile_image']);
            return true;
        }
        return false;
    }

    // function deleteImage($filename)
    // {
    //     $uploadDirectory = '../../assets/upload/';
    //     $filePath = $uploadDirectory . $filename;

    //     if (file_exists($filePath)) {
    //         if (unlink($filePath)) {
    //             return true;
    //         } else {
    //             return false; // Unable to delete file
    //         }
    //     } else {
    //         return false; // File does not exist
    //     }
    // }

    function deleteImage($filename)
{
    $uploadDirectory = '../../assets/upload/';
    $filePath = $uploadDirectory . $filename;

    if (is_file($filePath)) {
        if (unlink($filePath)) {
            return true; // File deleted successfully
        } else {
            return false; // Unable to delete file
        }
    } elseif (is_dir($filePath)) {
        // You might want to handle this case differently
        return false; // Trying to delete a directory, not a file
    } else {
        return false; // File does not exist
    }
}



    // function moveUploadedFile($file, $uploadDirectory, $newFilename = false)
    // {
    //     if ($file['error'] === 0) {
    //         $fileTmpPath = $file['tmp_name'];
    //         $fileName = $file['name'];
    //         $fileInfo = pathinfo($fileName);
    //         $extension = $fileInfo['extension'];
    //         if ($newFilename) {
    //             $name = $newFilename . '.' . $extension;
    //         } else {
    //             $name = uniqid('admin_image_') . '.' . $extension;
    //         }
    //         $uploadPath = $uploadDirectory . $name;
    //         if (move_uploaded_file($fileTmpPath, $uploadPath)) {
    //             return $name;
    //         } else {
    //             return false; // Handle file upload failure
    //         }
    //     } else {
    //         return false; // Handle file error
    //     }
    // }

    function moveUploadedFile($file, $uploadDirectory, $newFilename = false)
    {
        if ($file['error'] === 0) {
            $fileTmpPath = $file['tmp_name'];
            $fileName = $file['name'];
            $fileInfo = pathinfo($fileName);
            $extension = $fileInfo['extension'];
            if ($newFilename) {
                $name = $newFilename . '.' . $extension;
            } else {
                $name = uniqid('admin_image_') . '.' . $extension;
            }
            $uploadPath = $uploadDirectory . $name;

            // Check if file with same name already exists
            if (file_exists($uploadPath)) {
                // Remove existing file
                unlink($uploadPath);
            }

            if (move_uploaded_file($fileTmpPath, $uploadPath)) {
                return $name;
            } else {
                return false; // Handle file upload failure
            }
        } else {
            return false; // Handle file error
        }
    }


    function fetchAll($table)
    {
        $conn = $this->db->getConnection();
        $sql = "SELECT * FROM $table ORDER BY `id` DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function getLastIDQuery($table)
    {
        $conn = $this->db->getConnection();
        $sql = "SELECT MAX(ID) AS id FROM $table"; // Use 'AS id' to alias the column
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result['id'] === null ? 1 : $result['id'];
        } else {
            return null;
        }
    }

    function checkRequiredFields($data, $requiredFields)
    {
        $missingFields = [];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                $missingFields[] = $field;
            }
        }
        return $missingFields;
    }

    function isValueExists($table, $column, $email)
    {
        $conn = $this->db->getConnection();
        $sql = "SELECT COUNT(*) FROM $table WHERE $column = :value";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':value', $email);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
}
