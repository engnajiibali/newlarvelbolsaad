<!DOCTYPE html>
<html>
<head>
    <title>Laravel 12 AJAX CRUD - SubDepartments</title>
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
        <h2 class="card-header"><i class="fa-solid fa-layer-group"></i> SubDepartments</h2>
        <div class="card-body">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                <a class="btn btn-success btn-sm" href="javascript:void(0)" id="createNewSubDepartment">
                    <i class="fa fa-plus"></i> Create New SubDepartment
                </a>
            </div>
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Department</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal for Create/Edit -->
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="subDepartmentForm" name="subDepartmentForm">
                   <input type="hidden" name="sub_department_id" id="sub_department_id">
                   @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">SubDepartment Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
                        <span class="text-danger error-text name_error"></span>
                    </div>

                    <div class="mb-3">
                        <label for="code" class="form-label">Code</label>
                        <input type="text" class="form-control" id="code" name="code" placeholder="Enter Code">
                        <span class="text-danger error-text code_error"></span>
                    </div>

                    <div class="mb-3">
                        <label for="department_id" class="form-label">Department</label>
                        <select class="form-control" id="department_id" name="department_id">
                            <option value="">Select Department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger error-text department_id_error"></span>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        <span class="text-danger error-text status_error"></span>
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

    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('sub-department.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'code', name: 'code'},
            {data: 'department_name', name: 'department_name'},
            {data: 'status', name: 'status', render: function(data){ return data==1 ? 'Active' : 'Inactive'; }},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    // Show Create Modal
    $('#createNewSubDepartment').click(function () {
        $('#saveBtn').val("create-subdepartment");
        $('#sub_department_id').val('');
        $('#subDepartmentForm').trigger("reset");
        $('.error-text').text('');
        $('#modelHeading').html("Create New SubDepartment");
        $('#ajaxModel').modal('show');
    });

    // Show Edit Modal
    $('body').on('click', '.editSubDepartment', function () {
        var id = $(this).data('id');
        $.get("{{ route('sub-department.index') }}/"+id+"/edit", function (data) {
            $('#modelHeading').html("Edit SubDepartment");
            $('#ajaxModel').modal('show');
            $('#sub_department_id').val(data.id);
            $('#name').val(data.name);
            $('#code').val(data.code);
            $('#department_id').val(data.department_id);
            $('#status').val(data.status);
            $('.error-text').text('');
        });
    });

    // Submit Form
    $('#subDepartmentForm').submit(function(e){
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            type:'POST',
            url: "{{ route('sub-department.store') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response){
                $('#subDepartmentForm').trigger("reset");
                $('#ajaxModel').modal('hide');
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

    // Delete
    $('body').on('click', '.deleteSubDepartment', function () {
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
                    url: "{{ route('sub-department.store') }}/"+id,
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
