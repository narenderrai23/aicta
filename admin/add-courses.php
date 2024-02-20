<?php include 'layouts/session.php'; ?>
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
                    $title = 'Course';
                    ?>
                    <?php include 'layouts/breadcrumb.php'; ?>
                    <!-- end page title -->
                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4" style="text-align: center;">Add Course</h4>
                                    <form id="addForm">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="ccat">Course Category<span class="redTxt">*</span></label>
                                                <select class="form-select" id="ccat" name="course_category">
                                                    <option value="" disabled selected>Select Course Category</option>
                                                </select>
                                            </div>


                                            <div class="col-md-6 mb-3">
                                                <label for="basic-url">Course Duration <span class="redTxt"> *</span></label>
                                                <div class="input-group mb-3">
                                                    <input class="form-control" type="number" id="cduration" maxlength="3" name="course_duration">
                                                    <div class="input-group-prepend">
                                                        <select class="form-select" id="durationtime" name="duration_time">
                                                            <option value="Days">Days</option>
                                                            <option value="Months">Months</option>
                                                            <option value="Year">Year</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="shortnm">Course Code<span class="redTxt">*</span></label>
                                                <input class="form-control" type="text" id="shortnm" name="course_code" style="text-transform: uppercase;" required>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <div class="">
                                                    <label for="course_name">Course Name<span class="redTxt">*</span></label>
                                                    <input class="form-control" type="text" id="course_name" name="course_name">
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="tfee">Total Fee ( ₹ )</label>
                                                <input class="form-control" type="number" id="total_fee" name="total_fee" placeholder="( ₹ )">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="eligible">Eligibility</label>
                                                <input class="form-control" type="text" id="eligible" name="eligibility">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="ctypemst">Course Type<span class="redTxt">*</span></label>
                                                <select class="form-select" id="course_type" name="course_type">
                                                    <option value="">Select Course Category</option>
                                                    <option value="Career Programs">Career Programs</option>
                                                    <option value="Professional Course">Professional Course</option>
                                                    <option value="Short-Term Programs">Short-Term Programs</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="odetail">Other Details</label>
                                                <textarea id="odetail" class="form-control" name="other_details" rows="5"></textarea>
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
        fetchCategory();
        $("#ccat").change(function() {
            var id = $("#ccat").val();
        });

        $("#addForm").on("submit", function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append("action", "addCourse");
            ajax("../php/controller/courseController.php", formData, function(response) {
                console.log(response);
                alert(response.message);
                if (response.status === 'success') {
                    // $("#addForm").trigger("reset");
                    window.location.href = "manage-courses.php";

                }
            });
        });
    </script>

</body>

</html>