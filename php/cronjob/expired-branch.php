<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../model/branch.php');
$BranchModel = new BranchModel;
if (isset($_POST['action'])) {
    if ($_POST['action'] === 'statusUpdate') {
        $id = $_POST['itemId'];
        $status = "deactive";
        $response = $BranchModel->statusUpdate($id, 'tblbranch', $status);
        echo json_encode($response);
    }
}
