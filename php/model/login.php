<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'connection.php';

class Login
{
    protected $db;

    public function __construct()
    {
        $this->db = new Connection();
    }

    private function login($table, $email, $password, $role)
    {
        $conn = $this->db->getConnection();

        // Use parameterized queries to prevent SQL injection
        $sql = "SELECT id, profile_image, password FROM $table WHERE email = :email LIMIT 1";
        $query = $conn->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($query->rowCount() > 0 && password_verify($password, $result['password'])) {
            session_regenerate_id(true);

            // Store user information in session
            $_SESSION['loggedin'] = $result['id'];
            $_SESSION['login'] = $_POST['email'];
            $_SESSION['role'] = $role;
            $_SESSION['profile_image'] = $result['profile_image'];

            return true;
        } else {
            $_SESSION['login_error'] = "Incorrect email or password";
            return false;
        }
    }

    public function adminLogin($email, $password)
    {
        return $this->login('tbladmin', $email, $password, 'admin');
    }

    public function branchLogin($email, $password)
    {
        return $this->login('tblbranch', $email, $password, 'branch');
    }

}
