<?php include 'layouts/session.php'; ?>
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
                    $title = 'Dashboard';
                    ?>
                    <?php include 'layouts/breadcrumb.php'; ?>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Manage Cities</h4>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped table-bordered" id="datatable">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>City Name</th>
                                                <th>City Code</th>
                                                <th>State Name</th>
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

    <div class="modal fade" id="confirmationModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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

    <script src="../assets/js/app.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="../ajax/js/fetch.js"></script>
    <script>
        var table = initializeDataTable('#datatable');

        function initializeDataTable(tableId) {
            return $(tableId).DataTable({
                processing: true,
                serverSide: true,
                bJQueryUI: true,
                columnDefs: [{
                    "targets": [-1],
                    "orderable": false
                }],
                pageLength: 50,
                ajax: {
                    url: '../php/controller/datatableController.php',
                    type: 'POST',
                    data: function(d) {
                        d.action = 'fetchCities';
                    },
                    dataSrc: function(response) {
                        console.log(response)
                        return response.data;
                    }
                },
                columns: [{
                        data: "id"
                    },
                    {
                        data: "city_name"
                    },
                    {
                        data: "city_code"
                    },
                    {
                        data: "state_name"
                    },
                    {
                        data: "created_at",
                        render: function(data, type, row) {
                            return formatDate(row.created_at);
                        }
                    },
                    {
                        data: "password",
                        render: function(data, type, row) {
                            let btnGroupHTML = `<div class="btn-group btn-group-sm">
                                <a class="btn btn-success" href="edit-city.php?id=${row.id}">
                                    <i class="font-size-10 fas fa-user-edit"></i>(${row.count})
                                </a>
                                <button data-id="${row.id}" class="btn btn-danger ${row.count < 1 ? 'delete' : 'disabled'}">
                                    <i class="font-size-10 far fa-trash-alt"></i>
                                </button>`;

                            btnGroupHTML += ` </div>`;
                            return btnGroupHTML;
                        }
                    }
                ]
            });
        }

        $(document).on('click', '.delete', function() {
            var itemId = $(this).data('id');
            const $row = $(this).closest('tr');
            $('#confirmationModal').modal('show');
            $('#confirmDelete').off('click').on('click', function() {
                const data = {
                    itemId: itemId,
                    action: 'deleteCity'
                };
                const success = function(response) {
                    if (!response.status) {
                        alert("Failed to Delete City")
                    }
                    table.row($row).remove().draw();
                    $('#confirmationModal').modal('hide');
                };
                const url = '../php/controller/commonController.php';
                performAjaxRequest(url, data, success);
            });
        });
    </script>
</body>

</html>