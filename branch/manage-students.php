<?php include 'layouts/session.php'; ?>
<!DOCTYPE html>
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

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Manage Student</h4>
                                    <form id="excelForm" action="../php/helper/excel-export.php" method="post">
                                        <input type="number" name="limit" class="btn btn-sm border-info" placeholder="Select All Entries">
                                        <button type="submit" name="action" value="excelExport" class="btn btn-sm btn-info">Excel</button>
                                    </form>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped table-bordered" id="datatable">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Student Enrollment</th>
                                                <th>Student Name</th>
                                                <th>Father's Name</th>
                                                <th>Course</th>
                                                <th>Admission Date</th>
                                                <th>Approve</th>
                                                <th>Action</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->

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
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>

    <!-- DataTables Buttons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="../ajax/js/fetch.js"></script>
    <script src="../ajax/js/extra.js"></script>

    <script>
    
        function initializeDataTable(tableId) {
            $(tableId).DataTable({
                responsive: true,
                dom: 'Bfrtip',
                processing: true,
                serverSide: true,
                searching: true,
                bJQueryUI: true,
                pageLength: 20,
                order: [0, 'desc'],
                columnDefs: [{
                        // targets: [3, 4],
                        visible: false
                    },
                    {
                        targets: [6, 7, 8],
                        orderable: false
                    }
                ],
                buttons: [{
                        extend: 'excel',
                        text: 'Excel Export',
                        className: 'btn btn-sm btn-primary',
                    },
                    {
                        extend: 'copyHtml5',
                        text: 'Copy to Excel',
                        exportOptions: {
                            columns: [0, ':visible']
                        },
                        className: 'btn btn-sm btn-info',
                    },
                    {
                        extend: 'colvis',
                        text: 'Column visibility',
                        className: 'btn btn-sm btn-success',
                    },
                ],
                ajax: {
                    url: "../php/controller/datatableController.php",
                    type: "POST",
                    data: function(d) {
                        d.action = 'fetchStudents';
                    },
                },
                columns: [{
                        data: "id"
                    },
                    {
                        data: "enrollment"
                    },
                    {
                        data: "student_name"
                    },
                    {
                        data: "father_name"
                    },
                    {
                        data: "course_code",
                    },
                    {
                        render: function(data, type, row) {
                            return formatDate(row.date_admission);
                        }
                    },
                    {
                        render: function name(data, type, row) {
                            return `<button class="badge border-0 bg-${row.approve === 'yes' ? 'success' : 'danger'}" ${row.approve === 'yes' ? 'disabled' : ''}>
                                <i class="fs-5 bx bx-${row.approve === 'yes' ? 'badge-check' : 'x'}"></i>
                            </button>`;
                        }
                    },
                    {
                        render: function(data, type, row) {
                            return `<div class="btn-group btn-group-sm">
                                        <a class="btn btn-info" href="details-student.php?id=${row.id}">
                                            <i class="font-size-10 fas fa-eye"></i>
                                        </a>
                                        <a class="btn btn-warning" href="print.php?id=${row.id}">
                                            <i class="font-size-10 fas fa-cloud-download-alt"></i>
                                        </a>
                                    </div>`;
                        }
                    },
                    {
                        render: function(data, type, row) {
                            return `<select class="select2" data-id="${row.id}" disabled>
                                        <option value="${row.student_status}">${row.student_status}</option>
                                    </select>`;
                        }
                    }
                ],
                drawCallback: function(settings) {
                    const classes = {
                        'complete': 'btn-success',
                        'running': 'btn-info',
                        'dropout': 'btn-danger'
                    };
                    $('.select2').select2({
                        width: 'auto',
                        minimumResultsForSearch: -1,
                        templateSelection: function(data) {
                            if (!data.id) {
                                return data.text;
                            }
                            var colorClass = classes[data.id] || 'text-default';
                            return $('<span class="btn btn-sm ' + colorClass + '">' + data.text + '</span>');
                        }
                    });
                }
            });
        }


        function formatDate(inputDate) {
            const options = {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            };
            const date = new Date(inputDate);
            return date.toLocaleDateString('en-US', options);
        }

        // Call the function to initialize DataTable
        initializeDataTable('#datatable');
    </script>
    <style>
        .select2 {
            text-transform: capitalize;
        }

        .select2-container--default.select2-container--disabled .select2-selection--single,
        .select2-container--default .select2-selection--single {
            background-color: transparent;
            border: 0;
        }

        .select2-selection__arrow {
            display: none;
        }
    </style>
</body>

</html>