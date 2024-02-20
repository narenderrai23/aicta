<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('../model/datatable.php');
$dataTables = new DataTablesHandler();

if (isset($_POST['action'])) {
    if ($_POST['action'] === 'fetchStudents') {
        $tableName = 'students';
        $columns = ['id', 'enrollment', 'student_name', 'father_name', 'student_email', 'approve', 'date_admission', 'student_status'];
        $count = ['courses.course_code', 'tblbranch.name AS branch_name'];
        $join = [
            "tblbranch" => ["id", "branch_id"],
            "courses" => ["id", "course"]
        ];
        echo $dataTables->fetchData($tableName, $columns, false, $count, $join);
    }

    if ($_POST['action'] === 'fetchStudentsOld') {
        $tableName = 'student_mst';
        $columns = ['id', 'enrollment', 'student_name', 'father_name', 'student_email', 'student_status', 'approve', 'date_admission'];
        $count = ['name', 'course_code', 'tblbranch.name AS branch_name'];
        $join = [
            'tblbranch' => ['id', 'branch_id'],
            'courses' => ['id', 'course_id']
        ];
        echo $dataTables->fetchData($tableName, $columns, false, $count, $join);
    }

    if ($_POST['action'] === 'fetchBranches') {
        $tableName = 'tblbranch';
        $columns = ['id', 'name', 'email', 'head', 'code', 'created', 'phone', 'till_date', 'created', 'status'];
        $count = ['students.branch_id'];
        $join = [
            "students" => ['branch_id', 'id']
        ];
        echo $dataTables->fetchData($tableName, $columns, true, $count, $join);
    }

    if ($_POST['action'] === 'fetchCities') {
        $tableName = 'cities';
        $columns = ['id', 'city_name', 'city_code', 'created_at'];
        $count = ['tblbranch.city_id', 'states.state_name'];
        $join = [
            "states" => ["id", "state"],
            "tblbranch" => ["city_id", "id"]
        ];
        echo $dataTables->fetchData($tableName, $columns, true, $count, $join);
    }

    if ($_POST['action'] === 'fetchCourses') {
        $tableName = 'courses';
        $columns = ['id', 'course_name', 'total_fee', 'course_duration', 'course_code', 'duration_time', 'created_at'];
        $count = ['students.course'];
        $join = [
            "students" => ['course', 'id'],
        ];
        echo $dataTables->fetchData($tableName, $columns, true, $count, $join);
    }

    if ($_POST['action'] === 'fetchCategory') {
        $tableName = 'course_category';
        $columns = ['id', 'name', 'created_at'];
        $count = ['courses.course_category'];
        $join = [
            "courses" => ['course_category', 'id']
        ];
        echo $dataTables->fetchData($tableName, $columns, true, $count, $join);
    }
}
