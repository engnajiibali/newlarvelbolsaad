<!DOCTYPE html>
<html>
<head>
    <title>Laravel 12 AJAX CRUD - ItemType</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <h2 class="card-header"><i class="fa-solid fa-boxes-stacked"></i> ItemType Management</h2>
        <div class="card-body">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                <a class="btn btn-success btn-sm" href="javascript:void(0)" id="createNewItemType">
                    <i class="fa fa-plus"></i> Create New ItemType
                </a>
            </div>

            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ItemType Name</th>
                        <th>Waax ID</th>
                        <th>User ID</th>
                        <th>Created Date</th>
                        <th>Finish Date</th>
                        <th>Updated Date</th>
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
                <form id="itemtypeForm" name="itemtypeForm">
                    <input type="hidden" name="itemtype_id" id="itemtype_id">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">ItemType Name:</label>
                        <input type="text" class="form-control" id="ItemTypeName" name="ItemTypeName">
                        <span class="text-danger error-text ItemTypeName_error"></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Waax ID:</label>
                        <input type="number" class="form-control" id="WaaxId" name="WaaxId">
                        <span class="text-danger error-text WaaxId_error"></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Finish Date:</label>
                        <input type="date" class="form-control" id="FinishDate" name="FinishDate">
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
        ajax: "{{ route('itemtypes.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable:false, searchable:false},
            {data: 'ItemTypeName', name: 'ItemTypeName'},
            {data: 'departments', name: 'departments'},
            {data: 'UserId', name: 'UserId'},
            {data: 'itemtypeCreateDate', name: 'itemtypeCreateDate'},
            {data: 'FinishDate', name: 'FinishDate'},
            {data: 'itemtypeUpdateDate', name: 'itemtypeUpdateDate'},
            {data: 'action', name: 'action', orderable:false, searchable:false}
        ]
    });

    $('#createNewItemType').click(function(){
        $('#saveBtn').val("create-itemtype");
        $('#itemtype_id').val('');
        $('#itemtypeForm').trigger("reset");
        $('.error-text').text('');
        $('#modelHeading').html("<i class='fa fa-plus'></i> Create ItemType");
        $('#ajaxModel').modal('show');
    });

    $('body').on('click', '.editItemType', function(){
        var id = $(this).data('id');
        $.get("{{ route('itemtypes.index') }}/"+id+"/edit", function(data){
            $('#modelHeading').html("<i class='fa fa-edit'></i> Edit ItemType");
            $('#saveBtn').val("edit-itemtype");
            $('#ajaxModel').modal('show');
            $('#itemtype_id').val(data.ItemTypeId);
            $('#ItemTypeName').val(data.ItemTypeName);
            $('#WaaxId').val(data.WaaxId);
            $('#FinishDate').val(data.FinishDate);
            $('.error-text').text('');
        });
    });

    $('#itemtypeForm').submit(function(e){
        e.preventDefault();
        $('.error-text').text('');
        let formData = new FormData(this);
        $('#saveBtn').html('Sending...');
        $.ajax({
            type:'POST',
            url:"{{ route('itemtypes.store') }}",
            data: formData,
            contentType:false,
            processData:false,
            success: function(response){
                $('#saveBtn').html('Submit');
                $('#itemtypeForm').trigger("reset");
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

    $('body').on('click', '.deleteItemType', function(){
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
                    url:"{{ route('itemtypes.store') }}/"+id,
                    success:function(){
                        table.draw();
                        Swal.fire({ icon:'success', title:'Deleted!', text:'ItemType deleted.', timer:2000, showConfirmButton:false });
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
