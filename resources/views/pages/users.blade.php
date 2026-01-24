<!DOCTYPE html>
<html>
<head>
    <title>Laravel 12 AJAX CRUD - Users</title>
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
        .error-text { font-size: 0.875em; color:red; }
        #preview-photo { max-height: 150px; display:none; margin-top:10px; }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="card">
        <h2 class="card-header"><i class="fa-solid fa-users"></i> Users</h2>
        <div class="card-body">

            <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                <a class="btn btn-success btn-sm" href="javascript:void(0)" id="createNewUser">
                    <i class="fa fa-plus"></i> Create New User
                </a>
            </div>

            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Photo</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Department</th>
                        <th>Role</th>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="userForm" name="userForm" enctype="multipart/form-data">
                    <input type="hidden" name="user_id" id="user_id">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="full_name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Enter Full Name">
                            <span class="text-danger error-text full_name_error"></span>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email">
                            <span class="text-danger error-text email_error"></span>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number">
                            <span class="text-danger error-text phone_error"></span>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="department_id" class="form-label">Department</label>
                            <select class="form-control" id="department_id" name="department_id">
                                <option value="">Select Department</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text department_id_error"></span>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="role_id" class="form-label">Role</label>
                            <select class="form-control" id="role_id" name="role_id">
                                <option value="">Select Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->Role }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text role_id_error"></span>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            <span class="text-danger error-text status_error"></span>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="photo" class="form-label">Photo</label>
                            <input type="file" class="form-control" id="photo" name="photo">
                            <span class="text-danger error-text photo_error"></span>
                            <img id="preview-photo" src="" alt="Preview">
                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                            <span class="text-danger error-text password_error"></span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success" id="saveBtn" value="create">
                        <i class="fa fa-save"></i> Submit
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script type="text/javascript">
$(function () {

    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    // Initialize DataTable
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('users.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable:false, searchable:false},
            {data: 'photo', name: 'photo', orderable:false, searchable:false, render:function(data){
                return data ? '<img src="/storage/'+data+'" width="50" height="50" style="border-radius:50%">' : 'No Photo';
            }},
            {data: 'full_name', name: 'full_name'},
            {data: 'email', name: 'email'},
            {data: 'phone', name: 'phone'},
            {data: 'department_name', name: 'department_name'},
            {data: 'role_name', name: 'role_name'},
            {data: 'status', name: 'status', render:function(data){ return data==1 ? 'Active':'Inactive'; }},
            {data: 'action', name: 'action', orderable:false, searchable:false},
        ]
    });

    // Show Create Modal
    $('#createNewUser').click(function () {
        $('#saveBtn').val("create-user");
        $('#user_id').val('');
        $('#userForm').trigger("reset");
        $('#preview-photo').hide();
        $('.error-text').text('');
        $('#modelHeading').html("<i class='fa fa-plus'></i> Create New User");
        $('#ajaxModel').modal('show');
    });

    // Show Edit Modal
    $('body').on('click', '.editUser', function () {
        var user_id = $(this).data('id');
        $.get("/users/"+user_id+"/edit", function (data) {
            $('#modelHeading').html("<i class='fa fa-edit'></i> Edit User");
            $('#saveBtn').val("edit-user");
            $('#ajaxModel').modal('show');
            $('#user_id').val(data.id);
            $('#full_name').val(data.full_name);
            $('#email').val(data.email);
            $('#phone').val(data.phone);
            $('#department_id').val(data.department_id);
            $('#role_id').val(data.role_id);
            $('#status').val(data.status);
            $('.error-text').text('');
            if(data.photo){ $('#preview-photo').attr('src','/storage/'+data.photo).show(); } else{ $('#preview-photo').hide(); }
        });
    });

    // Preview Photo
    $('#photo').on('change', function() {
        var reader = new FileReader();
        reader.onload = function(e){ $('#preview-photo').attr('src', e.target.result).show(); }
        reader.readAsDataURL(this.files[0]);
    });

    // Submit Form (Create/Update)
    $('#userForm').submit(function(e){
        e.preventDefault();
        let user_id = $('#user_id').val();
        let url = user_id ? "/users/"+user_id : "{{ route('users.store') }}";
        let formData = new FormData(this);
        if(user_id) formData.append('_method','PUT');

        $('#saveBtn').html('Saving...');
        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            contentType: false,
            processData: false,
            success: function(response){
                $('#saveBtn').html('Submit');
                $('#userForm').trigger("reset");
                $('#preview-photo').hide();
                $('.error-text').text('');
                $('#ajaxModel').modal('hide');
                table.draw();
                Swal.fire({ icon:'success', title:'Success!', text: response.message, timer:2000, showConfirmButton:false });
            },
            error: function(response){
                $('#saveBtn').html('Submit');
                if(response.responseJSON && response.responseJSON.errors){
                    $.each(response.responseJSON.errors, function(key,value){
                        $('.'+key+'_error').text(value[0]);
                    });
                }
            }
        });
    });

    // Delete User
    $('body').on('click', '.deleteUser', function(){
        var user_id = $(this).data("id");
        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton:true,
            confirmButtonText:'Yes, delete!',
        }).then((result)=>{
            if(result.isConfirmed){
                $.ajax({
                    type:"DELETE",
                    url:"/users/"+user_id,
                    success:function(){ 
                        table.draw(); 
                        Swal.fire({ icon:'success', title:'Deleted!', timer:2000, showConfirmButton:false }); 
                    }
                });
            }
        });
    });

    // Reset modal on close
    $('#ajaxModel').on('hidden.bs.modal', function () {
        $('#userForm').trigger("reset");
        $('#preview-photo').hide();
        $('.error-text').text('');
        $('#user_id').val('');
    });

});
</script>

</body>
</html>
