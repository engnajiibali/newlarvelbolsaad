<!DOCTYPE html>
<html>
<head>
    <title>Laravel 12 AJAX CRUD - Unit</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style> .error-text { font-size: 0.875em; } </style>
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <h2 class="card-header"><i class="fa-solid fa-building"></i> Unit Management</h2>
        <div class="card-body">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                <a class="btn btn-success btn-sm" href="javascript:void(0)" id="createNewUnit">
                    <i class="fa fa-plus"></i> Create New Unit
                </a>
            </div>

            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Unit Name</th>
                        <th>Status</th>
                     
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="unitForm" name="unitForm">
                    <input type="hidden" name="UnitId" id="UnitId">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Unit Name:</label>
                        <input type="text" class="form-control" id="UnitName" name="UnitName">
                        <span class="text-danger error-text UnitName_error"></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status:</label>
                        <select class="form-control" id="Status" name="Status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        <span class="text-danger error-text Status_error"></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">User ID:</label>
                        <input type="number" class="form-control" id="UserId" name="UserId">
                        <span class="text-danger error-text UserId_error"></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Finish Date:</label>
                        <input type="date" class="form-control" id="FinishDate" name="FinishDate">
                        <span class="text-danger error-text FinishDate_error"></span>
                    </div>

                    <button type="submit" class="btn btn-success" id="saveBtn">Submit</button>
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
        ajax: "{{ route('units.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable:false, searchable:false},
            {data: 'UnitName', name: 'UnitName'},
            {data: 'Status', name: 'Status', orderable:false, searchable:false},
            {data: 'action', name: 'action', orderable:false, searchable:false}
        ]
    });

    // Create New Unit
    $('#createNewUnit').click(function(){
        $('#saveBtn').val("create-unit");
        $('#UnitId').val('');
        $('#unitForm').trigger("reset");
        $('.error-text').text('');
        $('#modelHeading').html("<i class='fa fa-plus'></i> Create Unit");
        $('#ajaxModel').modal('show');
    });

    // Edit Unit
    $('body').on('click', '.editUnit', function(){
        var id = $(this).data('id');
        $.get("{{ route('units.index') }}/"+id+"/edit", function(data){
            $('#modelHeading').html("<i class='fa fa-edit'></i> Edit Unit");
            $('#saveBtn').val("edit-unit");
            $('#ajaxModel').modal('show');
            $('#UnitId').val(data.UnitId);
            $('#UnitName').val(data.UnitName);
            $('#Status').val(data.Status ? 1 : 0);
            $('#UserId').val(data.UserId);
            $('#FinishDate').val(data.FinishDate ? data.FinishDate.substring(0,10) : '');
            $('.error-text').text('');
        });
    });

    // Save / Update
    $('#unitForm').submit(function(e){
        e.preventDefault();
        $('.error-text').text('');
        let formData = new FormData(this);
        $('#saveBtn').html('Sending...');
        $.ajax({
            type:'POST',
            url:"{{ route('units.store') }}",
            data: formData,
            contentType:false,
            processData:false,
            success: function(response){
                $('#saveBtn').html('Submit');
                $('#unitForm').trigger("reset");
                $('.error-text').text('');
                $('#ajaxModel').modal('hide');
                table.draw();
                Swal.fire({ icon:'success', title:'Success!', text:response.message, timer:2000, showConfirmButton:false });
            },
            error: function(response){
                $('#saveBtn').html('Submit');
                if(response.responseJSON && response.responseJSON.errors){
                    $.each(response.responseJSON.errors, function(key,value){ $('.'+key+'_error').text(value[0]); });
                }
                Swal.fire({ icon:'error', title:'Oops!', text:'Please fix errors!' });
            }
        });
    });

    // Delete
    $('body').on('click', '.deleteUnit', function(){
        var id = $(this).data('id');
        Swal.fire({
            title:'Are you sure?',
            text:"You won't be able to revert this!",
            icon:'warning',
            showCancelButton:true,
            confirmButtonColor:'#3085d6',
            cancelButtonColor:'#d33',
            confirmButtonText:'Yes, delete it!'
        }).then((result)=>{
            if(result.isConfirmed){
                $.ajax({
                    type:'DELETE',
                    url:"{{ route('units.store') }}/"+id,
                    success:function(){
                        table.draw();
                        Swal.fire({ icon:'success', title:'Deleted!', text:'Unit deleted.', timer:2000, showConfirmButton:false });
                    },
                    error:function(){
                        Swal.fire({ icon:'error', title:'Error!', text:'Something went wrong!' });
                    }
                });
            }
        });
    });
});
</script>
</body>
</html>
