@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="card">
        <h2 class="card-header"><i class="fa-solid fa-box"></i> Item Management</h2>
        <div class="card-body">

            <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                <a class="btn btn-success btn-sm" href="javascript:void(0)" id="createNewItem">
                    <i class="fa fa-plus"></i> Create New Item
                </a>
            </div>

            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Item Name</th>
                        <th>Unit</th>
                        <th>Item Type</th>
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
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="loadingSpinner" class="text-center my-3" style="display:none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <form id="itemForm" name="itemForm" style="display:none;">
                    @csrf
                    <input type="hidden" name="ItemId" id="ItemId">

                    <div class="row g-3">
                        <!-- Item Name -->
                        <div class="col-md-6">
                            <label class="form-label">Item Name</label>
                            <input type="text" class="form-control" id="ItemName" name="ItemName">
                            <span class="text-danger error-text ItemName_error"></span>
                        </div>

                        <!-- Unit -->
                        <div class="col-md-6">
                            <label class="form-label">Unit</label>
                            <select class="form-select" id="UnitId" name="UnitId">
                                <option value="">Select Unit</option>
                                @foreach($units as $unit)
                                    <option value="{{ $unit->UnitId }}">{{ $unit->UnitName }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text UnitId_error"></span>
                        </div>

                        <!-- Item Type -->
                        <div class="col-md-6">
                            <label class="form-label">Item Type</label>
                            <input type="text" class="form-control" id="ItemType" name="ItemType">
                            <span class="text-danger error-text ItemType_error"></span>
                        </div>

                        <!-- Cabirka Keedinta -->
                        <div class="col-md-6">
                            <label class="form-label">Cabirka Keedinta</label>
                            <input type="text" class="form-control" id="CabirkaKeedinta" name="CabirkaKeedinta">
                        </div>

                        <!-- Cabirka Bixinta -->
                        <div class="col-md-6">
                            <label class="form-label">Cabirka Bixinta</label>
                            <input type="text" class="form-control" id="CabirkaBixinta" name="CabirkaBixinta">
                        </div>

                        <!-- Waax -->
                        <div class="col-md-6">
                            <label class="form-label">Waax</label>
                            <select class="form-select" id="WaaxId" name="WaaxId">
                                <option value="">Select Waax</option>
                                @foreach($waax as $wx)
                                    <option value="{{ $wx->id }}">{{ $wx->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text WaaxId_error"></span>
                        </div>

                        <!-- User -->
                        <div class="col-md-6">
                            <label class="form-label">User</label>
                            <select class="form-select" id="UserId" name="UserId">
                                <option value="">Select User</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id  }}">{{ $user->full_name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text UserId_error"></span>
                        </div>

                        <!-- Status -->
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select class="form-select" id="Status" name="Status">
                                <option value="0">Active</option>
                                <option value="1">Inactive</option>
                            </select>
                            <span class="text-danger error-text Status_error"></span>
                        </div>

                        <!-- Finish Date -->
                        <div class="col-md-6">
                            <label class="form-label">Finish Date</label>
                            <input type="date" class="form-control" id="FinishDate" name="FinishDate">
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">
                            <i class="fa fa-times"></i> Close
                        </button>
                        <button type="submit" class="btn btn-success" id="saveBtn">
                            <i class="fa fa-save"></i> Save
                        </button>
                    </div>
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
        ajax: "{{ route('items.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable:false, searchable:false},
            {data: 'ItemName', name: 'ItemName'},
            {data: 'unit', name: 'unit'},
            {data: 'ItemType', name: 'ItemType'},
            {data: 'Status', name: 'Status', orderable:false, searchable:false},
            {data: 'action', name: 'action', orderable:false, searchable:false}
        ]
    });

    // Create new
    $('#createNewItem').click(function(){
        $('#itemForm').hide();
        $('#loadingSpinner').show();
        $('#saveBtn').val("create-item");
        $('#ItemId').val('');
        $('#itemForm').trigger("reset");
        $('.error-text').text('');
        $('#modelHeading').html("<i class='fa fa-plus'></i> Create Item");
        $('#ajaxModel').modal('show');
        setTimeout(()=>{ // simulate loading
            $('#loadingSpinner').hide();
            $('#itemForm').show();
        }, 300);
    });

    // Edit
    $('body').on('click', '.editItem', function(){
        var id = $(this).data('id');
        $('#itemForm').hide();
        $('#loadingSpinner').show();
        $('#ajaxModel').modal('show');
        $('#modelHeading').html("<i class='fa fa-edit'></i> Edit Item");

        $.get("{{ route('items.index') }}/"+id+"/edit", function(data){
            $('#ItemId').val(data.ItemId);
            $('#ItemName').val(data.ItemName);
            $('#UnitId').val(data.UnitId);
            $('#ItemType').val(data.ItemType);
            $('#CabirkaKeedinta').val(data.CabirkaKeedinta);
            $('#CabirkaBixinta').val(data.CabirkaBixinta);
            $('#WaaxId').val(data.WaaxId);
            $('#UserId').val(data.UserId);
            $('#Status').val(data.Status);
            $('#FinishDate').val(data.FinishDate);
            $('.error-text').text('');
        }).always(function(){
            $('#loadingSpinner').hide();
            $('#itemForm').show();
        });
    });

    // Save
    $('#itemForm').submit(function(e){
        e.preventDefault();
        $('.error-text').text('');
        let formData = new FormData(this);
        $('#saveBtn').html('Sending...');
        $.ajax({
            type:'POST',
            url:"{{ route('items.store') }}",
            data: formData,
            contentType:false,
            processData:false,
            success: function(response){
                $('#saveBtn').html('Save');
                $('#itemForm').trigger("reset");
                $('#ajaxModel').modal('hide');
                table.ajax.reload(null, false);
                Swal.fire({ icon:'success', title:'Success!', text:response.success, timer:2000, showConfirmButton:false });
            },
            error: function(response){
                $('#saveBtn').html('Save');
                if(response.responseJSON && response.responseJSON.errors){
                    $.each(response.responseJSON.errors, function(key,value){ $('.'+key+'_error').text(value[0]); });
                }
                Swal.fire({ icon:'error', title:'Oops!', text:'Please fix errors!' });
            }
        });
    });

    // Delete
    $('body').on('click', '.deleteItem', function(){
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
                    url:"{{ route('items.store') }}/"+id,
                    success:function(){
                        table.ajax.reload(null, false);
                        Swal.fire({ icon:'success', title:'Deleted!', text:'Item deleted.', timer:2000, showConfirmButton:false });
                    },
                    error:function(){
                        Swal.fire({ icon:'error', title:'Error!', text:'Something went wrong!' });
                    }
                });
            }
        });
    });

    // Toggle Status
    $('body').on('click', '.toggleStatus', function(){
        var id = $(this).data('id');
        $.ajax({
            type:'POST',
            url:"{{ url('items') }}/" + id + "/toggle-status",
            data: { _token: $('meta[name="csrf-token"]').attr('content') },
            success:function(response){
                if(response.success){
                    Swal.fire({ icon:'success', title:'Status Changed!', text:response.message, timer:1500, showConfirmButton:false });
                    table.ajax.reload(null, false);
                }
            },
            error:function(){
                Swal.fire({ icon:'error', title:'Error!', text:'Unable to change status!' });
            }
        });
    });

    // Reset form on modal close
    $('#ajaxModel').on('hidden.bs.modal', function () {
        $('#itemForm').trigger("reset");
        $('.error-text').text('');
    });
});
</script>
@endpush
