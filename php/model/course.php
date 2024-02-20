<?php
require_once 'connection.php';
require_once 'common.php';

class Course extends Common
{
    protected $db;

    public function __construct()
    {
        $this->db = new Connection();
    }

    public function fetchAll($table)
    {
        $conn = $this->db->getConnection();
        $selectSql = "SELECT * FROM $table";
        $selectStmt = $conn->prepare($selectSql);
        $selectStmt->execute();
        return $selectStmt->fetchAll();
    }

    public function fetchCourse($value)
    {
        $conn = $this->db->getConnection();
        $selectSql = "SELECT * FROM courses WHERE id = :id";
        $selectStmt = $conn->prepare($selectSql);
        $selectStmt->bindParam(':id', $value, PDO::PARAM_INT);
        $selectStmt->execute();
        return $selectStmt->fetch(PDO::FETCH_OBJ);
    }

    private function validateStudentData($post, $checkForDuplicates = false)
    {
        $requiredFields =  ["course_category", "course_code", "course_duration", "duration_time", "course_name", "total_fee", "eligibility", "other_details", "course_type"];

        $missingFields = $this->checkRequiredFields($post, $requiredFields);
        if (!empty($missingFields)) {
            return ['status' => false, 'message' => "Error: The following fields are required: " . implode(', ', $missingFields)];
        }

        return ['status' => 'success'];
    }

    public function insert()
    {
        try {
            $post = $_POST;
            $conn = $this->db->getConnection();
            $validationResult = $this->validateStudentData($post, true);
            if ($validationResult['status'] === false) {
                return $validationResult;
            }
            $course_code = strtoupper($post['course_code']);


            $sql = "INSERT INTO courses (course_category, course_code, course_duration, duration_time, course_name, total_fee, eligibility, other_details, course_type)
                VALUES (:course_category, :course_code, :course_duration, :duration_time, :course_name, :total_fee, :eligibility, :other_details, :course_type)";

            $stmt = $conn->prepare($sql);


            $stmt->bindParam(':course_category', $post['course_category']);
            $stmt->bindParam(':course_code', $course_code);
            $stmt->bindParam(':course_duration', $post['course_duration']);
            $stmt->bindParam(':duration_time', $post['duration_time']);
            $stmt->bindParam(':course_name', $post['course_name']);
            $stmt->bindParam(':total_fee', $post['total_fee']);
            $stmt->bindParam(':eligibility', $post['eligibility']);
            $stmt->bindParam(':other_details', $post['other_details']);
            $stmt->bindParam(':course_type', $post['course_type']);

            if ($stmt->execute()) {
                return ['status' => 'success', 'message' => 'Course added successfully'];
            } else {
                return ['status' => false, 'message' => 'Error: ' . $stmt->errorInfo()[2]];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'message' => 'Database Error: ' . $e->getMessage()];
        }
    }

    public function update($id)
    {
        try {
            $post = $_POST;
            $conn = $this->db->getConnection();

            $validationResult = $this->validateStudentData($post, true);
            if ($validationResult['status'] === false) {
                return $validationResult;
            }
            $course_code = strtoupper($post['course_code']);


            $sql = "UPDATE courses
            SET course_category = :course_category,
                course_code = :course_code,
                course_duration = :course_duration,
                duration_time = :duration_time,
                course_name = :course_name,
                total_fee = :total_fee,
                eligibility = :eligibility,
                other_details = :other_details,
                course_type = :course_type
            WHERE id = :id";

            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':course_category', $post['course_category']);
            $stmt->bindParam(':course_code', $course_code);
            $stmt->bindParam(':course_duration', $post['course_duration']);
            $stmt->bindParam(':duration_time', $post['duration_time']);
            $stmt->bindParam(':course_name', $post['course_name']);
            $stmt->bindParam(':total_fee', $post['total_fee']);
            $stmt->bindParam(':eligibility', $post['eligibility']);
            $stmt->bindParam(':other_details', $post['other_details']);
            $stmt->bindParam(':course_type', $post['course_type']);
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                $students = $this->fetchWhere('students', "course = $id");
                foreach ($students as $student) {
                    $todayPlusDuration = date('Y-m-d', strtotime($student['date_admission'] . ' +' . $post['course_duration'] . ' ' . $post['duration_time']));
                    $updateSql = "UPDATE students SET till_date = :till_date WHERE id = :id";
                    $updateStmt = $conn->prepare($updateSql);
                    $updateStmt->bindParam(':till_date', $todayPlusDuration, PDO::PARAM_STR);
                    $updateStmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $updateStmt->execute();
                }
                return ['status' => 'success', 'message' => 'Course updated successfully'];
            } else {
                return ['status' => false, 'message' => 'Error: ' . $stmt->errorInfo()[2]];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'message' => 'Database Error: ' . $e->getMessage()];
        }
    }

    public function fetchWhere($table, $where = null)
    {
        $conn = $this->db->getConnection();
        $sql = "SELECT id, date_admission FROM $table";
        if (!is_null($where)) {
            $sql .= " WHERE $where";
        }
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertCategory()
    {

        $cityName = $_POST['name'];



        $conn = $this->db->getConnection();
        $insertSql = "INSERT INTO course_category (name) VALUES ( :name)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bindParam(':name', $cityName, PDO::PARAM_STR);

        if ($insertStmt->execute()) {
            $response = array(
                'status' => true,
                'message' => 'Course Code Add successfully.'
            );
        } else {
            $response = array(
                'status' => false,
                'message' => 'Error inserting Course Code.'
            );
        }

        return json_encode($response);
    }

    public function updateCategory()
    {

        $id = $_POST['id'];
        $newCityName = $_POST['name'];

        $conn = $this->db->getConnection();
        $updateSql = "UPDATE course_category SET name = :name WHERE id = :id";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bindParam(':name', $newCityName, PDO::PARAM_STR);
        $updateStmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($updateStmt->execute()) {
            return [
                'status' => true,
                'message' => 'City data updated successfully.'
            ];
        } else {
            return [
                'status' => false,
                'message' => 'City data updated Failed.'
            ];
        }
    }
}
