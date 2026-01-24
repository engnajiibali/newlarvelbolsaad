@extends('layouts.admin')

@section('title', 'Shaqsiyaadka List')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-dark">
                <i class="fa-solid fa-users-gear me-2 text-primary"></i>Shaqsiyaadka Maamulka
            </h5>
            <button class="btn btn-primary btn-sm px-3 shadow-sm" id="createNewShaqsiyaad">
                <i class="fa fa-plus-circle me-1"></i> Shaqsi Cusub
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover data-table w-100">
                    <thead class="table-light">
                        <tr>
                            <th width="50px">No</th>
                            <th>Magaca</th>
                            <th>Jagada</th>
                            <th>Sawirka</th>
                            <th>Kaarka</th>
                            <th>Talefan</th>
                            <th width="120px" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ajaxModel" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="shaqsiForm" name="shaqsiForm" enctype="multipart/form-data">
                    <input type="hidden" name="ShaqsiyaadkaId" id="ShaqsiyaadkaId">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Magaca Shaqsiga <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="magacaShaqsiga" name="magacaShaqsiga" placeholder="Gali magaca oo buuxa">
                            <span class="text-danger error-text magacaShaqsiga_error small"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Jagada</label>
                            <input type="text" class="form-control" id="Jagada" name="Jagada" placeholder="Tusaale: Maareeye">
                            <span class="text-danger error-text Jagada_error small"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Talefan Lambarka</label>
                            <input type="text" class="form-control" id="TalefanLambarka" name="TalefanLambarka" placeholder="061xxxxxxx">
                            <span class="text-danger error-text TalefanLambarka_error small"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Addresska</label>
                            <input type="text" class="form-control" id="Addresska" name="Addresska">
                            <span class="text-danger error-text Addresska_error small"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Sawirka Shaqsiga</label>
                            <input type="file" class="form-control" id="SawirkaShaqsiga" name="SawirkaShaqsiga" accept="image/*">
                            <div id="imagePreview" class="mt-2" style="display:none;">
                                <img src="" alt="Preview" class="img-thumbnail" style="height: 100px; width: 100px; object-fit: cover;">
                            </div>
                            <span class="text-danger error-text SawirkaShaqsiga_error small"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Kaarka (PDF ama Image)</label>
                            <input type="file" class="form-control" id="KaarkaShaqsiga" name="KaarkaShaqsiga">
                            <span class="text-danger error-text KaarkaShaqsiga_error small"></span>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Faahfaahin Dheeraad ah</label>
                            <textarea class="form-control" id="Description" name="Description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="text-end mt-3">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Jooji</button>
                        <button type="submit" class="btn btn-success px-4" id="saveBtn">
                            <i class="fa fa-save me-1"></i> Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
$(function () {
    // CSRF Setup
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    // Initialize DataTable
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "{{ route('shaqsiyaadka.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'magacaShaqsiga', name: 'magacaShaqsiga'},
            {data: 'Jagada', name: 'Jagada'},
            {data: 'SawirkaShaqsiga', name: 'SawirkaShaqsiga', orderable:false, searchable:false},
            {data: 'KaarkaShaqsiga', name: 'KaarkaShaqsiga', orderable:false, searchable:false},
            {data: 'TalefanLambarka', name: 'TalefanLambarka'},
            {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center'},
        ]
    });

    // Image Preview Logic
    $('#SawirkaShaqsiga').change(function(){
        let reader = new FileReader();
        reader.onload = (e) => { 
            $('#imagePreview img').attr('src', e.target.result); 
            $('#imagePreview').fadeIn(); 
        }
        reader.readAsDataURL(this.files[0]);
    });

    // Open Modal for New Entry
    $('#createNewShaqsiyaad').click(function () {
        $('#saveBtn').val("create-shaqsiyaad");
        $('#ShaqsiyaadkaId').val('');
        $('#shaqsiForm').trigger("reset");
        $('#imagePreview').hide();
        $('.error-text').text('');
        $('.form-control').removeClass('is-invalid');
        $('#modelHeading').html("Diiwaangeli Shaqsi Cusub");
        $('#ajaxModel').modal('show');
    });

    // Edit Operation
    $('body').on('click', '.editShaqsiyaad', function () {
        var id = $(this).data('id');
        $.get("{{ route('shaqsiyaadka.index') }}/"+id+"/edit", function (data) {
            $('#modelHeading').html("Wax ka bedelka: " + data.magacaShaqsiga);
            $('#ajaxModel').modal('show');
            $('#ShaqsiyaadkaId').val(data.ShaqsiyaadkaId);
            $('#magacaShaqsiga').val(data.magacaShaqsiga);
            $('#Jagada').val(data.Jagada);
            $('#TalefanLambarka').val(data.TalefanLambarka);
            $('#Addresska').val(data.Addresska);
            $('#Description').val(data.Description);
            $('.error-text').text('');
            $('.form-control').removeClass('is-invalid');
            $('#imagePreview').hide(); // Hide preview on edit until new file chosen
        });
    });

    // Submit Form (Create/Update) with Loading State
    $('#shaqsiForm').submit(function(e){
        e.preventDefault();
        
        let submitBtn = $('#saveBtn');
        let originalBtnHtml = submitBtn.html();
        
        // Clear previous errors
        $('.error-text').text('');
        $('.form-control').removeClass('is-invalid');

        // Disable and show loading
        submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin me-1"></i> Kaydinaya...');

        let formData = new FormData(this);
        
        $.ajax({
            type:'POST',
            url: "{{ route('shaqsiyaadka.store') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response){
                $('#shaqsiForm').trigger("reset");
                $('#ajaxModel').modal('hide');
                table.draw();
                Swal.fire({ 
                    icon: 'success', 
                    title: 'Waa lagu guulaystay!', 
                    text: response.message, 
                    timer: 2000, 
                    showConfirmButton: false 
                });
            },
            error: function(response){
                if(response.status === 422) { // Validation Error
                    $.each(response.responseJSON.errors, function(key, value){
                        $('#' + key).addClass('is-invalid');
                        $('.'+key+'_error').text(value[0]);
                    });
                } else {
                    Swal.fire('Error', 'Wax baa khaldamay, fadlan isku day markale.', 'error');
                }
            },
            complete: function() {
                submitBtn.prop('disabled', false).html(originalBtnHtml);
            }
        });
    });

    // Delete Operation
    $('body').on('click', '.deleteShaqsiyaad', function () {
        var id = $(this).data("id");
        Swal.fire({
            title: 'Ma hubtaa?',
            text: "Xogtan dib looma soo celin karo!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Hubaal, tirtir!',
            cancelButtonText: 'Iska daa'
        }).then((result) => {
            if(result.isConfirmed){
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('shaqsiyaadka.store') }}/"+id,
                    success: function () {
                        table.draw();
                        Swal.fire({ icon: 'success', title: 'Waa la tirtiray!', timer: 1500, showConfirmButton: false });
                    },
                    error: function() {
                        Swal.fire('Error', 'Ma suuragalin in la tirtiro.', 'error');
                    }
                });
            }
        });
    });
});
</script>
@endpush