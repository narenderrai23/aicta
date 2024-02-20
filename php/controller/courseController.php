<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('../model/course.php');

if (isset($_POST['action'])) {
    $course = new Course();

    if ($_POST['action'] === 'addCourse') {
        $data = $course->insert();
        echo json_encode($data);
    }

    if ($_POST['action'] === 'updateCourse') {
        $id = $_POST['id'];
        $data = $course->update($id);
        echo json_encode($data);
    }

    if ($_POST['action'] === 'addCategory') {
        echo $course->insertCategory();
    }

    if ($_POST['action'] === 'updateCategory') {
        $response = $course->updateCategory();
        echo json_encode($response);
    }

    if ($_POST['action'] === 'fetchCourses') {
        $table = 'courses';
        $Records = $course->fetchAll($table);
        $response = array(
            "data" => $Records
        );
        echo json_encode($response);
    }

    if ($_POST['action'] === 'getCategorycode') {
        $id = $_POST['id'];
        $response = array(
            'data' => $course->fetch('course_category', '*', $id),
            'lastID' => ($course->getLastIDQuery('courses') + 1)
        );
        echo json_encode($response);
    }
}
