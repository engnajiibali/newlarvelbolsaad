@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="card">
        <h2 class="card-header"><i class="fa-regular fa-credit-card"></i> Laravel 12 AJAX CRUD with Image & Validation</h2>
        <div class="card-body">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                <a class="btn btn-success btn-sm" href="javascript:void(0)" id="createNewProduct">
                    <i class="fa fa-plus"></i> Create New Product
                </a>
            </div>

            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Details</th>
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
                <form id="productForm" name="productForm" class="form-horizontal" enctype="multipart/form-data">
                   <input type="hidden" name="product_id" id="product_id">
                   @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" maxlength="50">
                        <span class="text-danger error-text name_error"></span>
                    </div>

                    <div class="mb-3">
                        <label for="detail" class="form-label">Details:</label>
                        <textarea id="detail" name="detail" placeholder="Enter Details" class="form-control"></textarea>
                        <span class="text-danger error-text detail_error"></span>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image:</label>
                        <input type="file" class="form-control" id="image" name="image">
                        <span class="text-danger error-text image_error"></span>
                        <img id="preview-image" src="" alt="Preview" class="mt-2" style="max-height: 150px; display:none;">
                    </div>

                    <button type="submit" class="btn btn-success" id="saveBtn" value="create">
                        <i class="fa fa-save"></i> Submit
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="employeeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="employeeForm">
            @csrf
            <input type="hidden" name="_method" id="method" value="POST">
            <input type="hidden" id="employee_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" id="name">
                        <span class="text-danger error-text name_error"></span>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" id="email">
                        <span class="text-danger error-text email_error"></span>
                    </div>
                    <div class="mb-3">
                        <label>Phone</label>
                        <input type="text" class="form-control" name="phone" id="phone">
                        <span class="text-danger error-text phone_error"></span>
                    </div>
                    <div class="mb-3">
                        <label>Designation</label>
                        <input type="text" class="form-control" name="designation" id="designation">
                        <span class="text-danger error-text designation_error"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
$(function () {

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('products.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {
                data: 'image', name: 'image', orderable: false, searchable: false,
                render: function(data){
                    if(data){ return '<img src="/storage/'+data+'" style="height:50px;width:50px;border-radius:5px;">'; }
                    else{ return 'No Image'; }
                }
            },
            {data: 'name', name: 'name'},
            {data: 'detail', name: 'detail'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    // Show Create Modal
    $('#createNewProduct').click(function () {
        $('#saveBtn').val("create-product");
        $('#product_id').val('');
        $('#productForm').trigger("reset");
        $('#preview-image').hide();
        $('.error-text').text('');
        $('#modelHeading').html("<i class='fa fa-plus'></i> Create New Product");
        $('#ajaxModel').modal('show');
    });

    // Show Edit Modal
    $('body').on('click', '.editProduct', function () {
        var product_id = $(this).data('id');
        $.get("{{ route('products.index') }}/"+product_id+"/edit", function (data) {
            $('#modelHeading').html("<i class='fa-regular fa-pen-to-square'></i> Edit Product");
            $('#saveBtn').val("edit-product");
            $('#ajaxModel').modal('show');
            $('#product_id').val(data.id);
            $('#name').val(data.name);
            $('#detail').val(data.detail);
            $('.error-text').text('');
            if(data.image){ $('#preview-image').attr('src','/storage/'+data.image).show(); }
            else{ $('#preview-image').hide(); }
        });
    });

    // Real-time client-side validation
    $('#name').on('input', function() {
        var value = $(this).val();
        if(value.length === 0){ $('.name_error').text('Name is required'); }
        else if(value.length > 50){ $('.name_error').text('Name cannot exceed 50 characters'); }
        else{ $('.name_error').text(''); }
    });

    $('#detail').on('input', function() {
        var value = $(this).val();
        if(value.length === 0){ $('.detail_error').text('Details are required'); }
        else{ $('.detail_error').text(''); }
    });

    $('#image').on('change', function() {
        var file = this.files[0];
        if(file){
            var validExtensions = ['image/jpeg','image/jpg','image/png','image/gif'];
            if(!validExtensions.includes(file.type)){
                $('.image_error').text('Only jpeg, jpg, png, gif images are allowed');
                $(this).val('');
                $('#preview-image').hide();
            } else if(file.size > 2*1024*1024){
                $('.image_error').text('Image size cannot exceed 2MB');
                $(this).val('');
                $('#preview-image').hide();
            } else {
                $('.image_error').text('');
                let reader = new FileReader();
                reader.onload = (e) => { $('#preview-image').attr('src', e.target.result).show(); }
                reader.readAsDataURL(file);
            }
        }
    });

    // Submit Form
    $('#productForm').submit(function(e) {
        e.preventDefault();

        $('#name').trigger('input');
        $('#detail').trigger('input');
        $('#image').trigger('change');

        if($('.error-text').filter(function(){ return $(this).text() != ''; }).length > 0){
            Swal.fire({ icon: 'error', title: 'Oops...', text: 'Please fix the errors!' });
            return;
        }

        let formData = new FormData(this);
        $('#saveBtn').html('Sending...');

        $.ajax({
            type:'POST',
            url: "{{ route('products.store') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: (response) => {
                $('#saveBtn').html('Submit');
                $('#productForm').trigger("reset");
                $('#preview-image').hide();
                $('.error-text').text('');
                $('#ajaxModel').modal('hide');
                table.draw();
                Swal.fire({ icon: 'success', title: 'Success!', text: response.message || 'Product saved successfully', timer: 2000, showConfirmButton: false });
            },
            error: function(response){
                $('#saveBtn').html('Submit');
                if(response.responseJSON && response.responseJSON.errors){
                    $.each(response.responseJSON.errors, function(key, value){
                        $('.'+key+'_error').text(value[0]);
                    });
                }
                Swal.fire({ icon: 'error', title: 'Oops...', text: 'Please fix the errors!' });
            }
        });
    });

    // Delete Product
    $('body').on('click', '.deleteProduct', function () {
        var product_id = $(this).data("id");
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if(result.isConfirmed){
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('products.store') }}/"+product_id,
                    success: function () {
                        table.draw();
                        Swal.fire({ icon: 'success', title: 'Deleted!', text: 'Product has been deleted.', timer: 2000, showConfirmButton: false });
                    },
                    error: function () { Swal.fire({ icon: 'error', title: 'Error!', text: 'Something went wrong!' }); }
                });
            }
        });
    });

});
</script>
@endpush
