<?php
// Initialize the session
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'branch') {
    header("location: login.php");
    exit;
}
