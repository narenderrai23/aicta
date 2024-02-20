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
                    $title = 'City';
                    ?>
                    <?php include 'layouts/breadcrumb.php'; ?>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title" style="text-align: center;">Add City</h4>
                                    <form id="addForm" class="needs-validation" novalidate>
                                        <label>City Code</label>
                                        <div class=" mb-3">
                                            <div class="input-group">
                                                <input type="text" id="city_code" name="city_code" class="form-control" aria-required="true" spellcheck="false" data-ms-editor="true" aria-invalid="false" maxlength="3" style="text-transform: uppercase;" required>
                                                <div class="input-group-append">
                                                    <span class="btn btn-dark" id="availablity">Check Availability</span>
                                                </div>
                                            </div>
                                            <span class="message"></span>
                                        </div>


                                        <div class="row">
                                            <div class="col-lg-6 mb-4">
                                                <label>City Name</label>
                                                <input type="text" name="city_name" class="form-control" required>
                                            </div>

                                            <div class="col-lg-6 mb-4">
                                                <label>State</label>
                                                <select class="form-select" name="state" id="state" required>
                                                    <option value="">Select State</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mt-4 text-center d-md-table">
                                            <button class="btn btn-success btn-block loginbtn" type="submit">Add City</button>
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

    <script src="../assets/js/app.js"></script>
    <script src="../ajax/js/fetch.js"></script>
    <script>
        fetchStates();

        $("#availablity").click(function() {
            var cityCode = $("#city_code").val();
            const data = {
                'action': 'checkAvailability',
                'city_code': cityCode
            };
            const success = function(response) {
                $('#city_code').css('border-color', response.color);
                $('#availablity').css('background', response.color);
                $(".message").text(response.message).css('color', response.color);
            }
            const url = '../php/controller/cityController.php';
            performAjaxRequest(url, data, success);
        });

        $("#addForm").on("submit", function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append("action", "addCity");
            ajax("../php/controller/cityController.php", formData, function(response) {
                console.log(response);
                alert(response.message);
                if (response.status) {
                    // $("#addForm").trigger("reset");
                    window.location.href = "manage-cities.php";
                }
            });
        });
    </script>

</body>

</html>