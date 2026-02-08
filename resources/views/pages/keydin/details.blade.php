@extends('layouts.admin')

@section('title', 'Keydin Details')

@section('content')
<div class="py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">
            <i class="fa fa-info-circle text-primary"></i> Faahfaahinta Keydinta Hubka
        </h3>
        <a href="{{ route('keydin.list') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>

    {{-- KEYDIN INFO --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-primary text-white fw-bold">
            <i class="fa fa-warehouse me-2"></i> Macluumaadka Keydinta
        </div>
        <div class="card-body row g-3">

            <div class="col-md-4">
                <label class="fw-semibold text-muted">Nooca Qoriga:</label>
                <div class="form-control-plaintext border rounded bg-light">
                    {{ optional($keydin->QaybtaHubkaRelation)->ItemName ?? '-' }}
                </div>
            </div>

            <div class="col-md-4">
                <label class="fw-semibold text-muted">Qori Number:</label>
                <div class="form-control-plaintext border rounded bg-light">
                    {{ $keydin->keydin_lambarka1 }}
                </div>
            </div>

            <div class="col-md-4">
                <label class="fw-semibold text-muted">Calamada Dawlada:</label>
                <div class="form-control-plaintext border rounded bg-light">
                    {{ $keydin->Calamaden }}
                </div>
            </div>

            <div class="col-md-4">
                <label class="fw-semibold text-muted">Taariikhda La Diiwaangeliyay:</label>
                <div class="form-control-plaintext border rounded bg-light">
                    {{ $keydin->keydin_CreateDate }}
                </div>
            </div>

            <div class="col-md-4">
                <label class="fw-semibold text-muted">Lahansho:</label>
                <div class="form-control-plaintext border rounded bg-light">
                    <span class="badge bg-secondary">{{ $keydin->Lahansho }}</span>
                </div>
            </div>

            <div class="col-md-4">
                <label class="fw-semibold text-muted">Xaalada Guud:</label>
                <div class="form-control-plaintext border rounded bg-light">
                    @if($keydin->keydin_Xalada == 0)
                        <span class="text-success fw-bold">Kaydsan (Store)</span>
                    @elseif($keydin->keydin_Xalada == 1)
                        <span class="text-primary fw-bold">Baxay (Askari)</span>
                    @elseif($keydin->keydin_Xalada == 2)
                        <span class="text-info fw-bold">Shaqsiyaadka</span>
                    @endif
                </div>
            </div>

        </div>
    </div>

    {{-- CURRENT STATUS --}}
    @if($lastRecord)

        {{-- STORE --}}
        @if($keydin->keydin_Xalada == 0)
            <div class="card shadow-sm border-0 mb-4 border-start border-success border-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <span class="fw-bold text-success">
                        <i class="fa fa-box me-2"></i> Hubka hadda wuxuu yaalaa Bakhaarka
                    </span>
                    <div class="btn-group">
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalShaqsi">
                            <i class="fa fa-user-plus"></i> Sii Shaqsi
                        </button>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalAskari">
                            <i class="fa fa-id-badge"></i> Sii Askari
                        </button>
                    </div>
                </div>

                <div class="card-body row g-3">
                    <div class="col-md-4">
                        <label class="fw-semibold text-muted">Bakhaarka:</label>
                        <div class="form-control-plaintext border rounded bg-light">
                            {{ optional($lastRecord->store)->StoreName ?? 'N/A' }}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-semibold text-muted">Fadhiga:</label>
                        <div class="form-control-plaintext border rounded bg-light">
                            {{ optional($keydin->FadhiIdRelation)->name ?? 'N/A' }}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-semibold text-muted">Taariikhda:</label>
                        <div class="form-control-plaintext border rounded bg-light">
                            {{ $lastRecord->CreateDate }}
                        </div>
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

    {{-- IMAGES --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white fw-bold">
            <i class="fa fa-image me-2"></i> Sawirada Hubka
        </div>
        <div class="card-body">

       @if($keydin->keydin_image1)
    @php
        $images = json_decode($keydin->keydin_image1, true);
    @endphp

    @if(is_array($images) && count($images))
        <div class="d-flex flex-wrap gap-2">
            @foreach($images as $img)
                @php
                    $imageUrl = Storage::disk('s3')->url(trim($img));
                @endphp

                <div style="width:150px;height:150px">
                    <img src="{{ $imageUrl }}"
                         class="img-fluid rounded border shadow-sm"
                         style="width:100%;height:100%;object-fit:cover"
                         onerror="this.onerror=null;this.src='{{ asset('assets/img/no-image.png') }}'">
                </div>
            @endforeach
        </div>
    @else
        <p class="text-muted fst-italic">No valid images found.</p>
    @endif
@else
    <p class="text-muted fst-italic">No images uploaded.</p>
@endif


        </div>
    </div>

</div>
@endsection


@push('scripts')


<script>
$(document).ready(function() {
    
    $('.select2-fadhi').select2({
        dropdownParent: $('#modalShaqsi'), // Muhiim: Si uu Modal-ka dushiisa ugu furmo
        placeholder: 'Dooro Fadhiga',
        allowClear: true,
        width: 'resolve'
    });

    $('#modalShaqsi').on('hidden.bs.modal', function () {
        $('#FadhiId').val(null).trigger('change');
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

    // 3. Select2 Raadinta Askari
    $('#selectAskari').select2({
        dropdownParent: $('#modalAskari'),
        placeholder: 'Qor magaca askariga si aad u baarto...',
        ajax: {
            url: "{{ route('askari.search') }}",
            type: "POST",
            dataType: 'json',
            delay: 300,
            data: p => ({ _token: "{{ csrf_token() }}", search: p.term }),
            processResults: res => ({ results: res.data.map(i => ({ id: i.AskariId, text: i.MagacaQofka })) })
        }
    });
});
</script>
@endpush