<?php include 'layouts/session.php'; ?>
<!doctype html>
<html lang="en">

<head>

    <title><?= $_SESSION['site_name'] ?> - Admin</title>

    <?php include 'layouts/head.php'; ?>
    <link rel="stylesheet" href="../assets/libs/flatpickr/flatpickr.min.css">
    <?php include 'layouts/head-style.php'; ?>
    <style>
        .card-body {
            background: antiquewhite;
        }
    </style>

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
                    $title = 'Add Students';
                    ?>
                    <?php include 'layouts/breadcrumb.php'; ?>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">New Student Information</h4>
                                </div><!-- end card header -->
                                <div class="card-body">
                                    <form id="addForm" class="needs-validation" novalidate>
                                        <div class="row">
                                            <div class="col-sm-12 headinginfo h4 py-3 my-4">1. Branch/student Details</div>
                                            <div class="col-sm-12 col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Date Of Admission</label>
                                                    <input type="text" name="date_admission" placeholder="Please select Date Time" class="form-control" id="datepicker" required>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-4">
                                                <label for="branch">Branch<span class="asterisk"> *</span></label>
                                                <select class="form-select" id="branch" name="branch_id" required>
                                                    <option disabled selected>Select Branch</option>
                                                </select>
                                            </div>

                                            <div class="col-sm-12  col-md-4">
                                                <label>Branch Code</label>
                                                <input type="text" class="form-control" id="code" readonly>
                                            </div>

                                            <div class="col-sm-12 headinginfo h4 py-3 my-4">1. Course Details
                                            </div>

                                            <div class="col-sm-12 col-md-4">
                                                <div class="mb-3">
                                                    <label>Course<span class="asterisk"> *</span></label>
                                                    <select class="form-select" name="course_name" id="course">
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-4">
                                                <label>Course Code*</label>
                                                <input type="text" class="form-control" id="course_code" readonly>
                                            </div>

                                            <div class="col-sm-12 col-md-4">
                                                <label>Course Duration  *</label>
                                                <input type="text" class="form-control" id="cduration" readonly>
                                            </div>


                                            <div class="col-sm-12 col-md-4">
                                                <label>Course Fee *</label>
                                                <input type="text" class="form-control" id="total_fee" readonly>
                                            </div>

                                            <div class="col-sm-12 col-md-4">
                                                <label>Course Type *</label>
                                                <input type="text" class="form-control" id="course_type" readonly>
                                            </div>

                                            <div class="col-sm-12 col-md-4">
                                                <label>Eligibility *</label>
                                                <input type="text" class="form-control" id="eligibility" readonly>
                                            </div>

                                            <div class="col-sm-12 headinginfo h4 py-3 my-4">2. Basic Information</div>

                                            <div class="col-sm-12 col-md-4">
                                                <div class="mb-3">
                                                    <label>Student Name<span class="asterisk">*</span></label>
                                                    <input name="student_name" class="form-control" type="text" placeholder="Student Name" required>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-4">
                                                <div class="mb-3">
                                                    <label>Father's Name<span class="asterisk">*</span></label>
                                                    <input name="father_name" class="form-control" type="text" placeholder="Father's Name" required>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-4">
                                                <div class="mb-3">
                                                    <label>Father's Occupation</label>
                                                    <input name="father_occupation" class="form-control" type="text" placeholder="Father's Occupation">
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-4">
                                                <div style="font-weight:700;margin-bottom:5px;">Date of Birth (dd/mm/YYYY)<span class="asterisk">*</span></div>
                                                <input type="text" name="student_dob" class="form-control" data-input id="dob" placeholder="Please select Date Time" required>
                                            </div>

                                            <div class="col-sm-12 col-md-4">
                                                <div class="mb-3">
                                                    <label>Mobile Number<span class="asterisk">*</span></label>
                                                    <input type="text" name="student_phone" class="form-control valid" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '');" placeholder="Mobile Number" required>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-4 ">
                                                <label>Gender</label>
                                                <div class="my-2">
                                                    <label class="form-check form-check-inline"><input type="radio" name="gender" value="Male" checked> Male</label>
                                                    <label class="form-check form-check-inline"><input type="radio" name="gender" value="Female"> Female</label>
                                                    <label class="form-check form-check-inline"><input type="radio" name="gender" value="Transgender"> Transgender</label>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-4">
                                                <div class="mb-3 mt-3">
                                                    <label>Upload Photo<span class="asterisk">*</span></label>
                                                    <input class="form-control" name="profile_image" type="file" id="profile_image" accept="image/*" required>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-4">
                                                <div class="row">
                                                    <div class="col-sm-7" id="spreview">
                                                        <img src="" alt="Preview" style="max-width: 150px; max-height: 150px; display: none;" id="imagePreview">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 headinginfo h4 py-3 my-4">3. Contact Information</div>

                                            <div class="col-sm-12 col-md-4">
                                                <div class="mb-3">
                                                    <label>Address (Line1)<span class="asterisk">*</span></label>
                                                    <input type="text" name="address1" class="form-control" id="address1" placeholder="Address (Line1)" required>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-4">
                                                <div class="mb-3">
                                                    <label>Address (Line2)<span class="asterisk"></span></label>
                                                    <input type="text" name="address2" class="form-control" id="address2" placeholder="Address (Line2)">
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-4">
                                                <div class="mb-3">
                                                    <label>State<span class="asterisk">*</span></label>
                                                    <select class="form-select" name="student_state" id="state" required>
                                                        <option value="" disabled selected>Select State</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-4">
                                                <div class="mb-3">
                                                    <label>District <span class="asterisk">*</span></label>
                                                    <select class="form-select" name="student_district" id="district">
                                                        <option selected disabled>Select District</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-4">
                                                <div class="mb-3">
                                                    <label>Email<span class="asterisk"></span></label>
                                                    <input name="student_email" class="form-control" type="email" placeholder="Email">
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-4">
                                                <div class="mb-3">
                                                    <label>Whatsapp Number<span class="asterisk">*</span></label>
                                                    <input type="text" name="student_whatsapp_phone" class="form-control valid" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 headinginfo h4 py-3 my-4">4. Educational Qualification</div>
                                            <div class="row">
                                                <div class="col-3 mb-3">
                                                    <label>Education</label>
                                                    <select name="qualification" class="form-control" id="level">
                                                        <!-- <option selected disabled>Student Education</option> -->
                                                    </select>
                                                </div>
                                                <div class="col-3 mb-3">
                                                    <label>Board/University</label>
                                                    <input type="text" class="form-control" name="board_university" placeholder="Board/University">
                                                </div>
                                                <div class="col-3 mb-3">
                                                    <label>Year of Passing</label>
                                                    <input type="number" class="form-control" name="year_of_passing" placeholder="Year of Passing" max="<?= date("Y") ?>">
                                                </div>
                                                <div class="col-3 mb-3">
                                                    <label>Percentage (%)</label>
                                                    <input type="number" class="form-control" name="percentage" placeholder="Percentage (%)" max="100">
                                                </div>

                                                <div class="col-sm-12 mb-3">
                                                    <label>Professional Qualification</label>
                                                    <input type="text" class="form-control" name="pqualification" placeholder="Professional Qualification" id="quli">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-start gap-3 mt-4">
                                            <button type="submit" name="addbtn" class="btn btn-primary w-sm ms-auto">Submit</button>
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
    <div id="loader-container" class="justify-content-center align-items-center" style="display:none;position: fixed;top: 0;left: 0;width: 100%;height: 100%;background: rgb(0 0 0 / 80%);z-index: 9999;">
        <button class="btn btn-primary" type="button" disabled>
            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
            <span class="visually-hidden">Loading...</span>
            <span id="uploadPercentage">0%</span>
        </button>
    </div>

    <!-- Right Sidebar -->
    <a id="right-bar-toggle"></a>
    <?php include 'layouts/vendor-scripts.php'; ?>

    <!-- Sweet alert init js-->
    <script src="../assets/js/app.js"></script>
    <script src="../assets/js/pages/form-validation.init.js"></script>
    <script src="../assets/libs/flatpickr/flatpickr.min.js"></script>
    <script src="../ajax/js/fetch.js"></script>
    <script src="../ajax/js/extra.js"></script>
    <script>
        $(document).ready(function() {
            // Fetch cities and states and Course and level
            fetchBranches();
            fetchStates();
            fetchCourse();
            fetchlevel();

            $("#addForm").on("submit", function(e) {
                e.preventDefault();

                var isValid = true;
                var firstInvalidField = null;

                $(this).find(":input[required]").each(function() {
                    if (!$(this).val().trim()) {
                        isValid = false;
                        $(this).addClass("is-invalid");

                        // If the first invalid field is not set, set it to the current field
                        if (firstInvalidField === null) {
                            firstInvalidField = $(this).attr("name");
                        }
                    } else {
                        $(this).removeClass("is-invalid");
                    }
                });

                // If any required field is not filled, show an alert with the first unfilled field name
                if (!isValid) {
                    alert("Please fill in all required fields. The field '" + firstInvalidField + "' is required.");
                    return;
                }

                const formData = new FormData(this);
                formData.append("action", "addStudent");

                $.ajax({
                    url: "../php/controller/studentController.php",
                    type: 'POST',
                    dataType: "json",
                    data: formData,
                    contentType: false,
                    processData: false,
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(e) {
                            if (e.lengthComputable) {
                                var percentComplete = (e.loaded / e.total) * 100;
                                $("#uploadPercentage").text('UPLOADING ' + percentComplete.toFixed(2) + '%')
                            }
                        }, false);
                        return xhr;
                    },
                    beforeSend: function() {
                        $('#loader-container').css("display", "flex");
                    },
                    success: function(response) {
                        console.log(response);
                        alert(response.message);
                        $('#loader-container').hide();
                        if (response.status === 'success') {
                            window.location.href = "manage-students.php";
                            $("#addForm").trigger("reset");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("Error occurred while uploading file" + error)
                    },
                    complete: function() {
                        $('#loader-container').hide();
                    }
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

            flatpickr('#datepicker', {
                maxDate: 'today',
                defaultDate: 'today',
            });

            $("#dob").flatpickr({
                dateFormat: "Y-m-d",
                maxDate: 'today',
                defaultDate: '2002-06-28',
            });
        });
    </script>
</body>

</html>