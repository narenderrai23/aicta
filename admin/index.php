<?php require_once 'layouts/session.php'; ?>
<!DOCTYPE html>
<html lang="en">
<?php
require_once('../php/model/fetch.php');
$fetch = new Fetch();

$cardData = [

    [
        "title" => "Total Branch",
        "value" => $fetch->fetch('tblbranch'),
        "graph" => $fetch->graph('tblbranch', 'created_at'),
        "icon" => "fas fa-school",
        "color" => 'success',
    ],
    [
        "title" => "Total Student",
        "value" => $fetch->fetch('students'),
        "graph" => $fetch->graph('students', 'join_date'),
        "icon" => "bx bx-user",
        "color" => 'primary',

    ],
    [
        "title" => "Not Approve",
        "value" => $fetch->fetch('students', "approve = 'no'"),
        "graph" => $fetch->graph('students', 'join_date', "approve = 'no'"),
        "icon" => "bx bx-block",
        "color" => 'danger',
    ],
    [
        "title" => "Running Student",
        "value" => $fetch->fetch('students', "student_status = 'running'"),
        "graph" => $fetch->graph('students', 'join_date', "student_status = 'running'"),
        "icon" => "bx bx-user-x",
        "color" => 'info',
    ],

];
$data = $fetch->fetchDataForLast12Months('students', 'join_date');
$Spline = $fetch->fetchDataMonths('students', 'join_date');

$TopBranch = $fetch->TopBranch('students', 'branch_id');
$recent = $fetch->recentAdded('tblbranch');
$oldAdded = $fetch->oldAdded('tblbranch');


?>


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

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="row">
                                <?php
                                $i = 0;
                                foreach ($cardData as $card) : ?>
                                    <div class="col-lg-3 col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="avatar">
                                                    <span class="avatar-title bg-soft-<?= $card['color'] ?> rounded">
                                                        <i class="<?= $card['icon'] ?> text-<?= $card['color'] ?> font-size-24"></i>
                                                    </span>
                                                </div>
                                                <p class="text-muted mt-4 mb-0"><?= $card['title'] ?></p>
                                                <h4 class="mt-1 mb-0"><?= $card['value'] ?></h4>
                                                <div>
                                                    <div class="py-3 my-1">
                                                        <div id="mini-<?= $i ?>" data-colors='["#3980c0"]'></div>
                                                    </div>
                                                    <ul class="list-inline d-flex justify-content-between justify-content-center mb-0">
                                                        <li class="list-inline-item">Year</li>
                                                        <li class="list-inline-item">Month</li>
                                                        <li class="list-inline-item">Week</li>
                                                        <li class="list-inline-item">Day</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                    $i++;
                                endforeach; ?>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-xl-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap align-items-center mb-3">
                                        <h5 class="card-title mb-0">Students of the Year</h5>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-xl-8">
                                            <div>
                                                <div id="sales-statistics" data-colors='["#eff1f3","#eff1f3","#eff1f3","#eff1f3","#33a186","#3980c0","#eff1f3","#eff1f3","#eff1f3", "#eff1f3"]' class="apex-chart"></div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex">
                                                    <i class="mdi mdi-circle font-size-10 mt-1 text-primary"></i>
                                                    <div class="flex-1 ms-2">
                                                        <p class="mb-0 font-size-10">Total Students</p>
                                                        <h5 class="mt-1 mb-0 font-size-16">
                                                            <?= $fetch->fetch('students') ?>
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-3 border-top pt-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="d-flex">
                                                        <i class="mdi mdi-circle font-size-10 mt-1 text-info"></i>
                                                        <div class="flex-1 ms-2">
                                                            <p class="mb-0 font-size-10">Running Student</p>
                                                            <h5 class="mt-1 mb-0 font-size-16"><?= $fetch->fetch('students', "student_status = 'running'") ?></h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-3 border-top pt-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="d-flex">
                                                        <i class="mdi mdi-circle font-size-10 mt-1 text-success"></i>
                                                        <div class="flex-1 ms-2">
                                                            <p class="mb-0 font-size-10">Complete Student</p>
                                                            <h5 class="mt-1 mb-0 font-size-16"><?= $fetch->fetch('students', "student_status = 'complete'") ?></h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-3 border-top pt-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="d-flex">
                                                        <i class="mdi mdi-circle font-size-10 mt-1 text-danger"></i>
                                                        <div class="flex-1 ms-2">
                                                            <p class="mb-0 font-size-10">Dropout Student</p>
                                                            <h5 class="mt-1 mb-0 font-size-16"><?= $fetch->fetch('students', "student_status = 'dropout'") ?></h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-0">Gender Distribution</h5>

                                    <div class="text-center mt-4">
                                        <div id="genderChart" class="text-center mt-4"></div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col">
                                            <div class="px-2">
                                                <div class="d-flex justify-content-between align-items-center mt-sm-0 mt-2">
                                                    <div class="d-flex">
                                                        <i class="mdi mdi-circle font-size-10 mt-1 text-primary"></i>
                                                        <div class="flex-1 ms-2">
                                                            <p class="mb-0 text-truncate">Male</p>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <span class="fw-bold male"></span>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center mt-2">
                                                    <div class="d-flex">
                                                        <i class="mdi mdi-circle font-size-10 mt-1 text-success"></i>
                                                        <div class="flex-1 ms-2">
                                                            <p class="mb-0 text-truncate">Female</p>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <span class="fw-bold female"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="px-2">
                                                <div class="d-flex justify-content-between align-items-center mt-sm-0 mt-2">
                                                    <div class="d-flex">
                                                        <i class="mdi mdi-circle font-size-10 mt-1 text-info"></i>
                                                        <div class="flex-1 ms-2">
                                                            <p class="mb-0 text-truncate">Transgender</p>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <span class="fw-bold transgender"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title mb-0 flex-grow-1">Top 10 Branch (month)</h4>
                                        </div>

                                        <div class="card-body px-0 pt-2">
                                            <div class=" px-3" data-simplebar style="max-height: 393px;">
                                                <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                                    <tbody>
                                                        <?php
                                                        foreach ($TopBranch['month'] as $row) :
                                                        ?>
                                                            <tr>
                                                                <td style="width: 20px;">
                                                                    <a href="details-branch.php?id=<?= $row['id'] ?>">
                                                                        <i class="text-info mx-2 fas fa-eye"></i>
                                                                    </a>
                                                                </td>
                                                                <td>
                                                                    <h6 class="font-size-13 mb-1"><?= $row['name'] ?></h6>
                                                                    <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i> <?= $row['state_name'] ?></p>
                                                                </td>
                                                                <td class="text-muted"><i class="icon-xs icon me-2 text-success" data-feather="trending-up"></i><?= $row['count'] ?></td>
                                                                <td><span class="badge badge-soft-danger font-size-12"><?= $row['code'] ?></span></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div> <!-- enbd -->
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title mb-0 flex-grow-1">Top 10 Branch (All Time)</h4>
                                        </div>

                                        <div class="card-body px-0 pt-2">
                                            <div class=" px-3" data-simplebar style="max-height: 393px;">
                                                <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                                    <tbody>
                                                        <?php
                                                        foreach ($TopBranch['all'] as $row) :
                                                        ?>
                                                            <tr>
                                                                <td style="width: 20px;">
                                                                    <a href="details-branch.php?id=<?= $row['id'] ?>">
                                                                        <i class="text-info mx-2 fas fa-eye"></i>
                                                                    </a>
                                                                </td>
                                                                <td>
                                                                    <h6 class="font-size-13 mb-1"><?= $row['name'] ?></h6>
                                                                    <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i> <?= $row['state_name'] ?></p>
                                                                </td>
                                                                <td class="text-muted"><i class="icon-xs icon me-2 text-success" data-feather="trending-up"></i><?= $row['count'] ?></td>
                                                                <td><span class="badge badge-soft-danger font-size-12"><?= $row['code'] ?></span></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div> <!-- enbd -->
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title mb-0 flex-grow-1">Recent Added</h4>
                                        </div>

                                        <div class="card-body px-0 pt-2">
                                            <div class=" px-3" data-simplebar style="max-height: 393px;">
                                                <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                                    <tbody>
                                                        <?php
                                                        foreach ($recent as $row) :
                                                        ?>
                                                            <tr>
                                                                <td style="width: 20px;">
                                                                    <a href="details-branch.php?id=<?= $row['id'] ?>">
                                                                        <i class="text-info mx-2 fas fa-eye"></i>
                                                                    </a>
                                                                </td>
                                                                <td>
                                                                    <h6 class="font-size-13 mb-1"><?= $row['name'] ?></h6>
                                                                    <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i> <?= $row['state_name'] ?></p>
                                                                </td>
                                                                <td class="text-muted"><i class="icon-xs icon me-2 text-success" data-feather="trending-up"></i><?= date("M d, Y", strtotime($row['created']))  ?></td>
                                                                <td><span class="badge badge-soft-danger font-size-12"><?= $row['code'] ?></span></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div> <!-- enbd -->
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title mb-0 flex-grow-1">Oldest Branch</h4>
                                        </div>

                                        <div class="card-body px-0 pt-2">
                                            <div class=" px-3" data-simplebar style="max-height: 393px;">
                                                <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                                    <tbody>
                                                        <?php
                                                        foreach ($oldAdded as $row) :
                                                        ?>
                                                            <tr>
                                                                <td style="width: 20px;">
                                                                    <a href="details-branch.php?id=<?= $row['id'] ?>">
                                                                        <i class="text-info mx-2 fas fa-eye"></i>
                                                                    </a>
                                                                </td>
                                                                <td>
                                                                    <h6 class="font-size-13 mb-1"><?= $row['name'] ?></h6>
                                                                    <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i> <?= $row['state_name'] ?></p>
                                                                </td>
                                                                <td class="text-muted"><i class="icon-xs icon me-2 text-success" data-feather="trending-up"></i><?= date("M d, Y", strtotime($row['created']))  ?></td>
                                                                <td><span class="badge badge-soft-danger font-size-12"><?= $row['code'] ?></span></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div> <!-- enbd -->
                                        </div>
                                    </div>
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

    <!-- apexcharts -->
    <script src="../assets/libs/apexcharts/apexcharts.min.js"></script>
    <!-- Chart JS -->
    <script src="../assets/js/pages/chartjs.js"></script>

    <script src="../assets/js/pages/dashboard.init.js"></script>

    <script src="../assets/js/app.js"></script>
    <script>
        var cardData = <?= json_encode($cardData) ?>

        $.each(cardData, function(index, value) {
            var graph = Object.values(value['graph']);
            createMiniChart("mini-" + index, graph);
        });

        // // Usage
        createBarChart(
            "sales-statistics",
            <?= json_encode($data) ?>,
            ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct"]
        );

        var maleCount = <?= $fetch->fetch('students', "gender = 'male'") ?>;
        var femaleCount = <?= $fetch->fetch('students', "gender = 'female'") ?>;
        var transgender = <?= $fetch->fetch('students', "gender = 'transgender'") ?>;
        $(".male").text(maleCount);
        $(".female").text(femaleCount);
        $(".transgender").text(transgender);
        var data = [maleCount, femaleCount, transgender];
        createGenderChart("gender", data, ["Male", "Female", "Transgender"]);
    </script>

</body>

</html>