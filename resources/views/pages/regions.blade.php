<!DOCTYPE html>
<html>
<head>
    <title>Laravel 12 AJAX CRUD - Region</title>
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
        <h2 class="card-header"><i class="fa-regular fa-map"></i> Region Management</h2>
        <div class="card-body">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                <a class="btn btn-success btn-sm" href="javascript:void(0)" id="createNewRegion">
                    <i class="fa fa-plus"></i> Create New Region
                </a>
            </div>

            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>State</th>
                        <th>Country</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
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
                <form id="regionForm" name="regionForm" enctype="multipart/form-data">
                    <input type="hidden" name="region_id" id="region_id">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Country:</label>
                        <select id="country_id" name="country_id" class="form-control">
                            <option value="">-- Select Country --</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger error-text country_id_error"></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">State:</label>
                        <select id="state_id" name="state_id" class="form-control">
                            <option value="">-- Select State --</option>
                        </select>
                        <span class="text-danger error-text state_id_error"></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Name:</label>
                        <input type="text" class="form-control" id="name" name="name">
                        <span class="text-danger error-text name_error"></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Latitude:</label>
                        <input type="text" class="form-control" id="latitude" name="latitude">
                        <span class="text-danger error-text latitude_error"></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Longitude:</label>
                        <input type="text" class="form-control" id="longitude" name="longitude">
                        <span class="text-danger error-text longitude_error"></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Image:</label>
                        <input type="file" class="form-control" id="image" name="image">
                        <span class="text-danger error-text image_error"></span>
                        <img id="preview-image" src="" alt="Preview" class="mt-2" style="max-height:150px; display:none;">
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

    // Fetch states when country changes
    $('#country_id').change(function(){
        var countryId = $(this).val();
        $('#state_id').html('<option value="">-- Select State --</option>');
        if(countryId){
            $.get("/get-states/"+countryId, function(data){
                $.each(data, function(key,value){
                    $('#state_id').append('<option value="'+value.id+'">'+value.name+'</option>');
                });
            });
        }
    });

    var table = $('.data-table').DataTable({
        processing:true,
        serverSide:true,
        ajax:"{{ route('regions.index') }}",
        columns:[
            {data:'DT_RowIndex',name:'DT_RowIndex',orderable:false,searchable:false},
            {data:'image',name:'image',orderable:false,searchable:false,render:function(data){ return data? '<img src="/storage/'+data+'" style="height:50px;width:50px;border-radius:5px;">':'No Image'; }},
            {data:'name',name:'name'},
            {data:'state_name',name:'state_name'},
            {data:'country_name',name:'country_name'},
            {data:'latitude',name:'latitude'},
            {data:'longitude',name:'longitude'},
            {data:'action',name:'action',orderable:false,searchable:false},
        ]
    });

    $('#createNewRegion').click(function(){
        $('#saveBtn').val("create-region");
        $('#region_id').val('');
        $('#regionForm').trigger("reset");
        $('#preview-image').hide();
        $('.error-text').text('');
        $('#modelHeading').html("<i class='fa fa-plus'></i> Create Region");
        $('#ajaxModel').modal('show');
    });

    $('body').on('click', '.editRegion', function(){
        var id = $(this).data('id');
        $.get("{{ route('regions.index') }}/"+id+"/edit", function(data){
            $('#modelHeading').html("<i class='fa fa-edit'></i> Edit Region");
            $('#saveBtn').val("edit-region");
            $('#ajaxModel').modal('show');
            $('#region_id').val(data.id);
            $('#name').val(data.name);
            $('#latitude').val(data.latitude);
            $('#longitude').val(data.longitude);
            $('#country_id').val(data.country_id).trigger('change');
            setTimeout(function(){ $('#state_id').val(data.state_id); }, 500);
            if(data.image){ $('#preview-image').attr('src','/storage/'+data.image).show(); } else { $('#preview-image').hide(); }
            $('.error-text').text('');
        });
    });

    $('#image').change(function(){
        var file = this.files[0];
        if(file){
            var validTypes = ['image/jpeg','image/jpg','image/png','image/gif'];
            if(!validTypes.includes(file.type)){ $('.image_error').text('Invalid image'); $(this).val(''); $('#preview-image').hide(); return; }
            if(file.size>2*1024*1024){ $('.image_error').text('Max 2MB'); $(this).val(''); $('#preview-image').hide(); return; }
            $('.image_error').text('');
            var reader = new FileReader();
            reader.onload = function(e){ $('#preview-image').attr('src',e.target.result).show(); }
            reader.readAsDataURL(file);
        }
    });

    $('#regionForm').submit(function(e){
        e.preventDefault();
        $('.error-text').text('');
        let formData = new FormData(this);
        $('#saveBtn').html('Sending...');
        $.ajax({
            type:'POST',
            url:"{{ route('regions.store') }}",
            data:formData,
            contentType:false,
            processData:false,
            success:function(response){
                $('#saveBtn').html('Submit');
                $('#regionForm').trigger("reset");
                $('#preview-image').hide();
                $('.error-text').text('');
                $('#ajaxModel').modal('hide');
                table.draw();
                Swal.fire({icon:'success',title:'Success!',text:response.message,timer:2000,showConfirmButton:false});
            },
            error:function(response){
                $('#saveBtn').html('Submit');
                if(response.responseJSON && response.responseJSON.errors){
                    $.each(response.responseJSON.errors,function(key,value){ $('.'+key+'_error').text(value[0]); });
                }
                Swal.fire({icon:'error',title:'Oops!',text:'Please fix errors!'});
            }
        });
    });

    $('body').on('click','.deleteRegion',function(){
        var id = $(this).data('id');
        Swal.fire({
            title:'Are you sure?',text:"You won't be able to revert this!",icon:'warning',
            showCancelButton:true,confirmButtonColor:'#3085d6',cancelButtonColor:'#d33',confirmButtonText:'Yes, delete it!'
        }).then((result)=>{
            if(result.isConfirmed){
                $.ajax({ type:'DELETE', url:"{{ route('regions.store') }}/"+id, success:function(){ table.draw(); Swal.fire({icon:'success',title:'Deleted!',text:'Region deleted.',timer:2000,showConfirmButton:false}); }, error:function(){ Swal.fire({icon:'error',title:'Error!',text:'Something went wrong!'}); } });
            }
        });
    });
});
</script>
</body>
</html>
