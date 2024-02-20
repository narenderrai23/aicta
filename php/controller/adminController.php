<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../model/admin.php');
$admin = new AdminProfile;

if (isset($_POST['action'])) {
    if ($_POST['action'] === 'updateProfileImage') {
        $response = updateAdminDataImage();
        echo json_encode($response);
    }

    if ($_POST['action'] === 'updateAdminData') {
        $response = $admin->update();
        echo json_encode($response);
    }

    if ($_POST['action'] === 'changePassword') {
        $oldPassword = $_POST['old-password'];
        $newPassword = $_POST['new-password'];
        $confirmPassword = $_POST['confirm-password'];
        $response = $admin->changePassword($oldPassword, $newPassword, $confirmPassword);
        echo json_encode($response);
    }
}

function updateAdminDataImage()
{
    global $admin;
    if (isset($_FILES['image'])) {
        $file = $_FILES['image'];
        // Handle file upload and get the path
        $uploadFolder = '../../assets/image/profile_admin/';
        $newName = uniqid('admin_image_');
        $imagePath = $admin->moveUploadedFile($file, $uploadFolder, $newName);

        if ($imagePath) {
            // Assuming you have a method in your AdminProfile class to handle the update
            return $admin->updateProfileImage($imagePath);
        } else {
            return ['status' => false, 'message' => 'Error: Failed to save the image.'];
        }
    } else {
        return ['status' => false, 'message' => 'Error: Image file not provided.'];
    }
}
