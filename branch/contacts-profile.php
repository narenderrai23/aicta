<?php include 'layouts/session.php'; ?>
<?php
include('../php/model/admin.php');
if (empty($_SESSION['loggedin'])) {
    header('Location: logout.php');
    exit;
}

$Admin = new AdminProfile();
$id = $_SESSION['loggedin'];
$data = $Admin->fetch('tblbranch', '*', $id);
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
                    $maintitle = $_SESSION['site_name'];
                    $title = 'Dashboard';
                    ?>
                    <?php include 'layouts/breadcrumb.php'; ?>
                    <!-- end page title -->

                    <div class="row g-0">
                        <div class="col-lg-4 pe-lg-2">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Admin Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="py-4 text-start">
                                        <div class="text-center">
                                            <div class="profile-user-img">
                                                <img src="<?= $src ?>" id="Profile" class="avatar-lg rounded-circle img-thumbnail">
                                            </div>
                                            <h5 class="mt-3 mb-1"><?= $data['name'] ?></h5>
                                            <p class="text-muted font-14">Founder</p>
                                        </div>

                                        <p class="text-muted"><strong>Mobile :</strong>
                                            <span class="ms-2"><?= $data['phone'] ?></span>
                                        </p>

                                        <p class="text-muted"><strong>Email :</strong>
                                            <span class="ms-2"><?= $data['email'] ?></span>
                                        </p>

                                        <p class="text-muted"> <strong>Profile Image</strong>
                                        </p>

                                        <input class="form-control" name="image" type="file" accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="col-lg-4 ps-lg-2">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h5 class="mb-0">Change Password</h5>
                                </div>
                                <div class="card-body bg-body-tertiary">
                                    <form id="changePassword">
                                        <div class="mb-3">
                                            <label class="form-label">Old Password</label>
                                            <input class="form-control" name="old-password" type="password">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">New Password</label>
                                            <input class="form-control" name="new-password" type="password">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Confirm Password</label>
                                            <input class="form-control" name="confirm-password" type="password">
                                        </div>
                                        <button class="btn btn-primary d-block w-100" type="submit">Update Password </button>
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
    <!-- Sweet alert init js-->
    <script src="../assets/js/app.js"></script>
    <script src="../ajax/js/fetch.js"></script>
    <script src="../ajax/js/extra.js"></script>
    <script>
        $('input[name="image"]').change(async function() {
            const file = this.files && this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = async (e) => {
                    try {
                        const result = await Swal.fire({
                            html: '<div class="text-success">Change Profile Image</div>',
                            imageUrl: e.target.result,
                            imageHeight: 100,
                            confirmButtonColor: '#3980c0',
                            confirmButtonText: 'Yes, Update!',
                            showDenyButton: true,
                        });

                        if (result.isConfirmed) {
                            const imageFile = this.files[0];
                            const formData = new FormData();
                            formData.append('action', 'updateProfileImage');
                            formData.append("image", imageFile);

                            ajax("../php/controller/adminController.php", formData, function(response) {
                                if (response.status === true) {
                                    $("#Profile, .header-profile-user").attr("src", `../assets/image/profile_admin/${response.image}`);
                                } else {
                                    return Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'Failed to update profile image. Please try again.'
                                    });
                                }
                            });
                        } else {
                            return Swal.fire({
                                icon: 'info',
                                title: 'Info',
                                text: 'Profile image update canceled.'
                            });
                        }


                    } catch (error) {
                        console.error('Error:', error);
                        return Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An unexpected error occurred. Please try again.'
                        });
                    }
                };
                reader.readAsDataURL(this.files[0]);
            } else {
                return Swal.fire({
                    icon: 'info',
                    title: 'Info',
                    text: 'Please select an image file.'
                });
            }
        });


        $("#updateData").on("submit", function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append("action", "updateAdminData");
            ajax("../php/controller/branchController.php", formData, function(response) {
                console.log(response);
                alert(response.message);
            });
        });


        $("#changePassword").on("submit", function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append("action", "changePassword");
            ajax("../php/controller/branchController.php", formData, function(response) {
                console.log(response);
                alert(response.message);
            });
        });
    </script>

</body>

</html>