<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('../model/city.php');

$cityController = new CityModel();
if (isset($_POST['action'])) {

    if ($_POST['action'] === 'addCity') {
        echo $cityController->insertCity();
    }

    if ($_POST['action'] === 'checkAvailability') {
        $cityCode = $_POST['city_code'];
        if ($cityController->isCityCodeExists($cityCode)) {
            $response = ['status' => true, 'color' => 'red', 'message' => 'City code already exists.'];
        } else {
            $response = ['status' => false, 'color' => 'green', 'message' => 'City code Available.'];
        }
        echo json_encode($response);
    }

    if ($_POST['action'] === 'updateCity') {
        echo $cityController->updateCity();
    }

    if ($_POST['action'] === 'fetchDistrict') {
        $stateId = $_POST['state_id'];
        $District = $cityController->getDistrictByState($stateId);
        echo json_encode($District);
    }

    if ($_POST['action'] === 'fetchCity') {
        $stateId = $_POST['state_id'];
        $cities = $cityController->getCitiesByState($stateId);
        echo json_encode($cities);
    }

    if ($_POST['action'] === 'SelectBranchCode') {
        $stateId = $_POST['state_id'];
        $cities = $cityController->getCitiesCodeByState($stateId);
        $lastedtblstudent = $cityController->getLastIDQuery('tblbranch');
        $BranchCode = $cities['city_code'] . date("Ymd") . ($lastedtblstudent + 1);
        echo json_encode($BranchCode);
    }
}
