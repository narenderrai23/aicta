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

$Student = new Student();
$id = $_GET['id'];
$data = $Student->fetchStudentOld($id);

if (empty($data->id)) {
    header('Location: student.php');
    exit;
}

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

    <title><?= $_SESSION['site_name'] ?> - Admin</title>

    <?php include 'layouts/head.php'; ?>

    <!-- datepicker css -->
    <link rel="stylesheet" href="../assets/libs/flatpickr/flatpickr.min.css">

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
                    $maintitle = "Forms";
                    $title = 'Students';
                    ?>
                    <?php include 'layouts/breadcrumb.php'; ?>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Update Student Information</h4>
                                </div><!-- end card header -->
                                <div class="card-body">
                                    <form id="updateForm" class="needs-validation" novalidate>
                                        <div class="row">
                                            <div class="col-sm-12 headinginfo h4 text-danger py-3 my-4">1.
                                                Branch/student Details</div>
                                            <div class="col-sm-12 col-md-4 mb-3">
                                                <label class="form-label">Date Of Admission</label>
                                                <input type="text" name="date_admission" value="<?= $data->date_admission ?>" placeholder="Please select Date Time" class="form-control" id="datepicker" required>
                                                <input type="hidden" name="id" value="<?= $id ?>" placeholder="Please select Date Time" class="form-control" id="datepicker" required>
                                            </div>

                                            <div class="col-sm-12 col-md-4 mb-3">
                                                <label>Branch</label>
                                                <select class="form-select" id="branch" name="branch_id" required></select>
                                            </div>

                                            <div class="col-sm-12  col-md-4">
                                                <label>Branch Code
                                                    <?= $data->branch_id ?>
                                                </label>
                                                <input type="text" value="<?= $data->branch_code ?>" class="form-control" id="code" readonly required>
                                            </div>

                                            <div class="col-sm-12 headinginfo h4 text-danger py-3 my-4">1. Course
                                                Details
                                            </div>

                                            <div class="col-sm-12 col-md-4 mb-3">
                                                <label>Course</label>
                                                <select class="form-select" name="course_name" id="course" required>
                                                    <option disabled>Select City</option>
                                                </select>
                                            </div>


                                            <div class="col-sm-12 col-md-4 mb-3">
                                                <label>Course Short Name*</label>
                                                <input type="text" class="form-control" id="course_code" value="<?= $data->course_code ?>" readonly required>
                                            </div>

                                            <div class="col-sm-12 headinginfo h4 text-danger py-3 my-4">2. Basic
                                                Information</div>

                                            <div class="col-sm-12 col-md-4 mb-3">
                                                <label>Student Name</label>
                                                <input name="student_name" value="<?= $data->student_name ?>" class="form-control" type="text" id="studentnm" required>
                                            </div>

                                            <div class="col-sm-12 col-md-4 mb-3">
                                                <label>Father's Name</label>
                                                <input name="father_name" value="<?= $data->father_name ?>" class="form-control" type="text" id="fathernm" required>
                                            </div>

                                            <div class="col-sm-12 col-md-4 mb-3">
                                                <label>Father's Occupation</label>
                                                <input name="father_occupation" value="<?= $data->father_occupation ?>" class="form-control" type="text" id="coccup" required>
                                            </div>

                                            <div class="col-sm-12 col-md-4 mb-3">
                                                <div style="font-weight:700;margin-bottom:5px;">Date of Birth
                                                    (dd/mm/YYYY)</div>
                                                <input type="text" name="student_dob" value="<?= $data->student_dob ?>" placeholder="Please select Date Time" class="form-control" data-input id="dob" required>
                                            </div>

                                            <div class="col-sm-12 col-md-4 mb-3">
                                                <label>Mobile Number</label>
                                                <input type="text" name="student_phone" value="<?= $data->student_phone ?>" class="form-control valid" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                                            </div>

                                            <div class="col-sm-12 col-md-4 mb-3 ">
                                                <label>Gender</label>
                                                <div class="my-1">
                                                    <label class="form-check form-check-inline">
                                                        <input type="radio" name="gender" value="male" <?= $data->gender === 'male' ? 'checked' : '' ?>> Male
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input type="radio" name="gender" value="female" <?= $data->gender === 'female' ? 'checked' : '' ?>> Female
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input type="radio" name="gender" value="transgender" <?= $data->gender === 'transgender' ? 'checked' : '' ?>>
                                                        Transgender
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-4 mb-3">
                                                <div class="mb-3 mt-3">
                                                    <label>Upload Photo</label>
                                                    <input class="form-control" name="profile_image" type="file" id="profile_image" accept="image/*" required>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-4 mb-3">
                                                <div class="row">
                                                    <div class="col-sm-7" id="spreview">
                                                        <img src="../assets/upload/<?= $data->profile_image ?>" alt="Preview" style="max-width: 150px; max-height: 150px;" id="imagePreview">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 headinginfo h4 text-danger py-3 my-4">3. Contact
                                                Information</div>

                                            <div class="col-sm-12 col-md-4 mb-3">
                                                <label>Address (Line1)</label>
                                                <input type="text" name="address1" value="<?= $data->address1 ?>" class="form-control" id="address1" required>
                                            </div>

                                            <div class="col-sm-12 col-md-4 mb-3">
                                                <label>Address (Line2)<span class="asterisk"></span></label>
                                                <input type="text" name="address2" value="<?= $data->address2 ?>" class="form-control" id="address2">
                                            </div>

                                            <div class="col-sm-12 col-md-4 mb-3">
                                                <label>State</label>
                                                <select class="form-select" name="student_state" id="state" required>
                                                    <option value="">Select State</option>
                                                </select>
                                            </div>

                                            <div class="col-sm-12 col-md-4 mb-3">
                                                <label>District </label>
                                                <select class="form-select" name="student_district" id="district" required>
                                                    <option value="">Select District</option>
                                                </select>
                                            </div>

                                            <div class="col-sm-12 col-md-4 mb-3">
                                                <label>Email<span class="asterisk"></span></label>
                                                <input name="student_email" value="<?= $data->student_email ?>" class="form-control" type="email" required>
                                            </div>

                                            <div class="col-sm-12 col-md-4 mb-3">
                                                <label>Whatsapp Number</label>
                                                <input type="text" name="w_phone" value="<?= $data->w_phone ?>" class="form-control valid" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                                            </div>


                                            <div class="col-sm-12 headinginfo h4 text-danger py-3 my-4">6. Others</div>

                                            <div class="col-md-4">
                                                <select name="student_status" class="form-select select2" id="student-status">
                                                    <option value="running">Running</option>
                                                    <option value="complete">Completed</option>
                                                    <option value="dropout">Drop Out</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-start gap-3 mt-4">
                                            <button type="submit" name="addbtn" value="<?= $data->addbtn ?>" class="btn btn-primary w-sm ms-auto">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div><!-- end col -->
                    </div><!-- end row -->

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
    <!-- form wizard init -->
    <script src="../assets/js/app.js"></script>
    <script src="../assets/js/pages/form-validation.init.js"></script>
    <!-- datepicker js -->
    <script src="../assets/libs/flatpickr/flatpickr.min.js"></script>
    <script src="../ajax/js/fetch.js"></script>
    <script src="../ajax/js/extra.js"></script>
    <script>
        $(document).ready(function() {
            $("#updateForm").on("submit", function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                formData.append("action", "oldUpdateStudent");
                ajax("../php/controller/studentController.php", formData, function(response) {
                    console.log(response)
                    alert(response.message);
                    // if (response.status === 'success') {
                    //     window.location.href = "student.php";
                    // }
                });
            });

            $("#state").change(function() {
                const id = $("#state").val();
                fetchDistrict(id)
            });

            $("#branch").change(function() {
                const id = $("#branch").val();
                fetchBranchCode(id);
            });

            $("#course").change(function() {
                const id = $("#course").val();
                fetchCourseCode(id);
            })

            $("#datepicker").flatpickr({
                dateFormat: "Y-m-d",
                defaultDate: '<?= $data->date_admission ?>'
            });

            $("#dob").flatpickr({
                dateFormat: "Y-m-d",
                defaultDate: '<?= $data->student_dob ?>'
            });

            var branchId = <?= $data->branch_id ?>;
            var studentState = '<?= $data->student_state ?>';
            var student_district = <?= $data->student_district ?>;
            var course = <?= $data->course_id ?>;



            if (branchId !== undefined && branchId !== null && branchId !== "") {
                fetchBranches(branchId);
            } else {
                fetchBranches();
            }

            if (studentState !== undefined && studentState !== null && studentState !== "") {
                fetchStates(studentState);
            } else {
                fetchStates();
            }

            if (student_district !== undefined && student_district !== null && student_district !== "") {
                fetchDistrict(studentState, student_district);
            } else {
                fetchDistrict(studentState, student_district);
            }


            if (course !== undefined && course !== null && course !== "") {
                fetchCourse(course);
            } else {
                fetchCourse();
            }

            $("#student-status").val("<?= $data->student_status ?>");
            new Choices('#student-status');
        });
    </script>

</body>

</html>