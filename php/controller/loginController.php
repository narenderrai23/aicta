<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('../model/login.php');
if (isset($_POST['login'])) {

    $login = new Login();
    if ($_POST['login'] === 'adminLogin') {
        $email = $_POST['email'];
        $password = $_POST['password'];
        if ($login->adminLogin($email, $password)) {
            header('location:../../admin/index.php');
        } else {
            header('location:../../admin/login.php');
        }
    }

    if ($_POST['login'] === 'branchLogin') {
        $email = $_POST['email'];
        $password = $_POST['password'];
        if ($login->branchLogin($email, $password)) {
            header('location:../../branch/index.php');
        } else {
            header('location:../../branch/login.php');
        }
    }
}
