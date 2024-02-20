<?php
require_once('../model/reset_password.php');
if (isset($_POST['reset_password'])) {
    $email = $_POST['useremail'];
    $resetHandler = new PasswordResetHandler();
    if ($resetHandler->resetPassword($email)) {
        header('location:../../branch/auth-verification.php');
        exit;
    } else {
        header('location:../../branch/auth-recoverpw.php');
        exit;
    }
}

if (isset($_POST['otp_password'])) {
    $email = $_SESSION['email'];
    $submittedOtp = $_POST['digit1'] . $_POST['digit2'] . $_POST['digit3'] . $_POST['digit4'];
    $resetHandler = new PasswordResetHandler();
    if ($resetHandler->submitOtp($email, $submittedOtp)) {
        header('location:../../branch/auth-changepw.php');
        exit;
    } else {
        header('location:../../branch/auth-verification.php');
        exit;
    }
}

if (isset($_POST['changePassword'])) {
    $email = $_SESSION['email'];
    $resetHandler = new PasswordResetHandler();
    $newPassword = $_POST['new-password'];
    $confirmPassword = $_POST['confirm-password'];
    if ($resetHandler->changePassword($email, $newPassword, $confirmPassword)) {
        header('location:../../branch/auth-confirm-mail.php');
        exit;
    } else {
        header('location:../../branch/auth-changepw.php');
        exit;
    }
}
