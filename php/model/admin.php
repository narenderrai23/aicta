<?php
require_once 'connection.php';
require_once 'common.php';


class AdminProfile extends Common
{
    protected $db;

    function __construct()
    {
        $this->db = new Connection();
    }

    function update()
    {

        $phone = $_POST['phone'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $id = $_SESSION['loggedin'];
        $phone = strtoupper($phone);
        $conn = $this->db->getConnection();
        $updateSql = "UPDATE tbladmin SET phone = :phone, name = :name, email = :email WHERE id = :id";
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
        $stmt = $conn->prepare("UPDATE tbladmin SET profile_image = :imagePath WHERE id = :userId");
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
        $stmt = $conn->prepare("SELECT password FROM tbladmin WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify the old password
        if (!password_verify($oldPassword, $userData['password'])) {
            return ['status' => false, 'message' => 'Incorrect old password.'];
        }

        // Hash and update the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateSql = "UPDATE tbladmin SET password = :password WHERE id = :id";
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
