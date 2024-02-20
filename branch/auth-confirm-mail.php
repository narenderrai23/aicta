<?php
session_start();
// error_reporting(0);
if (isset($_SESSION['role']) && $_SESSION['role'] === 'branch') {
    header("location: index.php");
    exit;
}

if (!isset($_SESSION['otp_alert'])) {
    // header('location:auth-recoverpw.php');
    // exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <title><?=$_SESSION['site_name']?> - Admin</title>

    <?php include 'layouts/head.php'; ?>

    <?php include 'layouts/head-style.php'; ?>

</head>


<body data-layout="vertical" data-sidebar="dark">


    <div class="authentication-bg min-vh-100">
        <div class="bg-overlay"></div>
        <div class="container">
            <div class="d-flex flex-column min-vh-100 px-3 pt-4">
                <div class="row justify-content-center my-auto">
                    <div class="col-md-8 col-lg-6 col-xl-5">

                        <div class="text-center mb-4">
                            <a href="index.php">
                                <img src="assets/images/logo-sm.svg" alt="" height="22"> <span class="logo-txt">Symox</span>
                            </a>
                        </div>

                        <div class="card">
                            <div class="card-body p-4">
                                <div class="text-center mt-3">
                                    <div class="avatar-lg mx-auto">
                                        <div class="avatar-title rounded-circle bg-light">
                                            <i class="bx bx-mail-send h2 mb-0 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="mt-4 pt-2">
                                        <h4>Success !</h4>
                                        <p class="text-success">
                                            <?php
                                            if (isset($_SESSION['otp_alert'])) {
                                                echo $_SESSION['otp_alert'];
                                                unset($_SESSION['otp_alert']); // Clear the error message
                                            }
                                            ?>
                                        </p>
                                        <div class="mt-4">
                                            <a href="index.php" class="btn btn-primary w-100">Back to Home</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div><!-- end col -->
                </div><!-- end row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center text-muted p-4">
                            <p class="text-white-50">© <script>
                                    document.write(new Date().getFullYear())
                                </script> Symox. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand</p>
                        </div>
                    </div>
                </div>

            </div>
        </div><!-- end container -->
    </div>
    <!-- end authentication section -->

    <?php include 'layouts/vendor-scripts.php'; ?>

</body>

</html>