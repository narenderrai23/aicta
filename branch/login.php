<?php
session_start();
$_SESSION['site_name'] = "AICTA";

// error_reporting(0);
if (isset($_SESSION['role']) && $_SESSION['role'] === 'branch') {
    header("location: index.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <title>
        Login <?=$_SESSION['site_name']?> - Admin
    </title>

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
                                <img src="../assets/image/favicon.png" alt="" height="22"> <span class="logo-txt"><?=$_SESSION['site_name']?></span>
                            </a>
                        </div>

                        <div class="card">
                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Welcome Back !</h5>
                                    <p class="text-muted">Sign in to continue to <?=$_SESSION['site_name']?>.</p>
                                </div>
                                <div class="p-2 mt-4">
                                    <form method="post" action="../php/controller/loginController.php">
                                        <div class="mb-3">
                                            <label class="form-label" for="email">Email</label>
                                            <input type="text" class="form-control" id="email" name="email" placeholder="Enter email">
                                        </div>

                                        <div class="mb-3">
                                            <div class="float-end">
                                                <a href="auth-recoverpw.php" class="text-muted">Forgot password?</a>
                                            </div>
                                            <label class="form-label" for="userpassword">Password</label>
                                            <input type="password" class="form-control" id="userpassword" name="password" placeholder="Enter password">
                                            <span class="text-danger">
                                                <?php
                                                if (isset($_SESSION['login_error'])) {
                                                    echo $_SESSION['login_error'];
                                                    unset($_SESSION['login_error']); // Clear the error message
                                                }
                                                ?>
                                            </span>
                                        </div>

                                        <div class="mt-3 text-end">
                                            <button class="btn btn-primary w-sm waves-effect waves-light" name="login" value="branchLogin" type="submit">Log
                                                In</button>
                                        </div>

                                        <div class="mt-4 text-center">
                                            <p class="mb-0">Admin <a href="../admin/login.php" class="fw-medium text-primary"> Login </a> </p>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>

                    </div><!-- end col -->
                </div><!-- end row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center text-muted p-4">
                            <p class="text-white-50">©
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> <?=$_SESSION['site_name']?>. Crafted with <i class="mdi mdi-heart text-danger"></i> by aict
                            </p>
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