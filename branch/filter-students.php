<?php include 'layouts/session.php'; ?>
<!doctype html>
<html lang="en">

<head>

    <title><?=$_SESSION['site_name']?> - Admin</title>

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
                    $maintitle = $_SESSION['site_name'];
                    $title = 'Filter Student';
                    ?>
                    <?php include 'layouts/breadcrumb.php'; ?>
                    <!-- end page title -->
                    <div class="row">

                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Manage Student</h4>
                                    <form id="excelForm" action="../php/helper/excel-export.php" method="post">
                                        <input type="hidden" name="join_date" id="join_date">
                                        <input type="number" name="limit" class="btn btn-sm border-info"
                                            placeholder="Select All Entries">
                                        <button type="submit" name="action" value="excelExport"
                                            class="btn btn-sm btn-info">Excel</button>
                                    </form>
                                </div>
                                <div class="card-body">
                                    <form id="filterData">
                                        <div class="fw-bold mb-3">Joining Date (dd/mm/YYYY)</div>
                                        <input type="text" name="join_date"
                                            class="form-control date_admission mb-3 w-25 d-inline-flex"
                                            placeholder="Please select Start Date Time" data-input required>
                                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                    </form>
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
                                                <th>Admission Date</th>
                                                <th>Approve</th>
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
    <script src="../assets/libs/flatpickr/flatpickr.min.js"></script>
    <script>
        $(".date_admission").flatpickr({
            mode: "range",
            dateFormat: "Y-m-d",
            defaultDate: ["today", "today"]
        });

        $("#filterData").on("submit", function (e) {
            e.preventDefault();
            const formData = $(this).serializeArray();
            const tableId = '#datatable';
            if ($.fn.DataTable.isDataTable(tableId)) {
                $(tableId).DataTable().destroy();
            }
            initializeDataTable(tableId, formData);
            $value = $('.date_admission').val();
            $("#join_date").val($value);

        });


        function initializeDataTable(tableId, formData) {
            return $(tableId).DataTable({
                processing: true,
                serverSide: true,
                pageLength: 50,
                dom: 'Bfrtip',
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
                    exportOptions: {
                        columns: [0, ':visible']
                    }
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
                    data: function (d) {
                        d.action = 'fetchStudents';
                        d.data = formData;
                    },
                    dataSrc: function (response) {
                        console.log(response);
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
                    data: "course_code"
                },
                {
                    render: function (data, type, row) {
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
                    render: function (data, type, row) {
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

                ],
                drawCallback: function (settings) {

                    const classes = {
                        'complete': 'btn-soft-success w-100 pe-3 text-start',
                        'running': 'btn-soft-info w-100 pe-3 text-start',
                        'dropout': 'btn-soft-danger w-100 pe-3 text-start'
                    };
                    $('.select2').select2({
                        width: 'auto',
                        minimumResultsForSearch: -1,
                        templateSelection: function (data) {
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