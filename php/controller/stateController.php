<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('../model/common.php');
$Common = new Common();
if (isset($_POST['action'])) {
    if ($_POST['action'] === 'fetchState') {
        $Commons = $Common->fetchAll('states');
        echo json_encode($Commons);
    }

    if ($_POST['action'] === 'fetchlevel') {
        $level = $Common->fetchAll('education_level');
        echo json_encode($level);
    }
}
