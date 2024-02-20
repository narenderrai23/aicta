<?php include 'layouts/session.php'; ?>

<?php
include('../php/model/city.php');
if (!isset($_GET['id'])) {
    header('Location: manage-branch.php');
    exit;
}

if (empty($_SESSION['loggedin'])) {
    header('Location: logout.php');
    exit;
}

$CityModel = new CityModel();
$id = $_GET['id'];
$data = $CityModel->fetch('cities', '*', $id);
if (empty($data['id'])) {
    header('Location: manage-branch.php');
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

                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->


            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title" style="text-align: center;">Add Branch</h4>
                            <form id="updateForm" class="needs-validation" novalidate>
                                <input type="hidden" name="id" value="<?= $data['id'] ?>" class="form-control" required>
                                <label>City Code</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="city_code" name="city_code" class="form-control" value="<?= $data['city_code'] ?>" aria-required="true" spellcheck="false" data-ms-editor="true" aria-invalid="false" maxlength="3" style="text-transform: uppercase;" required>
                                    <div class="input-group-append">
                                        <span class="btn btn-dark" id="availablity">Check Availability</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 mb-4">
                                        <label>City Name</label>
                                        <input type="text" name="city_name" class="form-control" value="<?= $data['city_name'] ?>" required>
                                    </div>

                                    <div class="col-lg-6 mb-4">
                                        <label for="State">Select State</label>
                                        <select name="state" id="state" class="form-control" required='true'></select>
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
        fetchStates(<?= $data['state'] ?>);
        $("#availablity").click(function() {
            var cityCode = $("#city_code").val();
            const data = {
                'action': 'checkAvailability',
                'city_code': cityCode
            };
            const success = function(response) {
                const borderColor = response.status ? 'red' : 'green';
                $('#city_code').css('border-color', borderColor);
                $('#availablity').css('background', borderColor);
            }
            const url = '../php/controller/cityController.php';
            performAjaxRequest(url, data, success);
        });

        $("#updateForm").on("submit", function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append("action", "updateCity");
            ajax("../php/controller/cityController.php", formData, function(response) {
                alert(response.message);
                console.log(response);
                if(response.status === true){
                    window.location.href = "manage-cities.php";
                }
            });
        });
    </script>

</body>

</html>