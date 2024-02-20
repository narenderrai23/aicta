<?php include 'layouts/session.php'; ?>
<?php
include('../php/model/branch.php');

if (!isset($_GET['id'])) {
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
                                    <table border="1" class="table table-striped table-bordered mg-b-0">
                                        <tr align="center" class="table-warning">
                                            <td colspan="4" style="font-size:20px;color:blue">
                                                Branch Details</td>
                                        </tr>

                                        <tr class="table-info">
                                            <th>Branch Name</th>
                                            <td><?= $data->name; ?></td>
                                            <th>Branch Email</th>
                                            <td><?= $data->email; ?></td>
                                        </tr>
                                        <tr class="table-warning">
                                            <th>Branch code</th>
                                            <td><?= $data->code; ?></td>
                                            <th>head</th>
                                            <td><?= $data->head; ?></td>
                                        </tr>
                                        <tr class="table-danger">
                                            <th>Category</th>
                                            <td><?= $data->category; ?></td>
                                            <th>Phone No.</th>
                                            <td><?= $data->phone; ?></td>
                                        </tr>

                                        <tr class="table-progress">
                                            <th>State</th>
                                            <td><?= $data->state_name; ?></td>
                                            <th>City</th>
                                            <td><?= $data->city_name; ?></td>
                                        </tr>
                                        <tr class="table-info">
                                            <th>Address</th>
                                            <td><?= $data->address; ?></td>
                                            <th>Corresponding Address</th>
                                            <td><?= $data->corresponding_address; ?></td>
                                        </tr>

                                        <tr class="table-primary">
                                            <th>Valid Till Date</th>
                                            <td><?= $data->till_date; ?></td>
                                            <th>Created</th>
                                            <td><?= $data->created_at; ?></td>
                                        </tr>

                                        <tr class="table-info">
                                            <th>Status</th>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input type="checkbox" class="form-check-input switch_button" data-id='<?= $id  ?>' id="switch<?= $id  ?>" <?= ($data->status === 'active') ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="switch<?= $id  ?>"> </label>
                                                </div>
                                            </td>
                                        </tr>

                                    </table>
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
        $(".switch_button").change(function() {
            const itemId = $(this).data('id');
            const data = {
                itemId: itemId,
                action: 'statusUpdate'
            };
            const success = function(response) {
                console.log(response)
                if (response.status !== 'success') {
                    alert(response.message);
                }
            };
            const url = '../php/controller/branchController.php';
            performAjaxRequest(url, data, success);
        });
    </script>
</body>

</html>