<?php
require_once 'connection.php';
require_once 'common.php';

class CityModel extends Common
{
    protected $db;

    public function __construct()
    {
        $this->db = new Connection();
    }

    public function insertCity()
    {
        $post = $_POST;
        $conn = $this->db->getConnection();
        $validationResult = $this->validateStudentData($post, true);
        if ($validationResult['status'] === false) {
            return json_encode($validationResult);
        }

        if ($this->isCityCodeExists($post['city_code']) > 0) {
            return json_encode(['status' => false, 'message' => 'City code already exists.']);
        }

        $cityCode = strtoupper($post['city_code']);
        $cityName = $post['city_name'];
        $state = $post['state'];

        $insertSql = "INSERT INTO cities (city_code, city_name, state) VALUES (:city_code, :city_name, :state)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bindParam(':city_code', $cityCode, PDO::PARAM_STR);
        $insertStmt->bindParam(':city_name', $cityName, PDO::PARAM_STR);
        $insertStmt->bindParam(':state', $state, PDO::PARAM_STR);

        if ($insertStmt->execute()) {
            $response = ['status' => true, 'message' => 'City data inserted successfully.'];
        } else {
            $response = ['status' => false, 'message' => 'Error inserting city data.'];
        }
        return json_encode($response);
    }

    private function validateStudentData($post, $checkForDuplicates = false)
    {
        $requiredFields =  ['city_code', 'city_name', 'state'];;

        $missingFields = $this->checkRequiredFields($post, $requiredFields);
        if (!empty($missingFields)) {
            return ['status' => false, 'message' => "Error: The following fields are required: " . implode(', ', $missingFields)];
        }

        return ['status' => 'success'];
    }

    public function isCityCodeExists($cityCode, $id = null)
    {
        $conn = $this->db->getConnection();
        $checkSql = "SELECT COUNT(*) FROM cities WHERE city_code = :city_code";
        $params = [':city_code' => $cityCode];

        if ($id !== null) {
            $checkSql .= " AND id != :id";
            $params[':id'] = $id;
        }

        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->execute($params);
        $count = $checkStmt->fetchColumn();
        return $count > 0;
    }


    public function updateCity()
    {

        if ($this->isCityCodeExists($_POST['city_code'], $_POST['id']) > 0) {
            return json_encode(['status' => false, 'message' => 'City code already exists.']);
        }
        $cityCode = $_POST['city_code'];
        $cityName = $_POST['city_name'];
        $state = $_POST['state'];
        $id = $_POST['id'];
        $cityCode = strtoupper($cityCode);
        $conn = $this->db->getConnection();
        $updateSql = "UPDATE cities SET city_code = :city_code, city_name = :city_name, state = :state WHERE id = :id";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $updateStmt->bindParam(':city_code', $cityCode, PDO::PARAM_STR);
        $updateStmt->bindParam(':city_name', $cityName, PDO::PARAM_STR);
        $updateStmt->bindParam(':state', $state, PDO::PARAM_STR);

        if ($updateStmt->execute()) {
            $response = ['status' => true, 'message' => 'City data updated successfully.'];
        } else {
            $response = ['status' => false, 'message' => 'Error updating city data.'];
        }
        echo json_encode($response);
    }

    public function getDistrictByState($stateId)
    {
        $conn = $this->db->getConnection();
        $sql = "SELECT * FROM district WHERE state = :state_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':state_id', $stateId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getCitiesByState($stateId)
    {
        $conn = $this->db->getConnection();
        $sql = "SELECT * FROM cities WHERE state = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $stateId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCitiesCodeByState($stateId)
    {
        $conn = $this->db->getConnection();
        $sql = "SELECT city_code FROM cities WHERE id = :state_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':state_id', $stateId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
}
