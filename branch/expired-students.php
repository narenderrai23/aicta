<?php include 'layouts/session.php'; ?>
<!doctype html>
<html lang="en">

<head>

    <title><?=$_SESSION['site_name']?> - Admin</title>

    <?php include 'layouts/head.php'; ?>
    <?php include 'layouts/head-style.php'; ?>

</head>

<body data-layout="vertical" data-sidebar="dark" data-sidebar-size="lg">

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
                                                <th style="width: 100px;">Expiry Date</th>
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

    <!-- container-scroller -->
    <div class="modal fade" id="confirmationModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this item?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button id="confirmDelete" type="button" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>


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

    <script>
        var table = initializeDataTable('#datatable');
        function initializeDataTable(tableId) {
            return $(tableId).DataTable({
                responsive: true,
                dom: 'Bfrtip',
                processing: true,
                serverSide: true,
                searching: true,
                bJQueryUI: true,
                pageLength: 50,
                order: [0, 'desc'],
                columnDefs: [{
                    targets: [-1, -2, -3],
                    orderable: false
                }],
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
                        d.condition = 'complete';
                    },
                    dataSrc: function(response) {
                        console.log(response)
                        return response.data;
                    },
                },
                columns: [{
                        data: "id"
                    },
                    {
                        render: function name(data, type, row) {
                            return `<div id=row${row.id}>${row.enrollment}</div>`;
                        }
                    },
                    {
                        data: "student_name"
                    },
                    {
                        data: "father_name"
                    },
                    {
                        data: "course_name"
                    },
                    {
                        render: function(data, type, row) {
                            return formatDate(row.date_admission);
                        }
                    },
                    {
                        render: function(data, type, row) {
                            return `
                            <div class="btn btn-sm btn-danger">${formatDate(row.expiry_date)}</div>
                            `;
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
                            return `<select class="form-select form-select-sm student_status select2 dropdown-toggle" data-id="${row.id}" >
                                        <option value="complete" ${row.student_status === 'complete' ? 'selected disabled' : ''}>Completed</option>
                                        <option value="running" ${row.student_status === 'running' ? 'selected disabled' : ''}>Running</option>
                                        <option value="dropout" ${row.student_status === 'dropout' ? 'selected disabled' : ''}>Drop Out</option>
                                    </select>`;
                        }
                    }
                ],
                drawCallback: function(settings) {
                    const classes = {
                        'complete': 'btn-soft-success w-100 pe-3 text-start',
                        'running': 'btn-soft-info w-100 pe-3 text-start',
                        'dropout': 'btn-soft-danger w-100 pe-3 text-start'
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

                },
            });
        }

        $("#search").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });


        $(document).on('change', '.student_status', function() {
            const id = $(this).data('id');
            const value = $(this).val();
            const classes = {
                'complete': 'text-success',
                'running': 'text-info',
                'dropout': 'text-danger'
            };

            var currentClasses = Object.values(classes).join(' ');
            if ($(this).hasClass(currentClasses)) {
                $(this).removeClass(currentClasses);
            }
            var newClass = classes[value];
            if (newClass) {
                $(this).addClass(newClass);
                $(this).children().prop('disabled', false);
                $(this).find(':selected').prop('disabled', true);
            }

            const data = {
                id: id,
                status: value,
                action: 'updateStudentStatus'
            };
            const success = function(response) {
                console.log(response)
                if (response.status === true) {
                    alert(response.message)
                }
            };
            const url = '../php/controller/studentController.php';
            performAjaxRequest(url, data, success);
        });

        $(document).on('click', '.delete', function() {
            var itemId = $(this).data('id');
            const $row = $(this).closest('tr');
            $('#confirmationModal').modal('show');
            $('#confirmDelete').off('click').on('click', function() {
                const data = {
                    itemId: itemId,
                    action: 'deleteStudent'
                };
                const success = function(response) {
                    console.log(response);
                    if (!response.status) {
                        alert("Failed to Delete Branch")
                    }
                    table.row($row).remove().draw();
                    $('#confirmationModal').modal('hide');
                };
                const url = '../php/controller/commonController.php';
                performAjaxRequest(url, data, success);
            });
        });
    </script>
    <style>
        .select2 {
            text-transform: capitalize;
        }

        .select2-container--default.select2-container--disabled .select2-selection--single,
        .select2-container--default .select2-selection--single {
            background-color: transparent;
            border: 0;
            border-radius: 0;
        }

        .select2-selection__arrow {
            height: 30px !important;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            width: 105px;
            padding: 0;
        }

        [type="number"]::-webkit-inner-spin-button,
        [type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .dt-buttons {
            position: absolute;
            /* bottom: 21px; */
        }

        @keyframes dtb-spinner {
            100% {
                transform: rotate(360deg)
            }
        }

        @-o-keyframes dtb-spinner {
            100% {
                -o-transform: rotate(360deg);
                transform: rotate(360deg)
            }
        }

        @-ms-keyframes dtb-spinner {
            100% {
                -ms-transform: rotate(360deg);
                transform: rotate(360deg)
            }
        }

        @-webkit-keyframes dtb-spinner {
            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg)
            }
        }

        @-moz-keyframes dtb-spinner {
            100% {
                -moz-transform: rotate(360deg);
                transform: rotate(360deg)
            }
        }

        div.dt-button-collection {
            position: absolute;
            top: 0;
            left: 0;
            width: 200px;
            margin-top: 3px;
            margin-bottom: 3px;
            padding: .75em 0;
            border: 1px solid rgba(0, 0, 0, 0.4);
            background-color: white;
            overflow: hidden;
            z-index: 2002;
            border-radius: 5px;
            box-shadow: 3px 4px 10px 1px rgba(0, 0, 0, 0.3);
            box-sizing: border-box
        }

        div.dt-button-collection .dt-button {
            position: relative;
            left: 0;
            right: 0;
            width: 100%;
            display: block;
            float: none;
            background: none;
            margin: 0;
            padding: .5em 1em;
            border: none;
            text-align: left;
            cursor: pointer;
            color: inherit
        }


        div.dt-button-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            background: radial-gradient(ellipse farthest-corner at center, rgba(0, 0, 0, 0.3) 0%, rgba(0, 0, 0, 0.7) 100%);
            z-index: 2001
        }

        .dt-button.processing {
            color: rgba(0, 0, 0, 0.2)
        }

        .dt-button-collection button:not(.dt-button-active) {
            background-color: darkcyan !important;
            color: white !important;
        }
    </style>
</body>

</html>