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

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <?php
                    $maintitle =  $_SESSION['site_name'];
                    $title = 'Filter Student';
                    ?>
                    <?php include 'layouts/breadcrumb.php'; ?>
                    <!-- end page title -->
                    <div class="row">

                        <!-- <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Manage Student</h4>
                                    <form id="excelForm" action="../php/helper/excel-export.php" method="post">
                                        <input type="hidden" name="join_date" id="join_date">
                                        <input type="number" name="limit" class="btn btn-sm border-info" placeholder="Select All Entries">
                                        <button type="submit" name="action" value="excelExport" class="btn btn-sm btn-info">Excel</button>
                                    </form>
                                </div>
                                <div class="card-body">
                                    <form id="filterData">
                                        <div class="fw-bold mb-3">Joining Date (dd/mm/YYYY)</div>
                                        <input type="text" name="join_date" class="form-control date_admission mb-3 w-25 d-inline-flex" placeholder="Please select Start Date Time" data-input required>
                                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div> -->

                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <a href="#addproduct-img-collapse" class="text-dark" data-bs-toggle="collapse" aria-haspopup="true" aria-expanded="false" aria-haspopup="true" aria-controls="addproduct-img-collapse">
                                    <div class="d-flex align-items-center p-4">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <h5 class="font-size-16 mb-1">Filter Student</h5>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                        </div>
                                    </div>
                                </a>

                                <div id="addproduct-img-collapse" class="collapse show" data-bs-parent="#addproduct-accordion">
                                    <div class="p-4 border-top">
                                        <form id="filterData">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="fw-bold mb-3">Joining Date (dd/mm/YYYY)</div>
                                                    <input type="text" name="join_date" class="form-control date_admission mb-3 d-inline-flex" placeholder="Please select Time Range" data-input>
                                                </div>
                                                <div class="col mb-3 align-self-end">
                                                    <select class="form-select" id="branch" name="branch_id" required>
                                                        <option selected value="0">All Branch</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table table-striped table-bordered" id="datatable">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Student Enrollment</th>
                                                <th>Student Name</th>
                                                <th>Father's Name</th>
                                                <th>Course</th>
                                                <th>Branch Name</th>
                                                <th>Admission Date</th>
                                                <th>Approve</th>
                                                <th>Action</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
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
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>

    <!-- DataTables Buttons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="../assets/libs/flatpickr/flatpickr.min.js"></script>
    <script src="../ajax/js/fetch.js"></script>
    <script src="../ajax/js/extra.js"></script>
    <script src="../ajax/datatable-student.js"></script>


    <script>
        fetchBranches();
        $(".date_admission").flatpickr({
            mode: "range",
            dateFormat: "Y-m-d",
        });


        $("#filterData").on("submit", function(e) {
            e.preventDefault();
            const actionValue = $("input[name='action']:checked").val();
            const formData = $(this).serializeArray();

            const action = function(d) {
                d.action = 'fetchStudents';
                d.data = formData;
            };
            if ($.fn.DataTable.isDataTable("#datatable")) {
                $("#datatable").DataTable().destroy();
            }
            var table = initializeDataTable("#datatable", action);
            deleteItem(table, "student");
        });
    </script>
</body>

</html>