<?php
require_once 'connection.php';
require_once 'Mail.php';
class PasswordResetHandler
{
    protected $db;
    protected $myMailer;

    function __construct()
    {
        $this->db = new Connection();
        $this->myMailer = new MyMailer();
    }
    

    public function resetPassword($email)
    {
        // Validate email (you may want to add more validation)
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['otp_alert'] = 'Invalid email address';
            return false;
        }

        // Check if the email exists in your database
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT id FROM tblbranch WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $userExists = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userExists) {
            // Generate a unique OTP for password reset
            $otp = mt_rand(1000, 9999);

            // Store the OTP and timestamp in the database for the user
            $updateOtpSql = "UPDATE tblbranch SET reset_otp = :reset_otp, reset_otp_timestamp = NOW() WHERE email = :email";
            $updateOtpStmt = $conn->prepare($updateOtpSql);
            $updateOtpStmt->bindParam(':reset_otp', $otp, PDO::PARAM_INT);
            $updateOtpStmt->bindParam(':email', $email, PDO::PARAM_STR);
            $updateOtpStmt->execute();

            // Send an email with the OTP using MyMailer
            $subject = 'Password Reset OTP';
            $body = "Your One-Time Password (OTP) for password reset is: $otp";
            $mailResult = $this->myMailer->sendMail($email, $subject, $body);

            if ($mailResult === true) {
                $_SESSION['email'] = $email;
                $_SESSION['otp_alert'] = 'Password reset OTP sent to your email.';
                return true;
            } else {
                $_SESSION['otp_alert'] = $mailResult;
                return false;
            }
        } else {
            $_SESSION['otp_alert'] = 'Email not found in the database.';
            return false;
        }
    }


    public function submitOtp($email, $submittedOtp)
    {
        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['otp_alert'] = 'Invalid email address.' . $email;
            return false;
        }

        // Validate OTP
        if (!is_numeric($submittedOtp)) {
            $_SESSION['otp_alert'] = 'Invalid OTP. Please enter a numeric OTP.';
            return false;
        }

        // Check if the email exists in your database
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT reset_otp, reset_otp_timestamp FROM tblbranch WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userData) {
            $storedOtp = $userData['reset_otp'];
            $otpTimestamp = strtotime($userData['reset_otp_timestamp']);
            $currentTimestamp = time();

            // Validate OTP and check if it's still valid (e.g., within a certain time window)
            if ($submittedOtp == $storedOtp && ($currentTimestamp - $otpTimestamp) <= 300) {

                if (($currentTimestamp - $otpTimestamp) <= 300) {
                    $_SESSION['otp_alert'] = 'OTP verified successfully.';
                    return true;
                } else {
                    $_SESSION['otp_alert'] = 'Expired OTP. Please request a new one.';
                    return false;
                }
            } else {
                $_SESSION['otp_alert'] = 'Invalid OTP.';
                return false;
            }
        } else {
            $_SESSION['otp_alert'] = 'Email not found in the database.';
            return false;
        }
    }


    function changePassword($email, $newPassword, $confirmPassword)
    {

        // Validate passwords
        if (empty($newPassword) || empty($confirmPassword)) {
            $_SESSION['otp_alert'] = 'All password fields are required.';
            return false;
        }

        if ($newPassword !== $confirmPassword) {
            $_SESSION['otp_alert'] = 'New password and confirm password do not match.';
            return false;
        }

        // Fetch the current password from the database
        $conn = $this->db->getConnection();

        // Hash and update the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateSql = "UPDATE tblbranch SET password = :password WHERE email = :email";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bindParam(':email', $email, PDO::PARAM_STR);
        $updateStmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);

        if ($updateStmt->execute()) {
            $_SESSION['otp_alert'] = 'Password updated successfully.';
            return true;
        } else {
            $_SESSION['otp_alert'] = 'Error updating password.';
            return false;
        }
    }
}
