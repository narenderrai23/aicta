<?php include 'layouts/session.php'; ?>

<?php

include('../php/model/course.php');

if (!isset($_GET['id'])) {
    header('Location: manage-branch.php');
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

<!doctype html>
<html lang="en">

<head>

    <title><?= $_SESSION['site_name'] ?> - Admin</title>

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
                    $maintitle =  $_SESSION['site_name'];
                    $title = 'Dashboard';
                    ?>
                    <?php include 'layouts/breadcrumb.php'; ?>
                    <!-- end page title -->
                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4" style="text-align: center;">Update Branch</h4>
                                    <form id="updateForm">
                                        <input class="form-control" type="hidden" name="id" value="<?= $data->id ?>" readonly>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="ccat">Course Category<span class="redTxt">*</span></label>
                                                    <select class="form-select" id="ccat" name="course_category"></select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="basic-url">Course Duration <span class="redTxt"> *</span></label>
                                                <div class="input-group mb-3">
                                                    <input class="form-control" type="number" id="cduration" name="course_duration" value="<?= $data->course_duration ?>">
                                                    <div class="input-group-prepend">
                                                        <select class="form-select" id="durationtime" name="duration_time">
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="shortnm">Course Code<span class="redTxt">*</span></label>
                                                    <input class="form-control" type="text" id="shortnm" name="course_code" value="<?= $data->course_code ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="cname">Course Name<span class="redTxt">*</span></label>
                                                    <input class="form-control" type="text" id="cname" name="course_name" value="<?= $data->course_name ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="tfee">Total Fee ( ₹ )</label>
                                                    <input class="form-control" type="number" id="tfee" name="total_fee" placeholder="( ₹ )" value="<?= $data->total_fee ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="eligible">Eligibility</label>
                                                    <input class="form-control" type="text" id="eligible" name="eligibility" value="<?= $data->eligibility ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="ctypemst">Course Type<span class="redTxt">*</span></label>
                                                    <select class="form-select" id="ctypemst" name="course_type">
                                                        <option>Select Course Category</option>
                                                    </select>

                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="odetail">Other Details</label>
                                                    <textarea id="odetail" class="form-control" name="other_details" rows="5"><?= $data->other_details ?></textarea>
                                                </div>
                                            </div>



                                            <div class="col-md-2" style="padding-top: 25px;">
                                                <button type="submit" class="btn bg-navy btn-primary btn-sm">Submit</button>
                                            </div>
                                        </div>
                                    </form>
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
    <script src="../assets/js/pages/form-validation.init.js"></script>
    <script src="../assets/js/app.js"></script>
    <script src="../ajax/js/fetch.js"></script>

    <script>
        function populateSelect(data, $select, selectedValue) {
            $.each(data, function(index, option) {
                $select.append($('<option>', {
                    value: option.value,
                    text: option.value
                }));
            });
            $select.val(selectedValue);
        }

        var optionsArray = [{
                value: "Career Programs"
            },
            {
                value: "Professional Course"
            },
            {
                value: "Short-Term Programs"
            }
        ];

        var durationtime = [{
                value: "Days"
            },
            {
                value: "Months"
            },
            {
                value: "Year"
            }
        ];

        var $select = $('#ctypemst');
        var $select1 = $('#durationtime');
        var Dropdown = $("#ccat");

        populateSelect(optionsArray, $select, "<?= $data->course_type ?>");
        populateSelect(durationtime, $select1, "<?= $data->duration_time ?>");


        Dropdown.change(function() {
            var id = Dropdown.val();
        });

        fetchCategory(<?= $data->course_category ?>);

        $("#updateForm").on("submit", function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append("action", "updateCourse");
            ajax("../php/controller/courseController.php", formData, function(response) {
                alert(response.message);
                console.log(response);
                if (response.status === 'success') {
                    window.location.href = "manage-courses.php";
                }
            });
        });
    </script>

</body>

</html>