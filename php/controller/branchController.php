<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../model/branch.php');
$branchModel = new BranchModel;
if (isset($_POST['action'])) {

    if ($_POST['action'] === 'addBranch') {
        $data = $branchModel->addBranch();
        echo json_encode($data);
    }

    if ($_POST['action'] === 'editBranch') {
        $data = $branchModel->updateBranch();
        echo json_encode($data);
    }

    if ($_POST['action'] === 'fetchAllBranch') {
        $data = $branchModel->fetchAll('tblbranch');
        echo json_encode($data);
    }

    if ($_POST['action'] === 'SelectBranchCode') {
        $stateId = $_POST['state_id'];
        $BranchCode = $branchModel->getBranchCode($stateId);
        echo json_encode($BranchCode);
    }

    if ($_POST['action'] === 'updateProfileImage') {
        $response = updateAdminDataImage();
        echo json_encode($response);
    }

    if ($_POST['action'] === 'updateAdminData') {
        $response = $branchModel->update();
        echo json_encode($response);
    }

    if ($_POST['action'] === 'changePassword') {
        $oldPassword = $_POST['old-password'];
        $newPassword = $_POST['new-password'];
        $confirmPassword = $_POST['confirm-password'];
        $response = $branchModel->changePassword($oldPassword, $newPassword, $confirmPassword);
        echo json_encode($response);
    }

    if ($_POST['action'] === 'statusUpdate') {
        $id = $_POST['itemId'];
        $response = $branchModel->statusUpdate($id, 'tblbranch');
        echo json_encode($response);
    }
}

function updateAdminDataImage()
{
    global $branchModel;
    if (isset($_FILES['image'])) {
        $file = $_FILES['image'];

        // Handle file upload and get the path
        $uploadFolder = '../../assets/image/profile_admin/';
        $newName = uniqid('branch_image_');
        $imagePath = $branchModel->moveUploadedFile($file, $uploadFolder, $newName);

        if ($imagePath) {
            // Assuming you have a method in your AdminProfile class to handle the update
            return $branchModel->updateProfileImage($imagePath);
        } else {
            return ['status' => false, 'message' => 'Error: Failed to save the image.'];
        }
    } else {
        return ['status' => false, 'message' => 'Error: Image file not provided.'];
    }
}
