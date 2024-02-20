<?php include 'layouts/session.php'; ?>
<!doctype html>
<html lang="en">

<head>
    <?= $_SESSION['site_name'] ?>
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
                    $maintitle =  $_SESSION['site_name'];
                    $title = 'Branch';
                    ?>
                    <?php include 'layouts/breadcrumb.php'; ?>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title" style="text-align: center;">Add Branch</h4>
                                    <form id="addForm" class="needs-validation" novalidate>
                                        <div class="row mb-4">
                                            <div class="col-lg-6 mb-4">
                                                <label>State</label>
                                                <select name="state" class="form-control state" required id="state">
                                                    <option selected disabled>Select State</option>
                                                </select>
                                            </div>

                                            <div class="col-lg-6 mb-4">
                                                <label>City</label>
                                                <select name="city" id="city" class="form-select select2" required>
                                                    <option selected disabled>Select City</option>
                                                </select>
                                            </div>

                                            <div class="col-lg-6 mb-4">
                                                <label>Branch Code</label>
                                                <input type="text" name="code" id="code" class="form-control" required readonly>
                                            </div>

                                            <div class="col-lg-6 mb-4">
                                                <label>Branch Name</label>
                                                <input type="text" name="name" class="form-control" required>
                                            </div>

                                            <div class="col-lg-6 mb-4">
                                                <label>Branch Head</label>
                                                <input type="text" name="head" class="form-control" required>
                                            </div>

                                            <div class="col-lg-6 mb-4">
                                                <label>Branch Category</label>
                                                <select name="category" id="category" class="form-control select2" required>
                                                    <option value="authorized">Authorized</option>
                                                    <option value="training">Training</option>
                                                    <option value="learning">Learning</option>
                                                </select>
                                            </div>

                                            <div class="col-lg-6 mb-4">
                                                <label>Mobile</label>
                                                <input type="text" name="phone" class="form-control valid" required maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                            </div>

                                            <div class="col-lg-6 mb-4">
                                                <label>Valid Till Date</label>
                                                <input type="date" name="till_date" id="date" class="form-control" required>
                                            </div>

                                            <div class="col-lg-6 mb-4">
                                                <label>Address</label>
                                                <textarea name="address" class="form-control" rows="4" required></textarea>

                                            </div>

                                            <div class="col-lg-6 mb-4">
                                                <label>Corresponding Address</label>
                                                <textarea name="corresponding_address" class="form-control" rows="5" required></textarea>
                                            </div>
                                        </div>
                                        <h3 class="mb-5">Login details</h3>
                                        <div class="row">
                                            <div class="col-lg-6 mb-4">
                                                <label>Email</label>
                                                <input type="email" name="email" class="form-control" required>
                                            </div>

                                            <div class="col-lg-6 mb-4">
                                                <label for="password">Password</label>
                                                <div class="input-group mb-3">
                                                    <input type="password" class="form-control" name="password" id="password" required>
                                                    <span class="input-group-text password-eye"><i class="fas fa-eye"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary mr-2" name="action" value="addBranch">Submit</button>
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

    <script src="../assets/js/app.js"></script>
    <script src="../assets/js/pages/form-validation.init.js"></script>


    <!-- datepicker js -->
    <script src="../assets/libs/flatpickr/flatpickr.min.js"></script>
    <script src="../ajax/js/fetch.js"></script>
    <script src="../ajax/js/extra.js"></script>
    <script>
        $(document).ready(function() {
            fetchStates();
            flatpickr('#date', {
                minDate: "today",
            });

            $("#state").change(function() {
                var stateId = $("#state").val();
                fetchCity(stateId);
            });


            $("#city").change(function() {
                var cityId = $("#city").val();
                fetchBranchCode(cityId);
            });

            new Choices("#category");

            function fetchBranchCode(cityId) {
                if (cityId) {
                    $.post("../php/controller/cityController.php", {
                        action: 'SelectBranchCode',
                        state_id: cityId
                    }, function(response) {
                        console.log(response);
                        $("#code").val(response);
                    }, "json");
                }
            }

            $("#addForm").on("submit", function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                formData.append("action", "addBranch");
                ajax("../php/controller/branchController.php", formData, function(response) {
                    console.log(response);
                    alert(response.message);
                    if (response.status === 'success') {
                        // $("#addForm").trigger("reset");
                        window.location.href = "manage-branch.php";
                    }
                });
            });
        });
    </script>

</body>

</html>