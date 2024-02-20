<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('../model/common.php');

$Common = new Common();

if (isset($_POST['action'])) {
    if ($_POST['action'] === 'deleteBranch') {
        $id = $_POST['itemId'];
        echo $Common->delete('tblbranch', 'id', $id);
    }

    if ($_POST['action'] === 'deleteCategory') {
        $id = $_POST['itemId'];
        echo $Common->delete('course_category', 'id', $id);
    }

    if ($_POST['action'] === 'deleteCity') {
        $id = $_POST['itemId'];
        echo $Common->delete('cities', 'id', $id);
    }

    if ($_POST['action'] === 'deleteCourses') {
        $id = $_POST['itemId'];
        echo $Common->delete('courses', 'id', $id);
    }

    if ($_POST['action'] === 'deleteStudent') {
        $id = $_POST['itemId'];
        echo $Common->delete('students', 'id', $id);
    }

    if ($_POST['action'] === 'oldDeleteStudent') {
        $id = $_POST['itemId'];
        echo $Common->delete('student_mst', 'id', $id);
    }

    if ($_POST['action'] === 'getCategory') {
        $id = $_POST['itemId'];
        $result = $Common->fetch('course_category', '*', $id);
        echo json_encode($result);
    }

    if ($_POST['action'] === 'getCourseName') {
        $id = $_POST['id'];
        $result = $Common->fetch('courses', '*', $id);
        echo json_encode($result);
    }

    if ($_POST['action'] === 'SelectCategory') {
        $table = 'course_category';
        $response = $Common->fetchAll($table);
        echo json_encode($response);
    }

    if ($_POST['action'] === 'SelectCourse') {
        $table = 'courses';
        $response = $Common->fetchAll($table);
        echo json_encode($response);
    }
}
