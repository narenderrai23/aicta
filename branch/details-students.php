<?php include 'layouts/session.php'; ?>

<?php
include('../php/model/students.php');

if (!isset($_GET['id'])) {
    header('Location: manage-students.php');
    exit;
}

if (empty($_SESSION['loggedin'])) {
    header('Location: logout.php');
    exit;
}

// print_r($_SESSION);

$Student = new Student();
$id = $_GET['id'];
$data = $Student->fetchStudentOld($id);
if (empty($data->id)) {
    header('Location: student.php');
    exit;
}

// echo "<pre>";
// print_r($data);
// die();

// die();


$a1 = $data->a_board;
$a2 = $data->a_year;
$a3 = $data->a_div;
$a4 = $data->a_per;
$b1 = $data->b_board;
$b2 = $data->b_year;
$b3 = $data->b_div;
$b4 = $data->b_per;
$c1 = $data->c_board;
$c2 = $data->c_year;
$c3 = $data->c_div;
$c4 = $data->c_per;
$d1 = $data->d_board;
$d2 = $data->d_year;
$d3 = $data->d_div;
$d4 = $data->d_per;


function profileImagePath($thumbimg)
{
    $str2 = explode("~", $thumbimg);
    $profile_image = str_replace("-", "/", $str2[0]) . "/$thumbimg";
    return $profile_image;
}

$profile_image = profileImagePath($data->profile_image);
?>

<!doctype html>
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
                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    <div class="justify-content-between d-flex align-items-center">
                                        <h6 class="mb-0">Student Information

                                        </h6>
                                        <button onclick="window.print();" class="btn btn-primary btn-sm">Print</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-4 col-12">
                                            <div class="card p-4 p-lg-0">
                                                <div class="row">
                                                    <div class="col-lg-12 col-4 px-lg-5 text-center">
                                                        <img src="../assets/profile_image/<?= $profile_image; ?>"
                                                            class="img-fluid rounded-start" style="max-height: 300px;">
                                                    </div>
                                                    <div class="col-lg-12 col-8">
                                                        <div class="card-body px-0">
                                                            <table class="table">
                                                                <tr>
                                                                    <td class="fw-bold">

                                                                        <i class="fas me-2 fa-user text-primary"></i>
                                                                        Name
                                                                    </td>
                                                                    <td>
                                                                        <span class="text-success">
                                                                            <?= $data->student_name; ?>
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="fw-bold">

                                                                        <i class="fas me-2 fa-id-card text-info"></i>
                                                                        Enrollment
                                                                    </td>
                                                                    <td>
                                                                        <span class="text-secondary">
                                                                            <?= $data->enrollment; ?>
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="fw-bold">

                                                                        <i class="fas me-2 fa-book text-danger"></i>
                                                                        Course
                                                                    </td>
                                                                    <td>
                                                                        <span class="text-warning">
                                                                            <?= $data->course_name; ?>
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="fw-bold">

                                                                        <i class="fas me-2 fa-phone text-info"></i>
                                                                        Student Phone
                                                                    </td>
                                                                    <td>
                                                                        <span class="text-primary">
                                                                            <?= $data->student_phone; ?>
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="fw-bold">

                                                                        <i
                                                                            class="fab me-2 fa-whatsapp text-success"></i>
                                                                        WhatsApp Phone
                                                                    </td>
                                                                    <td>
                                                                        <span class="text-secondary">
                                                                            <?= $data->w_phone; ?>
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="fw-bold">

                                                                        <i
                                                                            class="fas me-2 fa-calendar-alt text-danger"></i>
                                                                        Date Admission
                                                                    </td>
                                                                    <td>
                                                                        <span class="text-warning">
                                                                            <?= $data->date_admission; ?>
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="fw-bold">

                                                                        <i
                                                                            class="fas me-2 fa-calendar-alt text-info"></i>
                                                                        Date of Birth
                                                                    </td>
                                                                    <td>
                                                                        <span class="text-primary">
                                                                            <?= $data->student_dob; ?>
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <table border="1" class="table table-bordered mg-b-0">
                                                <tr align="center" class="table-warning">
                                                    <td colspan="4" style="font-size:20px;color:blue">
                                                        Student Details</td>
                                                </tr>

                                                <tr class="table-secondary">
                                                    <th>Branch Name</th>
                                                    <td>
                                                        <?= $data->branch_name; ?>
                                                    </td>
                                                    <th>Branch Code</th>
                                                    <td>
                                                        <?= $data->branch_code; ?>
                                                    </td>
                                                </tr>
                                                <tr class="table-primary">
                                                    <th>Course Fees</th>
                                                    <td>
                                                        <?= $data->total_fee; ?>
                                                    </td>
                                                </tr>

                                                <tr class="table-secondary">
                                                    <th>Course short name</th>
                                                    <td>
                                                        <?= $data->course_code; ?>
                                                    </td>
                                                    <th>Enrollment</th>
                                                    <td>
                                                        <?= $data->enrollment; ?>
                                                    </td>
                                                </tr>
                                                <tr class="table-primary">
                                                    <th>Student Email</th>
                                                    <td>
                                                        <?= $data->student_email; ?>
                                                    </td>
                                                    <th>Gender</th>
                                                    <td>
                                                        <?= $data->gender; ?>
                                                    </td>
                                                </tr>

                                                <tr class="table-secondary">
                                                    <th>Father Name</th>
                                                    <td>
                                                        <?= $data->father_name; ?>
                                                    </td>
                                                    <th>Father Occupation</th>
                                                    <td>
                                                        <?= $data->father_occupation; ?>
                                                    </td>
                                                </tr>
                                                <tr class="table-secondary">
                                                    <th>Address 1</th>
                                                    <td>
                                                        <?= $data->address1; ?>
                                                    </td>
                                                    <th>Address 2</th>
                                                    <td>
                                                        <?= $data->address2; ?>
                                                    </td>
                                                </tr>
                                                <tr class="table-primary">

                                                    <th>Student District</th>
                                                    <td>
                                                        <?= $data->student_district; ?>
                                                    </td>
                                                    <th>Qualification</th>
                                                    <td>
                                                        <?= $data->squalification; ?>
                                                    </td>
                                                </tr>

                                                <tr class="table-secondary">
                                                    <th>Student Status</th>
                                                    <td>
                                                        <?= $data->student_status; ?>
                                                    </td>
                                                    <th>Status</th>
                                                    <td>
                                                        <div class="form-check form-switch">
                                                            <input type="checkbox"
                                                                class="form-check-input switch_button"
                                                                data-id='<?= $id ?>' id="switch<?= $id ?>"
                                                                <?= ($data->status === 'active') ? 'checked' : '' ?>>
                                                            <label class="form-check-label" for="switch<?= $id ?>">
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>

                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <th class="frmlabel">
                                                            S.No.
                                                        </th>
                                                        <th class="frmlabel">
                                                            Education
                                                        </th>
                                                        <th class="frmlabel">
                                                            Board/University
                                                        </th>
                                                        <th class="frmlabel">
                                                            Year of Passing
                                                        </th>

                                                        <th class="frmlabel">
                                                            Percentage
                                                        </th>
                                                    </tr>


                                                    <tr>
                                                        <td>
                                                            1.
                                                        </td>
                                                        <td>
                                                            10th
                                                        </td>
                                                        <td>
                                                            <?= $data->a_board; ?>
                                                        </td>
                                                        <td>
                                                            <?= $b1; ?>
                                                        </td>

                                                        <td>
                                                            <?= $d1; ?>
                                                        </td>
                                                    </tr>


                                                    <tr>
                                                        <td>
                                                            2.
                                                        </td>
                                                        <td>
                                                            10+2
                                                        </td>
                                                        <td>
                                                            <?= $data->a_year; ?>
                                                        </td>
                                                        <td>
                                                            <?= $b2; ?>
                                                        </td>

                                                        <td>
                                                            <?= $d2; ?>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            3.
                                                        </td>
                                                        <td>
                                                            Graduation
                                                        </td>
                                                        <td>
                                                            <?= $data->a_div; ?>
                                                        </td>
                                                        <td>
                                                            <?= $b3; ?>
                                                        </td>

                                                        <td>
                                                            <?= $d3; ?>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            4.
                                                        </td>
                                                        <td>
                                                            Others
                                                        </td>
                                                        <td>
                                                            <?= $a4; ?>
                                                        </td>
                                                        <td>
                                                            <?= $b4; ?>
                                                        </td>

                                                        <td>
                                                            <?= $d4; ?>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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
    <script src="../ajax/js/fetch.js"></script>
    <script>
        $(".switch_button").change(function () {
            const itemId = $(this).data('id');
            const data = {
                itemId: itemId,
                action: 'statusUpdate'
            };
            const success = function (response) {
                console.log(response)
                if (response.status !== 'success') {
                    alert(response.message);
                }
            };
            const url = '../php/controller/studentController.php';
            performAjaxRequest(url, data, success);
        });
    </script>

</body>

</html>