<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


class Connection
{
    // private $server = "mysql:host=localhost;dbname=orahljzp_aicta";
    // private $username = "root";
    // private $password = "";
    private $server = "mysql:host=localhost;dbname=orahljzp_aicta";
    private $username = "root";
    private $password = "";
    private $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    );
    protected $conn;

    function __construct()
    {
        try {
            $this->conn = new PDO($this->server, $this->username, $this->password, $this->options);
        } catch (PDOException $e) {
            $response = array(
                'status' => 'danger',
                'message' => 'There is some problem in connection: ' . $e->getMessage()
            );
            echo json_encode($response);
            exit;
        }
    }

    function getConnection()
    {
        return $this->conn;
    }
}
