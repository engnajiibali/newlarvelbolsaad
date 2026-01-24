<!DOCTYPE html>
<html>
<head>
    <title>Laravel 12 AJAX CRUD - Menus</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .error-text { font-size: 0.875em; }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <h2 class="card-header"><i class="fa-solid fa-list"></i> Menus</h2>
        <div class="card-body">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                <a class="btn btn-success btn-sm" href="javascript:void(0)" id="createNewMenu">
                    <i class="fa fa-plus"></i> Create New Menu
                </a>
            </div>

            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Menu Name</th>
                        <th>Order</th>
                        <th>Icon</th>
                        <th>Status</th>
                        <th width="120px">Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="menuModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title" id="modelHeading"></h4></div>
            <div class="modal-body">
                <form id="menuForm" name="menuForm" class="form-horizontal">
                   <input type="hidden" name="menu_id" id="menu_id">
                   @csrf
                    <div class="mb-3">
                        <label class="form-label">Menu Name:</label>
                        <input type="text" class="form-control" id="menu_name" name="menu_name" maxlength="100">
                        <span class="text-danger error-text menu_name_error"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Menu Order:</label>
                        <input type="number" class="form-control" id="menu_order" name="menu_order">
                        <span class="text-danger error-text menu_order_error"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Icon:</label>
                        <input type="text" class="form-control" id="icon" name="icon">
                        <span class="text-danger error-text icon_error"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status:</label>
                        <select class="form-control" id="status" name="status">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        <span class="text-danger error-text status_error"></span>
                    </div>
                    <button type="submit" class="btn btn-success" id="saveBtn"><i class="fa fa-save"></i> Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- jQuery + Bootstrap + DataTables -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(function () {
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    let table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('menus.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'menu_name', name: 'menu_name'},
            {data: 'menu_order', name: 'menu_order'},
            {data: 'icon', name: 'icon'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $('#createNewMenu').click(function () {
        $('#saveBtn').val("create-menu");
        $('#menu_id').val('');
        $('#menuForm').trigger("reset");
        $('.error-text').text('');
        $('#modelHeading').html("Create New Menu");
        $('#menuModal').modal('show');
    });

    $('body').on('click', '.editMenu', function () {
        var id = $(this).data('id');
        $.get("{{ route('menus.index') }}/"+id+"/edit", function (data) {
            $('#modelHeading').html("Edit Menu");
            $('#saveBtn').val("edit-menu");
            $('#menuModal').modal('show');
            $('#menu_id').val(data.id);
            $('#menu_name').val(data.menu_name);
            $('#menu_order').val(data.menu_order);
            $('#icon').val(data.icon);
            $('#status').val(data.status);
        });
    });

    $('#menuForm').submit(function(e){
        e.preventDefault();
        let formData = new FormData(this);
        $('#saveBtn').html('Sending...');
        $.ajax({
            type:'POST',
            url: "{{ route('menus.store') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response){
                $('#saveBtn').html('Submit');
                $('#menuForm').trigger("reset");
                $('#menuModal').modal('hide');
                table.draw();
                Swal.fire({ icon: 'success', title: 'Success!', text: response.message, timer: 2000, showConfirmButton: false });
            },
            error: function(response){
                $('#saveBtn').html('Submit');
                if(response.responseJSON.errors){
                    $.each(response.responseJSON.errors, function(key, value){
                        $('.'+key+'_error').text(value[0]);
                    });
                }
            }
        });
    });

    $('body').on('click', '.deleteMenu', function () {
        var id = $(this).data("id");
        Swal.fire({
            title: 'Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if(result.isConfirmed){
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('menus.store') }}/"+id,
                    success: function () {
                        table.draw();
                        Swal.fire({ icon: 'success', title: 'Deleted!', timer: 2000, showConfirmButton: false });
                    }
                });
            }
        });
    });
});
</script>
</body>
</html>
