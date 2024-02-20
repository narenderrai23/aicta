<?php include 'layouts/session.php'; ?>

<?php

include('../php/model/course.php');

// Redirect to manage-courses.php if 'id' is not set
if (!isset($_GET['id'])) {
    header('Location: manage-courses.php');
    exit;
}

if (empty($_SESSION['loggedin'])) {
    header('Location: logout.php');
    exit;
}

$Course = new Course();
$id = $_GET['id'];
$data = $Course->fetchCourse($id);

if (empty($data->id)) {
    header('Location: manage-courses.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <title><?=$_SESSION['site_name']?> - Admin</title>

    <?php include 'layouts/head.php'; ?>

    <?php include 'layouts/head-style.php'; ?>

</head>


<body data-layout="vertical" data-sidebar="dark">

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php include 'layouts/menu.php'; ?>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <?php
                    $maintitle = $_SESSION['site_name'];
                    $title = 'Dashboard';
                    ?>
                    <?php include 'layouts/breadcrumb.php'; ?>
                    <!-- end page title -->
                    <div class="row">

                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <table border="1" class="table table-bordered mg-b-0">

                                        <tr align="center" class="table-warning">
                                            <td colspan="4" style="font-size:20px;color:blue">
                                                Course Details</td>
                                        </tr>

                                        <tr class="table-info">
                                            <th>Course Name</th>
                                            <td><?= $data->course_name; ?></td>
                                            <th>Course Email</th>
                                            <td><?= $data->course_category; ?></td>
                                        </tr>
                                        <tr class="table-warning">
                                           
                                            <th>head</th>
                                            <td><?= $data->course_code; ?></td>
                                        </tr>
                                        <tr class="table-danger">
                                            <th>Category</th>
                                            <td><?= $data->course_duration; ?>
                                                <?= $data->duration_time; ?></td>
                                            <th>Phone No.</th>
                                            <td><?= $data->total_fee; ?></td>
                                        </tr>

                                        <tr class="table-primary">
                                            <th>Password</th>
                                            <td><?= $data->eligibility; ?></td>
                                            <th>Valid Till Date</th>
                                            <td><?= $data->other_details; ?></td>
                                        </tr>

                                     

                                        <tr class="table-success">
                                            <th>Created</th>
                                            <td><?= $data->created_at; ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <?php include 'layouts/footer.php'; ?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

   <!-- Right Sidebar -->
<a id="right-bar-toggle"></a>

    <?php include 'layouts/vendor-scripts.php'; ?>

    <script src="../assets/js/app.js"></script>

</body>

</html>