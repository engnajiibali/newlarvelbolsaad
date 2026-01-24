@extends('layouts.admin')

@section('title', 'Keydin List')

@section('content')
  <div class="card">
        <h2 class="card-header"><i class="fa-solid fa-building"></i> departments</h2>
        <div class="card-body">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                <a class="btn btn-success btn-sm" href="javascript:void(0)" id="createNewDepartment">
                    <i class="fa fa-plus"></i> Create New Department
                </a>
            </div>
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
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
                <form id="departmentForm" name="departmentForm">
                   <input type="hidden" name="department_id" id="department_id">
                   @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Department Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
                        <span class="text-danger error-text name_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="code" class="form-label">Code</label>
                        <input type="text" class="form-control" id="code" name="code" placeholder="Enter Code">
                        <span class="text-danger error-text code_error"></span>
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
@endsection

@push('scripts')
<script type="text/javascript">
$(function () {
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('departments.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'code', name: 'code'},
            {data: 'status', name: 'status', render: function(data){ return data==1 ? 'Active' : 'Inactive'; }},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $('#createNewDepartment').click(function () {
        $('#saveBtn').val("create-department");
        $('#department_id').val('');
        $('#departmentForm').trigger("reset");
        $('.error-text').text('');
        $('#modelHeading').html("Create New Department");
        $('#ajaxModel').modal('show');
    });

    $('body').on('click', '.editDepartment', function () {
        var id = $(this).data('id');
        $.get("{{ route('departments.index') }}/"+id+"/edit", function (data) {
            $('#modelHeading').html("Edit Department");
            $('#ajaxModel').modal('show');
            $('#department_id').val(data.id);
            $('#name').val(data.name);
            $('#code').val(data.code);
            $('#status').val(data.status);
            $('.error-text').text('');
        });
    });

    $('#departmentForm').submit(function(e){
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            type:'POST',
            url: "{{ route('departments.store') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response){
                $('#departmentForm').trigger("reset");
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

    $('body').on('click', '.deleteDepartment', function () {
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
                    url: "{{ route('departments.store') }}/"+id,
                    success: function () { table.draw(); Swal.fire({ icon: 'success', title: 'Deleted!', timer: 2000, showConfirmButton: false }); }
                });
            }
        });
    });
});
</script>
@endpush
