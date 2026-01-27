@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <div class="card">
        <h2 class="card-header"><i class="fa-solid fa-store"></i> Stores</h2>
        <div class="card-body">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                <a class="btn btn-success btn-sm" href="javascript:void(0)" id="createNewStore">
                    <i class="fa fa-plus"></i> Create New Store
                </a>
            </div>
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Store Name</th>
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
                <form id="storeForm" name="storeForm">
                   <input type="hidden" name="store_id" id="store_id">
                   @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Store Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Store Name">
                        <span class="text-danger error-text name_error"></span>
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
@endsection

@push('scripts')
<script>
$(function () {
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('stores.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'StoreName', name: 'StoreName'},
            {data: 'department_name', name: 'department_name'},
            {data: 'status', name: 'status', render: function(data){ return data==1 ? 'Active' : 'Inactive'; }},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $('#createNewStore').click(function () {
        $('#saveBtn').val("create-store");
        $('#store_id').val('');
        $('#storeForm').trigger("reset");
        $('.error-text').text('');
        $('#modelHeading').html("Create New Store");
        $('#ajaxModel').modal('show');
    });

    $('body').on('click', '.editStore', function () {
        var id = $(this).data('id');
        $.get("{{ route('stores.index') }}/"+id+"/edit", function (data) {
            $('#modelHeading').html("Edit Store");
            $('#ajaxModel').modal('show');
            $('#store_id').val(data.id);
            $('#name').val(data.name);
            $('#department_id').val(data.department_id);
            $('#status').val(data.status);
            $('.error-text').text('');
        });
    });

    $('#storeForm').submit(function(e){
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            type:'POST',
            url: "{{ route('stores.store') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response){
                $('#storeForm').trigger("reset");
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

    $('body').on('click', '.deleteStore', function () {
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
                    url: "{{ route('stores.store') }}/"+id,
                    success: function () { table.draw(); Swal.fire({ icon: 'success', title: 'Deleted!', timer: 2000, showConfirmButton: false }); }
                });
            }
        });
    });
});
</script>
@endpush
