@extends('layouts.admin')

@section('title', 'Keydin Details')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
    .hover-overlay { transition: opacity 0.3s ease-in-out; opacity: 0; }
    .card:hover .hover-overlay { opacity: 1 !important; }
    .transition { transition: opacity 0.3s ease; }
    /* Select2 fix for Bootstrap Modals */
    .select2-container { z-index: 2050 !important; }
    .form-control-plaintext { padding-left: 10px; }
</style>
@endpush

@section('content')
<div class="py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">
            <i class="fa fa-info-circle text-primary"></i> Faahfaahinta Keydinta Hubka
        </h3>
        <a href="{{ route('keydin.list') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-primary text-white fw-bold">
            <i class="fa fa-warehouse me-2"></i> Macluumaadka Keydinta
        </div>
        <div class="card-body row g-3">
            <div class="col-md-4">
                <label class="fw-semibold text-muted">Nooca Qoriga:</label>
                <div class="form-control-plaintext border rounded bg-light">{{ $keydin->QaybtaHubkaRelation->ItemName ?? '-' }}</div>
            </div>
            <div class="col-md-4">
                <label class="fw-semibold text-muted">Qori Number:</label>
                <div class="form-control-plaintext border rounded bg-light">{{ $keydin->keydin_lambarka1 }}</div>
            </div>
            <div class="col-md-4">
                <label class="fw-semibold text-muted">Calamda Dawlada :</label>
                <div class="form-control-plaintext border rounded bg-light">{{ $keydin->Calamaden }}</div>
            </div>
            <div class="col-md-4">
                <label class="fw-semibold text-muted">Tarikhda Ladiwangaliyay:</label>
                <div class="form-control-plaintext border rounded bg-light">{{ $keydin->keydin_CreateDate }}</div>
            </div>
            <div class="col-md-4">
                <label class="fw-semibold text-muted">Lahansho:</label>
                <div class="form-control-plaintext border rounded bg-light">
                    <span class="badge bg-secondary">{{ $keydin->Lahansho }}</span>
                </div>
            </div>
   <div class="col-md-4">
                <label class="fw-semibold text-muted">Fadhiga:</label>
                <div class="form-control-plaintext border rounded bg-light">
                    <span class="badge bg-secondary">{{ $keydin->FadhiIdRelation->name ?? 'N/A' }}</span>
                </div>
            </div>
            
            <div class="col-md-4">
                <label class="fw-semibold text-muted">Xaalada Guud :</label>
                <div class="form-control-plaintext border rounded bg-light">
                    @if($keydin->keydin_Xalada == 0) <span class="text-success fw-bold">Kaydsan (Store)</span>
                    @elseif($keydin->keydin_Xalada == 1) <span class="text-primary fw-bold">Baxay (Askari)</span>
                    @elseif($keydin->keydin_Xalada == 2) <span class="text-info fw-bold">Shaqsiyaadka</span>
                    @else Unknown @endif
                </div>
            </div>
              <div class="col-md-4">
                <label class="fw-semibold text-muted">Xaalada Gaar Ah :</label>
                <div class="form-control-plaintext border rounded bg-light">
                    @if($keydin->Xalada == 1) <span class="text-primary fw-bold">La baxshay</span>
                    @elseif($keydin->Xalada == 2) <span class="text-info fw-bold">La keydiyay</span>
                    @elseif($keydin->Xalada == 3) <span class="text-info fw-bold">Lumay</span>
                    @elseif($keydin->Xalada == 4) <span class="text-info fw-bold">La Burburiyay<</span>
                    @elseif($keydin->Xalada == 5) <span class="text-info fw-bold">Baafin</span>
                     @elseif($keydin->Xalada == 6) <span class="text-info fw-bold">La Qabtay</span>
                    @else Unknown @endif
                </div>
            </div>
              <div class="col-md-12">
                <label class="fw-semibold text-muted">Fahfahin Guud :</label>
                <div class="form-control-plaintext border rounded bg-light">
                 {{ $keydin->Describ ?? 'N/A' }}
                </div>
            </div>
        </div>
    </div>

    @if($lastRecord)
        @if($keydin->keydin_Xalada == 0)
            {{-- HUBKA WUXUU YAALA STORE - Halkan waxaa ka muuqanaya badhamada lagu bixinayo --}}
            <div class="card shadow-sm border-0 mb-4 border-start border-success border-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <span class="fw-bold text-success"><i class="fa fa-box me-2"></i> Hubka hadda wuxuu yaala Bakhaarka</span>
                    <div class="btn-group">
                        <button type="button" class="btn btn-warning btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#modalShaqsi">
                            <i class="fa fa-user-plus"></i> Sii Hub Shaqsi
                        </button>
                        <button type="button" class="btn btn-primary btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#modalAskari">
                            <i class="fa fa-id-badge"></i> Sii Hub Askari
                        </button>
                    </div>
                </div>
                <div class="card-body row g-3">
                    <div class="col-md-4">
                        <label class="fw-semibold text-muted">Bakhaarka (Store)</label>
                        <div class="form-control-plaintext border rounded bg-light">{{ $lastRecord->store->StoreName ?? 'N/A' }}</div>
                    </div>
                    <div class="col-md-4">
                        <label class="fw-semibold text-muted">Fadhiga</label>
                        <div class="form-control-plaintext border rounded bg-light">{{ $keydin->FadhiIdRelation->name ?? 'N/A' }}</div>
                    </div>
                    <div class="col-md-4">
                        <label class="fw-semibold text-muted">Taariikhda la geliyay</label>
                        <div class="form-control-plaintext border rounded bg-light">{{ $lastRecord->CreateDate }}</div>
                    </div>
                </div>
            </div>
    
        {{-- ASKARI / SHAQSI --}}
        @else
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light fw-bold">
                    <i class="fa fa-exchange-alt me-2"></i> Macluumaadka Wareejinta Hadda
                </div>

                <div class="card-body row g-3">

                    {{-- ASKARI --}}
                    @if($keydin->keydin_Xalada == 1)
                    <div class="col-md-12 mt-3">
    <div class="d-flex gap-2">

        <button class="btn btn-outline-success fw-bold"
                data-bs-toggle="modal"
                data-bs-target="#modalReturnStore">
            <i class="fa fa-undo"></i> Ku celi Store
        </button>

        <button class="btn btn-outline-primary fw-bold"
                data-bs-toggle="modal"
                data-bs-target="#modalReAssignAskari">
            <i class="fa fa-exchange-alt"></i> Sii Askari Kale
        </button>

    </div>
</div>

                        <div class="col-md-6">
                            <label class="fw-semibold text-muted">Magaca Askari:</label>
                            <div class="form-control-plaintext border rounded bg-white fw-bold text-primary">
                                {{ optional($lastRecord->askari)->MagacaQofka ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-semibold text-muted">Lambarka Ciidanka:</label>
                            <div class="form-control-plaintext border rounded bg-white">
                                {{ optional($lastRecord->askari)->LamabrkaCiidanka ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-semibold text-muted">Darajada:</label>
                            <div class="form-control-plaintext border rounded bg-white">
                                {{ optional($lastRecord->askari)->Darajada ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-semibold text-muted">Taleefoon:</label>
                            <div class="form-control-plaintext border rounded bg-white">
                                {{ optional($lastRecord->askari)->TalefanLambar ?? 'N/A' }}
                            </div>
                        </div>
                    @endif

                    {{-- SHAQSI --}}
                    @if($keydin->keydin_Xalada == 2)
                        <div class="col-md-6">
                            <label class="fw-semibold text-muted">Magaca Shaqsiga:</label>
                            <div class="form-control-plaintext border rounded bg-white fw-bold text-success">
                                {{ optional($lastRecord->shaqsi)->magacaShaqsiga ?? 'N/A' }}
                            </div>
                        </div>
                    @endif

                    <div class="col-md-6">
                        <label class="fw-semibold text-muted">Taariikhda la siiyay:</label>
                        <div class="form-control-plaintext border rounded bg-white">
                            {{ $lastRecord->CreateDate }}
                        </div>
                    </div>

                </div>
            </div>
        @endif
    @endif

<div class="card shadow-sm border-0">
    <div class="card-header bg-dark text-white fw-bold">
        <i class="fa fa-image me-2"></i> Sawirada Hubka
    </div>
    <div class="card-body">
        @if($keydin->keydin_image1)
            <div class="d-flex flex-wrap gap-2">
                @foreach(explode(',', $keydin->keydin_image1) as $img)
                    @php 
                        // Ka saar wixii boos ah (trim) haddii ay jiraan
                        $cleanImg = trim($img);
                        // Generate S3 URL
                        $imageUrl = Storage::disk('s3')->url($cleanImg); 
                    @endphp
                    
                    <div class="position-relative hover-container" style="width:150px; height:150px;">
                        <img src="{{ $imageUrl }}" 
                             class="img-fluid rounded border shadow-sm" 
                             style="width:100%; height:100%; object-fit:cover;"
                             onerror="this.onerror=null;this.src='{{ asset('assets/img/no-image.png') }}';">

                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex align-items-center justify-content-center opacity-0 hover-overlay transition rounded">
                            <a href="{{ $imageUrl }}" target="_blank" class="btn btn-light btn-sm fw-bold">
                                <i class="fa fa-search-plus"></i> View
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-3">
                <i class="fa fa-file-image fa-3x text-light"></i>
                <p class="text-muted mt-2"><i>No images uploaded for this record.</i></p>
            </div>
        @endif
    </div>
</div>
</div>

{{-- ==========================================
     MODALS SECTION
     ========================================== --}}

<div class="modal fade" id="modalShaqsi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <form id="formShaqsi" action="{{ route('hubka.sii.shaqsi') }}" method="POST">
            @csrf
            <input type="hidden" name="keydin_id" value="{{ $keydin->keydin_ID }}">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title fw-bold"><i class="fa fa-user-plus me-2"></i> Sii Hub Shaqsi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-4 text-center">
                        <span class="badge bg-light text-dark p-2 border">Qori: {{ $keydin->keydin_lambarka1 }}</span>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark">Dooro Shaqsiga *</label>
                            <select id="selectShaqsi" name="ShaqsiId" class="form-control" required style="width: 100%"></select>
                            <span class="text-danger error-text ShaqsiId_error"></span>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark">Fadhiga *</label>
                            <div class="d-flex gap-2">
                                <select class="form-control select2-fadhi" name="FadhiId" id="FadhiId" required style="flex:1">
                                    <option value="">Dooro Fadhiga</option>
                                    @foreach($Department as $dep)
                                        <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                                    @endforeach
                                </select>
                              
                            </div>
                            <span class="text-danger error-text FadhiId_error"></span>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold text-dark">Taariikhda Maanta *</label>
                            <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Xir</button>
                    <button type="submit" class="btn btn-warning fw-bold submit-btn">Confirm Assignment</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modalAskari" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="formAskari" action="{{ route('hubka.sii.askari') }}" method="POST">
            @csrf
            <input type="hidden" name="keydin_id" value="{{ $keydin->keydin_ID }}">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold">Sii Hub Askari</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 text-center">
                        <span class="badge bg-light text-dark p-2 border">Qori: {{ $keydin->keydin_lambarka1 }}</span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Dooro Askariga *</label>
                        <select id="selectAskari" name="AskariId" class="form-control" required style="width: 100%"></select>
                    </div>
                      <div class="mb-3">
                      
 <label class="form-label fw-bold text-dark">Fadhiga *</label>
                            <div class="d-flex gap-2">
                                <select class="form-control select2-fadhi" name="FadhiId1" id="FadhiId1" required style="flex:1">
                                    <option value="">Dooro Fadhiga</option>
                                    @foreach($Department as $dep)
                                        <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                                    @endforeach
                                </select>
                              
                            </div>
                            <span class="text-danger error-text FadhiId_error"></span>

                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Taariikhda Maanta *</label>
                        <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Xir</button>
                    <button type="submit" class="btn btn-primary fw-bold submit-btn">Confirm Assignment</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- RETURN HUB TO STORE MODAL -->
<div class="modal fade" id="modalReturnStore" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="formReturnStore" action="{{ route('hubka.return.store') }}" method="POST">
            @csrf
            <input type="hidden" name="keydin_id" value="{{ $keydin->keydin_ID }}">

            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="fw-bold">Ku celi Store</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                      <div class="mb-3">
                    <label class="form-label fw-bold">Xaalada 2 *</label>
                    <select class="form-control select2" name="Xaalada2" required>
                        <option value="">Dooro Xaalada</option>
                        <option value="2">La keydiyay</option>
                        <option value="4">La Burburiyay</option>
                    </select>
                </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Dooro Waaxda (Department) *</label>
                        <select name="department_id" id="returnDepartment" class="form-control select2" required>
                            <option value="">Dooro Waaxda</option>
                            @foreach($Department as $dep)
                                <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Dooro Bakhaarka (Store) *</label>
                        <select name="store_id" id="returnStore" class="form-control select2" required>
                            <option value="">Dooro Store</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Qori Number</label>
                        <input type="text" name="QoriNum" class="form-control" placeholder="Qori Number" value="{{ $keydin->keydin_lambarka1 }}" readonly>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Maya</button>
                    <button type="submit" class="btn btn-success fw-bold">Haa, Ku celi Store</button>
                </div>
            </div>
        </form>
    </div>
</div>



<div class="modal fade" id="modalReAssignAskari" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form id="formReAssignAskari" action="{{ route('hubka.reassign.askari') }}" method="POST">
            @csrf
            <input type="hidden" name="keydin_id" value="{{ $keydin->keydin_ID }}">

            <div class="modal-content shadow">

                <!-- Modal Header -->
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-person-plus-fill me-2"></i>
                        Sii Askari Kale
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
      <div class="mb-3">
                    <label class="form-label fw-bold">Xaalada 2 *</label>
                    <select class="form-control select2" name="Xaalada2" required>
                        <option value="">Dooro Xaalada</option>
                          <option value="1">La baxshay</option>
                       <option value="3">Lumay</option>
                        <option value="5">Baafin</option>
                        <option value="6">La Qabtay</option>
                    </select>
                </div>
                    <!-- Askari -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Dooro Askari
                        </label>
                        <select id="selectAskariReassign"
                                name="AskariId"
                                class="form-select"
                                required>
                        </select>
                    </div>

                    <!-- Fadhi -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Dooro Fadhi
                        </label>
                        <select name="FadhiId" class="form-select select2" id="fadh" required  style="flex:1">
                            <option value="">-- Dooro Fadhi --</option>
                            @foreach($Department as $dep)
                                <option value="{{ $dep->id }}">
                                    {{ $dep->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date -->
                    <div class="mb-2">
                        <label class="form-label fw-semibold">
                            Taariikh
                        </label>
                        <input type="date"
                               name="date"
                               class="form-control"
                               value="{{ date('Y-m-d') }}">
                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>
                        Xir
                    </button>

                    <button type="submit"
                            class="btn btn-primary fw-bold px-4">
                        <i class="bi bi-check-circle me-1"></i>
                        Confirm
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>


@endsection

@push('scripts')

@if(session('success'))

<script>

Swal.fire({

icon:'success',

title:'Success',

text:'{{ session("success") }}',

timer:2000,

showConfirmButton:false

})

</script>

@endif
<script>
$(document).ready(function() {
    
   $('#FadhiId').select2({
    dropdownParent: $('#modalShaqsi'),
    placeholder: 'Dooro Fadhiga',
    allowClear: true,
    width: 'resolve'
});

$('#FadhiId1').select2({
    dropdownParent: $('#modalAskari'),
    placeholder: 'Dooro Fadhiga',
    allowClear: true,
    width: 'resolve'
});

$('#fadh').select2({
    dropdownParent: $('#modalReAssignAskari'),
    placeholder: 'Dooro Fadhiga',
    allowClear: true,
    width: 'resolve'
});



$('#formReAssignAskari').on('submit',function(e){

e.preventDefault();

let form = this;

Swal.fire({

title:'Ma hubtaa?',
text:'Hubka waxaa loo wareejin doonaa askarigan',
icon:'warning',

showCancelButton:true,

confirmButtonText:'Haa Confirm',

cancelButtonText:'Cancel',

confirmButtonColor:'#3085d6',

cancelButtonColor:'#d33'

}).then((result)=>{

if(result.isConfirmed){

form.submit();

}

});

});

    $('#modalShaqsi').on('hidden.bs.modal', function () {
        $('#FadhiId').val(null).trigger('change');
    });
     $('#modalAskari').on('hidden.bs.modal', function () {
        $('#FadhiId1').val(null).trigger('change');
    });
    // 1. AJAX Form Submission with Professional Loading & SweetAlert
    const initFormAjax = (formId, modalId) => {
        $(formId).on('submit', function(e) {
            e.preventDefault();
            let form = $(this);
            let btn = form.find('.submit-btn');
            
            Swal.fire({
                title: 'Fadlan sug...',
                text: 'Xogta waa la habaynayaa',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });

            btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Loading...');

            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                success: function(res) {
                    $(modalId).modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Guul!',
                        text: res.message || 'Hubka si guul leh ayaa loo wareejiyay.',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => { location.reload(); });
                },
                error: function(xhr) {
                    btn.prop('disabled', false).html('Confirm Assignment');
                    let msg = xhr.responseJSON?.message || 'Wax baa khaldamay!';
                    Swal.fire({ icon: 'error', title: 'Khalad!', text: msg });
                }
            });
        });
    };

    initFormAjax('#formShaqsi', '#modalShaqsi');
    initFormAjax('#formAskari', '#modalAskari');

    $('#selectAskariReassign').select2({
    dropdownParent: $('#modalReAssignAskari'),
    placeholder: 'Qor magac, darajo ama lambarka askariga...',
    ajax: {
        url: "{{ route('askari.search') }}",
        type: "POST",
        dataType: "json",
        delay: 300,
        data: p => ({
            _token: "{{ csrf_token() }}",
            search: p.term
        }),
        processResults: res => ({
            results: res.data.map(i => ({
                id: i.AskariId,
                text: `${i.MagacaQofka} - ${i.Darajada} (${i.LamabrkaCiidanka})`
            }))
        })
    }
});


    // 2. Select2 Raadinta Shaqsi
    $('#selectShaqsi').select2({
        dropdownParent: $('#modalShaqsi'),
        placeholder: 'Qor magaca shaqsiga si aad u baarto...',
        ajax: {
            url: "{{ route('shaqsi.search') }}",
            type: "POST",
            dataType: 'json',
            delay: 300,
            data: p => ({ _token: "{{ csrf_token() }}", search: p.term }),
            processResults: res => ({ results: res.data.map(i => ({ id: i.ShaqsiyaadkaId, text: i.magacaShaqsiga })) })
        }
    });

    // Load stores when department is selected
$('#returnDepartment').on('change', function () {

    let departmentId = $(this).val();
    let storeSelect = $('#returnStore');

    storeSelect.html('<option value="">Loading...</option>');

    if (!departmentId) {
        storeSelect.html('<option value="">Dooro Department marka hore</option>');
        return;
    }

    $.ajax({
        url: "{{ route('stores.by.department') }}",
        type: "POST",
        dataType: "json",
        data: {
            _token: "{{ csrf_token() }}",
            department_id: departmentId
        },
        success: function (res) {
            let options = '<option value="">Dooro Store</option>';

            res.data.forEach(store => {
                options += `<option value="${store.StoradaId}">
                                ${store.StoreName}
                            </option>`;
            });

            storeSelect.html(options);
        },
        error: function () {
            storeSelect.html('<option value="">Khalad ayaa dhacay</option>');
        }
    });
});


    // 3. Select2 Raadinta Askari
$('#selectAskari').select2({
    dropdownParent: $('#modalAskari'),
    placeholder: 'Qor magac, darajo ama lambarka askariga...',
    allowClear: true,

    ajax: {
        url: "{{ route('askari.search') }}",
        type: "POST",
        dataType: 'json',
        delay: 300,
        data: params => ({
            _token: "{{ csrf_token() }}",
            search: params.term
        }),
        processResults: res => ({
            results: res.data.map(i => ({
                id: i.AskariId,
                text: i.MagacaQofka, // required
                MagacaQofka: i.MagacaQofka,
                Darajada: i.Darajada,
                LamabrkaCiidanka: i.LamabrkaCiidanka,
                TalefanLambar: i.TalefanLambar
            }))
        })
    },

    // ðŸ”¥ Dropdown display
    templateResult: function (data) {
        if (!data.id) return data.text;

        return $(`
            <div>
                <strong>${data.MagacaQofka}</strong><br>
                <small>
                    ${data.Darajada} |
                    ${data.LamabrkaCiidanka} |
                    ðŸ“ž ${data.TalefanLambar ?? '-'}
                </small>
            </div>
        `);
    },

    // ðŸ”¥ Selected value display
    templateSelection: function (data) {
        if (!data.id) return data.text;

        return `${data.MagacaQofka} - ${data.Darajada} (${data.LamabrkaCiidanka})`;
    }
});

});
</script>
@endpush