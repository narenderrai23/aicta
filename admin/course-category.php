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
                    $title = 'Category';
                    ?>
                    <?php include 'layouts/breadcrumb.php'; ?>
                    <!-- end page title -->
                    <div class="row">

                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title" style="text-align: center;">Add Category</h4>
                                    <form id="addForm">
                                        <div class="row">
                                            <div class="col">
                                                <label>Category Name</label>
                                                <input type="text" name="name" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="mt-4 text-center d-md-table">
                                            <button class="btn btn-success btn-block loginbtn" type="submit">Add Category</button>
                                        </div>
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
                                                <th>Category Name</th>
                                                <th>Admission Date</th>
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
                    <h5 class="modal-title">Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this item?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button id="confirmDelete" type="button" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateForm">
                        <input type="hidden" id="id" name="id">

                        <label>Course Category Name</label>
                        <input type="text" name="name" class="form-control" required>

                        <div class="mt-4 text-center d-md-table">
                            <button class="btn btn-success btn-block loginbtn" type="submit">Add Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Sidebar -->
    <a id="right-bar-toggle"></a>

    <?php include 'layouts/vendor-scripts.php'; ?>

    <script src="../assets/js/app.js"></script>
    <script src="../assets/js/pages/form-validation.init.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="../ajax/js/fetch.js"></script>
    <script>
        $(document).ready(function() {
           initializeDataTable('#datatable');
            

            $(document).on('click', '.delete', function() {
                var itemId = $(this).data('id');
                $('#confirmationModal').modal('show');
                $('#confirmDelete').off('click').on('click', function() {
                    const data = {
                        itemId: itemId,
                        action: 'deleteCategory'
                    };
                    const success = function(response) {
                        initializeDataTable('#datatable');
                        if (!response.status) {
                            alert("Failed to Delete City")
                        }
                        $('#confirmationModal').modal('hide');
                    };
                    const url = '../php/controller/commonController.php';
                    performAjaxRequest(url, data, success);
                });
            });


            $("#addForm").on("submit", function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                formData.append("action", "addCategory");
                ajax("../php/controller/courseController.php", formData, function(response) {
                    alert(response.message);
                    if (response.status) {
                        initializeDataTable('#datatable');
                        $("#addForm").trigger("reset");
                    }
                });
            });

        });

        function edit(itemId) {
            $('#edit').modal('show');
            fetchRecord(itemId);
            $("#updateForm").on("submit", function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                formData.append("action", "updateCategory");
                ajax("../php/controller/courseController.php", formData, function(response) {
                    alert(response.message);
                    console.log(response);
                    $('#edit').modal('hide');
                    initializeDataTable('#datatable');
                });
            });
        }

        function fetchRecord(itemId) {
            const data = {
                itemId: itemId,
                action: 'getCategory'
            };
            const success = function(response) {
                getdata(response);
            }
            const url = '../php/controller/commonController.php';
            performAjaxRequest(url, data, success);
        }

        function getdata(response) {
            $('#updateForm #id').val(response.id)
            $('#updateForm [name="name"]').val(response.name)
        }


        function initializeDataTable(tableId) {
            $(tableId).DataTable({
                processing: true,
                serverSide: false,
                bDestroy: true,
                columnDefs: [{
                    "targets": [-1],
                    "orderable": false
                }],
                bJQueryUI: true,
                ajax: {
                    url: '../php/controller/datatableController.php',
                    type: 'POST',
                    data: {
                        action: 'fetchCategory'
                    },
                    dataSrc: function(response) {
                        console.log(response)
                        return response.data;
                    },
                    // success: function(response) {
                    //     console.log(response)
                    // },
                },
                columns: [{
                        data: "id"
                    },
                    {
                        data: "name"
                    },
                    {
                        data: "created_at",
                    },
                    {
                        render: function(data, type, row) {
                            let btnGroupHTML = `
                                <div class="btn-group btn-group-sm">
                                    <button data-id="${row.id}" class="btn btn-success" onclick="edit(${row.id})">
                                        <i class="fas fa-user-edit"></i>
                                    </button>
                                    <button data-id="${row.id}" class="btn btn-danger ${row.count < 1 ? 'delete' : 'disabled'}">
                                    <i class="far fa-trash-alt"></i> ( ${row.count} )
                                </button>`;
                            btnGroupHTML += ` </div>`;
                            // console.log(row);
                            return btnGroupHTML;

                        }
                    }
                ]
            });
        }
    </script>
</body>

</html>