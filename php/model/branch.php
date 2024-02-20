<?php
require_once 'connection.php';
require_once 'common.php';

class BranchModel extends Common
{
    protected $db;

    public function __construct()
    {
        $this->db = new Connection();
    }

    public function addBranch()
    {

        $post = $_POST;
        $conn = $this->db->getConnection();
        $validationResult = $this->validateStudentData($post);
        if ($validationResult['status'] === false) {
            return $validationResult;
        }
        $state = $post['state'];
        $city = $post['city'];
        $code = $post['code'];
        $name = $post['name'];
        $head = $post['head'];
        $category = $post['category'];
        $phone = $post['phone'];
        $till_date = $post['till_date'];
        $address = $post['address'];
        $c_address = $post['corresponding_address'];
        $email = $post['email'];
        $password = password_hash($post['password'], PASSWORD_DEFAULT);

        if ($this->isValueExists('tblbranch', 'code', $code)) {
            return ['status' => false, 'message' => 'Branch Code already exists.'];
        }
        if ($this->isValueExists('tblbranch', 'email', $email)) {
            return ['status' => false, 'message' => 'Branch Email already exists.'];
        }

        $sql = 'INSERT INTO tblbranch (state_id, city_id, code, name, head, category, phone, till_date, address,
             corresponding_address, email, password) VALUES (:state_id, :city_id, :code, :name, :head, :category,
              :phone, :till_date, :address, :c_address, :email, :password)';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':state_id', $state);
        $stmt->bindParam(':city_id', $city);
        $stmt->bindParam(':code', $code);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':head', $head);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':till_date', $till_date);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':c_address', $c_address);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

        if ($stmt->execute()) {
            return ['status' => 'success', 'message' => 'Branch added successfully!'];
        } else {
            return ['status' => false, 'message' => 'Error adding branch'];
        }
    }

    private function validateStudentData($post)
    {
        $requiredFields = ['state', 'city', 'code', 'name', 'head', 'category', 'phone', 'till_date', 'address', 'email'];

        $missingFields = $this->checkRequiredFields($post, $requiredFields);
        if (!empty($missingFields)) {
            return ['status' => false, 'message' => "Error: The following fields are required: " . implode(', ', $missingFields)];
        }

        if (isset($post['email'])) {
            if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
                $validationResult = [
                    'status' => false,
                    'message' => 'Invalid email format for email.',
                ];
                return $validationResult;
            }
        }

        $cleaned_phone = preg_replace('/[^0-9]/', '', $post['phone']);
        if (strlen($cleaned_phone) !== 10) {
            return [
                'status' => false,
                'message' => 'Student phone phone must contain exactly 10 digits.',
            ];
        }

        return ['status' => 'success'];
    }

    public function updateBranch()
    {
        // Check if branch ID is provided
        if (empty($_POST['branch_id'])) {
            $response = ['status' => false, 'message' => 'Branch ID is missing.'];
            return json_encode($response);
        }

        $post = $_POST;
        $conn = $this->db->getConnection();
        $validationResult = $this->validateStudentData($post);
        if ($validationResult['status'] === false) {
            return $validationResult;
        }

        $branchId = $_POST['branch_id'];
        $state = $_POST['state'];
        $city = $_POST['city'];
        $code = $_POST['code'];
        $name = $_POST['name'];
        $head = $_POST['head'];
        $category = $_POST['category'];
        $phone = $_POST['phone'];
        $till_date = $_POST['till_date'];
        $address = $_POST['address'];
        $c_address = $_POST['corresponding_address'];
        $email = $_POST['email'];

        // Password is optional, so check if it's set
        if (isset($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }


        $conn = $this->db->getConnection();
        $sql = 'UPDATE tblbranch SET state_id = :state_id, city_id = :city_id, code = :code, name = :name, head = :head, category = :category,
         phone = :phone, till_date = :till_date, address = :address, corresponding_address = :corresponding_address, email = :email';

        // Include password update if it's set
        if (isset($password)) {
            $sql .= ', password = :password';
        }

        $sql .= ' WHERE id = :branch_id';

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':state_id', $state);
        $stmt->bindParam(':city_id', $city);
        $stmt->bindParam(':code', $code);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':head', $head);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':till_date', $till_date);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':corresponding_address', $c_address);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':branch_id', $branchId);

        // Include password update if it's set
        if (isset($password)) {
            $stmt->bindParam(':password', $password);
        }

        if ($stmt->execute()) {
            return $response = ['status' => 'success', 'message' => 'Branch updated successfully!'];
        }
        $response = ['status' => false, 'message' => 'Error updating branch'];
    }

    public function fetchBranch($id)
    {
        $conn = $this->db->getConnection();
        $selectSql = "SELECT tblbranch.*, states.state_name, cities.city_name FROM tblbranch JOIN states ON tblbranch.state_id = states.id JOIN cities ON cities.id = cities.id 
        WHERE tblbranch.id = :id";
        $selectStmt = $conn->prepare($selectSql);
        $selectStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $selectStmt->execute();
        return $selectStmt->fetch(PDO::FETCH_OBJ);
    }

    public function getBranchCode($id)
    {
        $conn = $this->db->getConnection();
        $sql = "SELECT code FROM tblbranch WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function update()
    {

        $phone = $_POST['phone'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $id = $_SESSION['loggedin'];
        $phone = strtoupper($phone);
        $conn = $this->db->getConnection();
        $updateSql = "UPDATE tblbranch SET phone = :phone, name = :name, email = :email WHERE id = :id";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $updateStmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $updateStmt->bindParam(':name', $name, PDO::PARAM_STR);
        $updateStmt->bindParam(':email', $email, PDO::PARAM_STR);

        if ($updateStmt->execute()) {
            return ['status' => true, 'message' => 'Admin data updated successfully.'];
        } else {
            return ['status' => false, 'message' => 'Error updating Admin data.'];
        }
    }

    function updateProfileImage($imagePath)
    {
        $userId = $_SESSION['loggedin']; // Assuming you store the user ID in the session

        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("UPDATE tblbranch SET profile_image = :imagePath WHERE id = :userId");
        $stmt->bindParam(':imagePath', $imagePath);
        $stmt->bindParam(':userId', $userId);

        if ($stmt->execute()) {
            $_SESSION['profile_image'] = $imagePath;
            return ['status' => true, 'message' => 'Profile image updated successfully', 'image' => $imagePath];
        } else {
            return ['status' => false, 'message' => 'Error updating profile image'];
        }
    }



    function changePassword($oldPassword, $newPassword, $confirmPassword)
    {
        $id = $_SESSION['loggedin']; // Assuming you store the user ID in the session

        // Validate passwords
        if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
            return ['status' => false, 'message' => 'All password fields are required.'];
        }

        if ($newPassword !== $confirmPassword) {
            return ['status' => false, 'message' => 'New password and confirm password do not match.'];
        }

        // Fetch the current password from the database
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT password FROM tblbranch WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify the old password
        if (!password_verify($oldPassword, $userData['password'])) {
            return ['status' => false, 'message' => 'Incorrect old password.'];
        }

        // Hash and update the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateSql = "UPDATE tblbranch SET password = :password WHERE id = :id";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $updateStmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);

        if ($updateStmt->execute()) {
            return ['status' => true, 'message' => 'Password updated successfully.'];
        } else {
            return ['status' => false, 'message' => 'Error updating password.'];
        }
    }
}
