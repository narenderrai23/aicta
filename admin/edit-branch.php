<?php include 'layouts/session.php'; ?>
<?php
include('../php/model/branch.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: manage-branch.php');
    exit;
}

if (empty($_SESSION['loggedin'])) {
    header('Location: logout.php');
    exit;
}

$BranchModel = new BranchModel();
$id = $_GET['id'];
$data = $BranchModel->fetchBranch($id);
if (empty($data->id)) {
    header('Location: manage-branch.php');
    exit;
}

?>

<!doctype html>
<html lang="en">

<head>

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
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title" style="text-align: center;">Add Branch</h4>
                                    <form id="updateForm" class="needs-validation" novalidate>
                                        <input type="hidden" name="branch_id" value="<?= $data->id ?>" class="form-control" required>

                                        <div class="row mb-4">
                                            <div class="col-lg-6 mb-4">
                                                <label>State</label>
                                                <select class="form-select" name="state" id="state" required>
                                                </select>
                                            </div>

                                            <div class="col-lg-6 mb-4">
                                                <label>City</label>
                                                <select name="city" id="city" class="form-control" required></select>
                                            </div>

                                            <div class="col-lg-6 mb-4">
                                                <label>Branch Code</label>
                                                <input type="text" name="code" value="<?= $data->code ?>" id="code" class="form-control" readonly required>
                                            </div>

                                            <div class="col-lg-6 mb-4">
                                                <label>Branch Name</label>
                                                <input type="text" name="name" value="<?= $data->name ?>" class="form-control" required>
                                            </div>

                                            <div class="col-lg-6 mb-4">
                                                <label>Branch Head</label>
                                                <input type="text" name="head" value="<?= $data->head ?>" class="form-control" required>
                                            </div>

                                            <div class="col-lg-6 mb-4">
                                                <label>Branch Category</label>
                                                <select name="category" class="form-control select2" required>
                                                    <option value="" disabled selected>Branch Category</option>
                                                    <?php
                                                    $categories = [
                                                        'authorized',
                                                        'training',
                                                        'learning'
                                                    ];
                                                    foreach ($categories as $value) :
                                                        $selectedCategory = ($data->category === $value) ? 'selected' : '';
                                                    ?>

                                                        <option <?= $selectedCategory ?> value='<?= $value ?>'><?= ucfirst($value) ?></option>
                                                    <?php endforeach;
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="col-lg-6 mb-4">
                                                <label>Mobile</label>
                                                <input type="text" name="phone" value="<?= $data->phone ?>" class="form-control valid" required maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                            </div>

                                            <div class="col-lg-6 mb-4">
                                                <label>Valid Till Date</label>
                                                <input type="date" name="till_date" value="<?= $data->till_date ?>" id="date" class="form-control" required>
                                            </div>

                                            <div class="col-lg-6 mb-4">
                                                <label>Address</label>
                                                <textarea name="address" class="form-control" rows="4" required><?= $data->address ?></textarea>

                                            </div>

                                            <div class="col-lg-6 mb-4">
                                                <label>Corresponding Address</label>
                                                <textarea name="c_address" class="form-control" rows="5" required><?= $data->c_address ?></textarea>
                                            </div>

                                        </div>

                                        <h3 class="mb-5">Login details</h3>
                                        <div class="row">
                                            <div class="col-lg-6 mb-4">
                                                <label>Email</label>
                                                <input type="email" name="email" value="<?= $data->email ?>" class="form-control" required>
                                            </div>
                                            <div class="col-lg-6 mb-4">
                                                <label for="password">Password</label>
                                                <div class="input-group mb-3">
                                                    <input type="password" class="form-control" name="password" id="password" required>
                                                    <span class="input-group-text password-eye"><i class="fas fa-eye"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary mr-2" name="action" value="editBranch">Add</button>
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
        fetchStates(<?= $data->state_id ?>);
        flatpickr('#date', {
            minDate: "<?= $data->created ?>",
        });
        fetchCity(<?= $data->state_id ?>, <?= $data->city_id ?>);
        $("#state").change(function() {
            var stateId = $("#state").val();
            fetchCity(stateId);
        });

        $("#updateForm").on("submit", function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append("action", "editBranch");
            ajax("../php/controller/branchController.php", formData, function(response) {
                alert(response.message);
                console.log(response);
                if (response.status === "success") {
                    window.location.href = "manage-branch.php";
                }
            });
        });
    </script>

</body>

</html>