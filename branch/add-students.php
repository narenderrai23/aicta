<?php include 'layouts/session.php'; ?>
<!doctype html>
<html lang="en">

<head>

    <title><?= $_SESSION['site_name'] ?> - Admin</title>

    <?php include 'layouts/head.php'; ?>
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
                                    <h4 class="card-title mb-0">Add Students</h4>
                                </div><!-- end card header -->
                                <div class="card-body">
                                    <form id="addForm" class="needs-validation" novalidate>
                                        <div class="container px-5">
                                            <div class="col-sm-12 headinginfo">Branch/Course Details / शाखा / कोर्स
                                                विवरण</div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label>Date of Admission / प्रवेश दिनांक <span class="asterisk">*</span></label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="text" name="date_admission" class="form-control" placeholder="Please select Date Time" id="datepicker" required>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label>Course<span class="asterisk"> *</span></label>
                                                </div>
                                                <div class="col-sm-8 px-1">
                                                    <select name="course_name" id="course"></select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label>Course Code</label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="course_code" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label>Course Duration</label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="cduration" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                              

                                                <div class="col-lg-6">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label>Course Type</label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="course_type" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label>Eligibility</label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="eligibility" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="col-sm-12 headinginfo">Basic Information / मूलभूत जानकारी
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label>Student Name<span class="asterisk">*</span></label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input name="student_name" class="form-control" type="text" placeholder="Student Name" required>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label>Father's Name<span class="asterisk">*</span></label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input name="father_name" class="form-control" type="text" placeholder="Father's Name" required>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label>Father's Occupation</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input name="father_occupation" class="form-control" type="text" placeholder="Father's Occupation">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div style="font-weight:700;margin-bottom:5px;">Date of Birth
                                                        (dd/mm/YYYY)<span class="asterisk">*</span></div>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="text" name="student_dob" class="form-control" data-input id="dob" placeholder="Please select Date Time" required>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label>Gender</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="form-control-sm">
                                                        <label class="d-inline-flex me-2"><input type="radio" name="gender" class="me-1" value="Male" checked>
                                                            Male</label>
                                                        <label class="d-inline-flex me-2"><input type="radio" name="gender" class="me-1" value="Female">
                                                            Female</label>
                                                        <label class="d-inline-flex me-2"><input type="radio" name="gender" class="me-1" value="Transgender">
                                                            Transgender</label>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label>Mobile Number<span class="asterisk">*</span></label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="text" name="student_phone" class="form-control valid" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '');" placeholder="Mobile Number" required>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label>Upload Photo<span class="asterisk">*</span></label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input class="form-control" name="profile_image" type="file" id="profile_image" accept="image/*" required>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-7" id="spreview">
                                                    <img src="" alt="Preview" style="max-width: 150px; max-height: 150px; display: none;" id="imagePreview">
                                                </div>
                                            </div>

                                            <div class="col-sm-12 headinginfo">Contact Information / संपर्क विवरण</div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label>Address (Line1)<span class="asterisk">*</span></label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="text" name="address1" class="form-control" id="address1" placeholder="Address (Line1)" required>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label>Address (Line2)<span class="asterisk"></span></label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="text" name="address2" class="form-control" id="address2" placeholder="Address (Line2)">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label>State<span class="asterisk">*</span></label>
                                                </div>
                                                <div class="col-sm-8 px-1">
                                                    <select class="form-select" name="student_state" id="state" required>
                                                        <option value="">Select State</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label>District <span class="asterisk">*</span></label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <select class="form-select" name="student_district" id="district">
                                                        <option value="0" selected disabled>Select District</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label>Whatsapp Number<span class="asterisk">*</span></label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="text" name="w_phone" class="form-control valid" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label>Student Email<span class="asterisk"></span></label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input name="student_email" class="form-control" type="email" placeholder="Email">
                                                </div>
                                            </div>


                                            <div class="col-sm-12 headinginfo">Educational Qualification / शैक्षिक
                                                योग्यता</div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label>Highest Qualification</label>
                                                </div>
                                                <div class="col-sm-8 px-1">
                                                    <select name="qualification" class="form-select" id="level"></select>
                                                </div>
                                            </div>

                                            <div class="row">

                                                <div class="col-sm-4">
                                                    <label>Board/ University</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="board_university" placeholder="Board/University">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label>Year of Passing</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="number" class="form-control" name="year_of_passing" placeholder="Year of Passing" max="<?= date("Y") ?>">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label>Percentage (%)</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="number" class="form-control" name="percentage" placeholder="Percentage (%)" max="100">
                                                </div>
                                            </div>

                                            <div class="col-sm-12 headinginfo">Professional Qualification / व्यावसायिक
                                                योग्यता</div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label>Professional Qualification</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input name="pqualification" class="form-control" placeholder="Professional Qualification" type="text" id="quli">
                                                </div>
                                            </div>

                                            <div class="row py-3">
                                                <span>
                                                    I declare that all the information given by me in this form is
                                                    correct to the best of my knowledge
                                                    and belief.
                                                    I also assure that if any of the above statements are found to be
                                                    false, then I am liable to be
                                                    disqualified and my admission can be canceled.
                                                </span>
                                                <br>
                                                <span>
                                                    मैं इस बात की घोषणा करता/करती हूं कि मेरे द्वारा इस फॉर्म में दी गई
                                                    सभी जानकारी मेरे ज्ञान और
                                                    विश्वास के अनुसार सही है। मैं यह भी आश्वस्त कराता हु कि यदि उपरोक्त
                                                    कथनों में से कोई भी कथन
                                                    गलत पाया जाता है तो मैं अयोग्य घोषित होने के लिए उत्तरदायी हूं और
                                                    मेरा प्रवेश रद्द किया जा
                                                    सकता है।
                                                </span>
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

    <a id="right-bar-toggle"></a>


    <div id="loader-container" class="justify-content-center align-items-center" style="display:none;position: fixed;top: 0;left: 0;width: 100%;height: 100%;background: rgb(0 0 0 / 80%);z-index: 9999;">
        <button class="btn btn-primary" type="button" disabled>
            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
            <span class="visually-hidden">Loading...</span>
            <span id="uploadPercentage">0%</span>
        </button>
    </div>


    <?php include 'layouts/vendor-scripts.php'; ?>

    <!-- Sweet alert init js-->
    <script src="../assets/js/app.js"></script>
    <script src="../assets/js/pages/form-validation.init.js"></script>
    <script src="../assets/libs/flatpickr/flatpickr.min.js"></script>
    <script src="../ajax/js/fetch.js"></script>
    <script src="../ajax/js/extra.js"></script>

    <script>
        $(document).ready(function() {

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
                        console.error(xhr.responseText);
                        console.error(status);
                        console.error(error);
                        alert("Error occurred while uploading file");
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
                minDate: new Date(Date.now() - 45 * 24 * 60 * 60 * 1000).toISOString(),
                defaultDate: 'today'
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