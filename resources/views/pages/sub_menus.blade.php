<!DOCTYPE html>
<html>
<head>
    <title>Laravel 12 AJAX CRUD - Sub Menus</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>.error-text { font-size: 0.875em; }</style>
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <h2 class="card-header"><i class="fa-solid fa-bars"></i> Sub Menus</h2>
        <div class="card-body">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                <a class="btn btn-success btn-sm" href="javascript:void(0)" id="createNewSubMenu">
                    <i class="fa fa-plus"></i> Create New Sub Menu
                </a>
            </div>

            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Sub Menu</th>
                        <th>Menu</th>
                        <th>Order</th>
                        <th>URL</th>
                        <th>Icon</th>
                        <th>Title</th>
                        <th>Target</th>
                        <th width="120px">Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="submenuModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title" id="modelHeading"></h4></div>
            <div class="modal-body">
                <form id="submenuForm" name="submenuForm">
                   <input type="hidden" name="submenu_id" id="submenu_id">
                   @csrf
                   <div class="mb-3">
                        <label class="form-label">Sub Menu Name</label>
                        <input type="text" class="form-control" id="name_sub_menu" name="name_sub_menu">
                        <span class="text-danger error-text name_sub_menu_error"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Menu</label>
                        <select class="form-control" id="menu_id" name="menu_id">
                            @foreach($menus as $menu)
        <option value="{{ $menu->id }}">{{ $menu->menu_name }}</option>
    @endforeach
                        </select>
                        <span class="text-danger error-text menu_id_error"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Order</label>
                        <input type="number" class="form-control" id="sub_menu_order" name="sub_menu_order">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">URL</label>
                        <input type="text" class="form-control" id="url" name="url">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Icon</label>
                        <input type="text" class="form-control" id="icon" name="icon">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Target</label>
                        <select class="form-control" id="target" name="target">
                            <option value="_self">Self</option>
                            <option value="_blank">Blank</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success" id="saveBtn"><i class="fa fa-save"></i> Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

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
        ajax: "{{ route('sub-menus.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name_sub_menu', name: 'name_sub_menu'},
            {data: 'menu_name', name: 'menu_name'},
            {data: 'sub_menu_order', name: 'sub_menu_order'},
            {data: 'url', name: 'url'},
            {data: 'icon', name: 'icon'},
            {data: 'title', name: 'title'},
            {data: 'target', name: 'target'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $('#createNewSubMenu').click(function () {
        $('#submenu_id').val('');
        $('#submenuForm').trigger("reset");
        $('.error-text').text('');
        $('#modelHeading').html("Create New Sub Menu");
        $('#submenuModal').modal('show');
    });

    $('body').on('click', '.editSubMenu', function () {
        var id = $(this).data('id');
        $.get("{{ route('sub-menus.index') }}/"+id+"/edit", function (data) {
            $('#modelHeading').html("Edit Sub Menu");
            $('#submenuModal').modal('show');
            $('#submenu_id').val(data.id);
            $('#name_sub_menu').val(data.name_sub_menu);
            $('#menu_id').val(data.menu_id);
            $('#sub_menu_order').val(data.sub_menu_order);
            $('#url').val(data.url);
            $('#icon').val(data.icon);
            $('#title').val(data.title);
            $('#target').val(data.target);
        });
    });

    $('#submenuForm').submit(function(e){
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            type:'POST',
            url: "{{ route('sub-menus.store') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response){
                $('#submenuForm').trigger("reset");
                $('#submenuModal').modal('hide');
                table.draw();
                Swal.fire({ icon: 'success', title: 'Success!', text: response.message, timer: 2000, showConfirmButton: false });
            },
            error: function(response){
                if(response.responseJSON.errors){
                    $.each(response.responseJSON.errors, function(key, value){
                        $('.'+key+'_error').text(value[0]);
                    });
                }
            }
        });
    });

    $('body').on('click', '.deleteSubMenu', function () {
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
                    url: "{{ route('sub-menus.store') }}/"+id,
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
