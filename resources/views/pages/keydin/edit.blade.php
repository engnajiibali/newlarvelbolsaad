@extends('layouts.admin')

@section('title', 'Keydin List')

@section('content')
   <div class="card">
        <h2 class="card-header"><i class="fa fa-edit"></i> Update Xogta Qoriga</h2>
        <div class="card-body">
            <form id="keydinForm" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT')
                <div class="row g-3">

                    <!-- Xaalada 1 -->
                    <div class="col-md-6">
                        <label for="Xaalada1" class="form-label">Xaalada: *</label>
                        <select class="form-control" id="Xaalada1" name="Xaalada1" required>
                            <option value="">Dooro Xaalada</option>
                            <option value="0" {{ $keydin->keydin_Xalada == 0 ? 'selected' : '' }}>La keydiyay</option>
                            <option value="1" {{ $keydin->keydin_Xalada == 1 ? 'selected' : '' }}>La baxshay</option>
                        </select>
                        <span class="text-danger error-text Xaalada1_error"></span>
                    </div>

                    <!-- Xaalada 2 -->
                    <div class="col-md-6">
                        <label for="Xaalada2" class="form-label">Xaalada 2: *</label>
                        <select class="form-control" id="Xaalada2" name="Xaalada2" required>
                            <option value="">Dooro Xaalada</option>
                            <option value="1" {{ $keydin->Xalada == 1 ? 'selected' : '' }}>La baxshay</option>
                            <option value="2" {{ $keydin->Xalada == 2 ? 'selected' : '' }}>La keydiyay</option>
                            <option value="3" {{ $keydin->Xalada == 3 ? 'selected' : '' }}>Lumay</option>
                            <option value="5" {{ $keydin->Xalada == 5 ? 'selected' : '' }}>Baafin</option>
                            <option value="6" {{ $keydin->Xalada == 6 ? 'selected' : '' }}>La Qabtay</option>
                            <option value="4" {{ $keydin->Xalada == 4 ? 'selected' : '' }}>La Burburiyay</option>
                        </select>
                        <span class="text-danger error-text Xaalada2_error"></span>
                    </div>

                    <!-- Taariikhda -->
                    <div class="col-md-6">
                        <label for="date" class="form-label">Taariikhda: *</label>
                        <input type="date" class="form-control" id="date" name="date" value="{{ old('date',$keydin->keydin_CreateDate) }}" required>
                        <span class="text-danger error-text date_error"></span>
                    </div>

                    <!-- Fadhiga -->
                    <div class="col-md-6 d-flex align-items-end">
                        <div class="w-100">
                            <label for="FadhiId" class="form-label">Fadhiga: *</label>
                            <div class="input-group">
                                <select class="form-control" id="FadhiId" name="FadhiId" required>
                                    <option value="">Dooro Fadhiga</option>
                                    @foreach($Department as $dep)
                                        <option value="{{ $dep->id }}" {{ $keydin->FadhiId == $dep->id ? 'selected' : '' }}>{{ $dep->name }}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-primary" type="button" id="addFadhi">Kudar</button>
                            </div>
                            <span class="text-danger error-text FadhiId_error"></span>
                        </div>
                    </div>

                    <!-- Qaybta Hubka -->
                    <div class="col-md-6 d-flex align-items-end">
                        <div class="w-100">
                            <label for="QaybtaHubka" class="form-label">Qaybta Hubka: *</label>
                            <div class="input-group">
                                <select class="form-control" id="QaybtaHubka" name="QaybtaHubka" required>
                                    <option value="">Dooro Noca Hubka</option>
                                    @foreach($items as $item)
                                        <option value="{{ $item->ItemId }}" {{ $keydin->keydin_itemID == $item->ItemId ? 'selected' : '' }}>{{ $item->ItemName }}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-primary" type="button" id="addHub">Kudar</button>
                            </div>
                            <span class="text-danger error-text QaybtaHubka_error"></span>
                        </div>
                    </div>

                    <!-- Sawirada Hubka -->
                    <div class="col-md-12">
                        <label for="sawiradaHubka" class="form-label">Sawirada Hubka: *</label>
                        <input type="file" class="form-control" id="sawiradaHubka" name="sawiradaHubka[]" multiple>
                        <div id="preview-container" class="mt-2 d-flex flex-wrap gap-2">
                     @if($keydin->keydin_image1)
    @foreach(explode(',', $keydin->keydin_image1) as $img)
        @php
            $imageUrl = Storage::disk('s3')->url($img); // use $img here
        @endphp
        <div class="position-relative" data-image-name="{{ $img }}">
            <img src="{{ $imageUrl }}" class="img-thumbnail" style="max-height:100px;" />
            <button type="button" class="btn btn-sm btn-danger remove-image-old">&times;</button>
        </div>
    @endforeach
@endif

                        </div>
                        <span class="text-danger error-text sawiradaHubka_error"></span>
                        <small class="form-text text-muted">Maximum 12 files allowed. Click "X" to remove an image.</small>
                    </div>

                    <!-- Lambarka Taxanaha -->
                    <div class="col-md-6">
                        <label for="LambarkaTaxanaha" class="form-label">Lambarka Taxanaha: *</label>
                        <input type="text" class="form-control" id="LambarkaTaxanaha" name="LambarkaTaxanaha" value="{{ old('LambarkaTaxanaha',$keydin->keydin_lambarka1) }}" required>
                        <span class="text-danger error-text LambarkaTaxanaha_error"></span>
                    </div>

                    <!-- Calamada Dawlada -->
                    <div class="col-md-6">
                        <label for="Calamaden" class="form-label">Calamada Dawlada: *</label>
                        <input type="text" class="form-control" id="Calamaden" name="Calamaden" value="{{ old('Calamaden',$keydin->Calamaden) }}" required>
                        <span class="text-danger error-text Calamaden_error"></span>
                    </div>

                    <!-- Shaqeyn Kara -->
                    <div class="col-md-6">
                        <label for="ShaqeynKara" class="form-label">Shaqeyn Kara: *</label>
                        <select class="form-control" id="ShaqeynKara" name="ShaqeynKara" required>
                            <option value="1" {{ $keydin->ShaqeynKara == 1 ? 'selected' : '' }}>Wuu Shaqenaya</option>
                            <option value="2" {{ $keydin->ShaqeynKara == 2 ? 'selected' : '' }}>Ma shaqenayo</option>
                        </select>
                        <span class="text-danger error-text ShaqeynKara_error"></span>
                    </div>

                    <!-- Lahansho -->
                    <div class="col-md-6">
                        <label for="Lahansho" class="form-label">Lahansho: *</label>
                        <select class="form-control" id="Lahansho" name="Lahansho" required>
                            <option value="Dawlada" {{ $keydin->Lahansho == 'Dawlada' ? 'selected' : '' }}>Dawlada</option>
                            <option value="Shaqsi" {{ $keydin->Lahansho == 'Shaqsi' ? 'selected' : '' }}>Shaqsi</option>
                            <option value="Qabiil" {{ $keydin->Lahansho == 'Qabiil' ? 'selected' : '' }}>Qabiil</option>
                        </select>
                        <span class="text-danger error-text Lahansho_error"></span>
                    </div>

                    <!-- Faahfaahinta Hubka -->
                    <div class="col-12">
                        <label for="faahfaahintaHubka" class="form-label">Faahfaahinta Hubka: *</label>
                        <textarea class="form-control" id="faahfaahintaHubka" name="faahfaahintaHubka" rows="5" required>{{ old('faahfaahintaHubka',$keydin->Describ) }}</textarea>
                        <span class="text-danger error-text faahfaahintaHubka_error"></span>
                    </div>

                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success" id="saveBtn"><i class="fa fa-save"></i> Update</button>
                    <a href="{{ route('keydin.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Back</a>
                </div>

            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
$(document).ready(function(){
    let selectedFiles = [];
    let serialValid = true;

    // Remove old images
    $(document).on('click','.remove-image-old',function(){
        const wrapper = $(this).closest('.position-relative');
        const imageName = wrapper.data('image-name');
        if(imageName){
            $.post("{{ route('keydin.removeImage') }}", {_token: $('meta[name="csrf-token"]').attr('content'), image_name: imageName}, function(){
                wrapper.remove();
            });
        }
    });

    // Preview new images
    $('#sawiradaHubka').on('change', function(){
        const files = Array.from(this.files);
        if((selectedFiles.length + files.length) > 12){
            Swal.fire({ icon:'error', title:'Oops!', text:'You can only upload up to 12 images.' });
            return;
        }
        files.forEach(file => {
            if(file.type.startsWith('image/')){
                selectedFiles.push(file);
                let reader = new FileReader();
                reader.onload = function(e){
                    let imgWrapper = $(`
                        <div class="position-relative">
                            <img src="${e.target.result}" />
                            <button type="button" class="btn btn-sm btn-danger remove-image">&times;</button>
                        </div>
                    `);
                    imgWrapper.find('.remove-image').on('click', function(){
                        const index = $('#preview-container .position-relative').index(imgWrapper);
                        selectedFiles.splice(index,1);
                        imgWrapper.remove();
                    });
                    $('#preview-container').append(imgWrapper);
                }
                reader.readAsDataURL(file);
            }
        });
        $(this).val('');
    });

    // Field validation
    function validateField(field){
        let value = $(field).val();
        let id = $(field).attr('id');
        let isValid = true;
        if($(field).attr('type')==='file' && selectedFiles.length===0 && $('#preview-container .position-relative').length===0){
            $('.'+id+'_error').text('Please select at least one image');
            $(field).addClass('is-invalid').removeClass('is-valid');
            isValid=false;
        } else if($(field).prop('required') && (!value || value==='')){
            $('.'+id+'_error').text('This field is required');
            $(field).addClass('is-invalid').removeClass('is-valid');
            isValid=false;
        } else {
            $('.'+id+'_error').text('');
            $(field).addClass('is-valid').removeClass('is-invalid');
        }
        return isValid;
    }
    $('#keydinForm input,#keydinForm select,#keydinForm textarea').on('input change', function(){ validateField(this); });

    // Serial validation
    $('#LambarkaTaxanaha').on('blur', function(){
        let serial = $(this).val();
        let hubId = $('#QaybtaHubka').val();
        let recordId = {{ $keydin->keydin_ID }};
        if(!serial){
            $('.LambarkaTaxanaha_error').text('This field is required');
            $(this).addClass('is-invalid').removeClass('is-valid');
            serialValid=false;
            return;
        }
        if(hubId){
            $.ajax({
                url:"{{ route('keydin.checkSerial') }}",
                method:"POST",
                data:{
                    _token:$('meta[name="csrf-token"]').attr('content'),
                    LambarkaTaxanaha: serial,
                    QaybtaHubka: hubId,
                    ignore_id: recordId
                },
                success:function(res){
                    if(res.exists){
                        $('.LambarkaTaxanaha_error').text('Serial-kan iyo hubkan hore ayaa loo diiwaangeliyay!');
                        $('#LambarkaTaxanaha').addClass('is-invalid').removeClass('is-valid');
                        serialValid=false;
                    }else{
                        $('.LambarkaTaxanaha_error').text('');
                        $('#LambarkaTaxanaha').addClass('is-valid').removeClass('is-invalid');
                        serialValid=true;
                    }
                },
                error:function(){ serialValid=false; }
            });
        }
    });

    // Submit update
    $('#keydinForm').submit(function(e){
        e.preventDefault();
        let isFormValid=true;
        $('#keydinForm input,#keydinForm select,#keydinForm textarea').each(function(){ if(!validateField(this)) isFormValid=false; });
        if(!serialValid){ $('#LambarkaTaxanaha').addClass('is-invalid'); $('.LambarkaTaxanaha_error').text('Please enter valid serial'); isFormValid=false; }
        if(!isFormValid){ Swal.fire({icon:'error',title:'Oops!',text:'Please fix errors!'}); return; }

        const saveBtn=$('#saveBtn'); const originalBtnHtml=saveBtn.html();
        saveBtn.html('<i class="fa fa-spinner fa-spin"></i> Updating...').prop('disabled',true);
        let formData=new FormData(this);
        selectedFiles.forEach(file=>formData.append('sawiradaHubka[]',file));

        $.ajax({
            type:'POST',
            url:"{{ route('keydin.update',$keydin->keydin_ID ) }}",
            data:formData,
            contentType:false,
            processData:false,
            success:function(res){
                saveBtn.html(originalBtnHtml).prop('disabled',false);
                Swal.fire({icon:'success',title:'Updated!',text:res.message||'Record updated',timer:2000,showConfirmButton:false})
                    .then(()=>{ window.location.href="{{ route('keydin.index') }}"; });
            },
            error:function(err){
                saveBtn.html(originalBtnHtml).prop('disabled',false);
                $('.error-text').text('');
                $('#keydinForm input,#keydinForm select,#keydinForm textarea').removeClass('is-valid is-invalid');
                if(err.responseJSON && err.responseJSON.errors){
                    $.each(err.responseJSON.errors,function(key,val){ $('.'+key+'_error').text(val[0]); $('#'+key).addClass('is-invalid'); });
                }
                Swal.fire({icon:'error',title:'Oops!',text:'Please fix errors!'});
            }
        });
    });

});
</script>
@endpush
