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

        <div class="main-content">
            <div class="page-content">
                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div id="alerts-container"></div>
                            <div class="page-title-box">
                                <h4 class="page-title">UPLOAD EXCEL</h4>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <h4 class="card-title mb-0">Upload Branch Excel File:</h4>
                                                <a href="../assets/demo_excel/branch_excel.xlsx" download="branch_excel.xlsx"
                                                    class="btn btn-sm btn-info">Demo Import</a>
                                            </div>
                                            <div class="card-body">
                                                <form action="../php/helper/importerController.php" method="POST"
                                                    enctype="multipart/form-data">
                                                    <input type="file" name="import_file" class="form-control"
                                                        accept=".xls, .xlsx" required />
                                                    <button type="submit" name="table" value="tblbranch"
                                                        class="btn btn-primary mt-3">Import</button>
                                                </form>
                                            </div> <!-- end card-body -->
                                        </div> <!-- end card -->

                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <h4 class="card-title mb-0">Upload Courses Excel File:</h4>
                                                <a href="../assets/demo_excel/course_excel.xlsx" download="course_excel.xlsx"
                                                    class="btn btn-sm btn-info">Demo Import</a>
                                            </div>
                                            <div class="card-body">
                                                <form action="../php/helper/importerController.php" method="POST"
                                                    enctype="multipart/form-data">
                                                    <input type="file" name="import_file" class="form-control"
                                                        accept=".xls, .xlsx" required />
                                                    <button type="submit" name="table" value="courses"
                                                        class="btn btn-primary mt-3">Import</button>
                                                </form>
                                            </div> <!-- end card-body -->
                                        </div> <!-- end card -->

                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <h4 class="card-title mb-0">Upload Cities Excel File:</h4>
                                                <a href="../assets/demo_excel/city_excel.xlsx" download="city_excel.xlsx"
                                                    class="btn btn-sm btn-info">Demo Import</a>
                                            </div>
                                            <div class="card-body">
                                                <form action="../php/helper/importerController.php" method="POST"
                                                    enctype="multipart/form-data">
                                                    <input type="file" name="import_file" class="form-control"
                                                        accept=".xls, .xlsx" required />
                                                    <button type="submit" name="table" value="cities"
                                                        class="btn btn-primary mt-3">Import</button>
                                                </form>
                                            </div> <!-- end card-body -->
                                        </div> <!-- end card -->
                                    </div><!-- end col -->
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                </div> <!-- container -->

            </div> <!-- content -->
            <?php include 'layouts/footer.php'; ?>
        </div>
    </div>
    <!-- END wrapper -->
    <a id="right-bar-toggle"></a>
    <?php include 'layouts/vendor-scripts.php'; ?>
    <script src="../assets/js/app.js"></script>

    <script>
        // Function to display SweetAlert2 notification
        function displayNotification(icon, title, text) {
            Swal.fire({
                icon: icon,
                title: title,
                text: text,
            });
        }

        // Check for success message
        <?php if (isset($_SESSION['success_message'])): ?>
            displayNotification('success', 'Success', '<?php echo $_SESSION['success_message']; ?>');
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        // Check for error message
        <?php if (isset($_SESSION['error_message'])): ?>
            displayNotification('error', 'Error', '<?php echo $_SESSION['error_message']; ?>');
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>
    </script>

</body>

</html>