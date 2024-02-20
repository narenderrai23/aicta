<?php include 'layouts/session.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <title><?=$_SESSION['site_name']?> - Admin</title>

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
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Manage Course</h4>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped table-bordered" id="datatable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Courses Name</th>
                                                <th>Courses Code</th>
                                                <th>Fee</th>
                                                <th>Course Duration</th>
                                                <th>Created</th>
                                                <th>Action</th>
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

    <!-- gridjs js -->
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
    <script src="../ajax/js/fetch.js"></script>
    <script>
        $(document).on('click', '.delete', function () {
            var itemId = $(this).data('id');
            $('#confirmationModal').modal('show');
            $('#confirmDelete').off('click').on('click', function () {
                const data = {
                    itemId: itemId,
                    action: 'deleteCourses'
                };
                const success = function (response) {
                    initializeDataTable('#datatable');
                    if (!response.status) {
                        alert("Failed to Delete Branch")
                    }
                    $('#confirmationModal').modal('hide');
                };
                const url = '../php/controller/commonController.php';
                performAjaxRequest(url, data, success);
            });
        });

        function initializeDataTable(tableId) {
            $(tableId).DataTable({
                processing: true,
                serverSide: false,
                bDestroy: true,
                bJQueryUI: true,
                ajax: {
                    url: '../php/controller/courseController.php',
                    type: 'POST',
                    data: {
                        action: 'fetchCourses'
                    },
                },
                columns: [{
                    data: "id"
                },
                {
                    data: "course_name"
                },
                {
                    data: "course_code"
                },
                {
                    data: "total_fee"
                },
                {
                    "render": function (data, type, row) {
                        return ` ${row.course_duration}
                                ${row.duration_time}`;
                    }
                },

                {
                    data: "created_at"
                },
                {
                    "render": function (data, type, row) {
                        return `<a href="details-course.php?id=${row.id}">
                                        <i class="text-info mx-2 fas fa-eye"></i>
                                    </a>`;
                    }
                }
                ]
            });
        }

        // Call the function to initialize DataTable
        initializeDataTable('#datatable');

        // Function to handle window size change and reinitialize DataTable
        function handleWindowResize() {
            initializeDataTable('#datatable');
        }

        window.addEventListener('resize', handleWindowResize);
    </script>

</body>

</html>