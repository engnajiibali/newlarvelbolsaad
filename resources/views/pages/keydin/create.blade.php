@extends('layouts.admin')

@section('title', 'Keydin List')

@section('content')
<div class="card shadow-sm border-0">
    <h2 class="card-header bg-white py-3">
        <i class="fa fa-plus me-2"></i> Xogta Qoriga
    </h2>

    <div class="card-body">
        <form id="keydinForm" enctype="multipart/form-data" novalidate>
            @csrf

            <div class="row g-4">

                {{-- ================= Xaalada 1 ================= --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">Xaalada *</label>
                    <select class="form-control select2" id="Xaalada1" name="Xaalada1" required>
                        <option value="">Dooro Xaalada</option>
                        <option value="0">La keydiyay</option>
                        <option value="1">La baxshay</option>
                        <option value="2">Shaqsi</option>
                    </select>
                </div>

                {{-- ================= Xaalada 2 ================= --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">Xaalada 2 *</label>
                    <select class="form-control select2" name="Xaalada2">
                        <option value="">Dooro Xaalada</option>
                        <option value="1">La baxshay</option>
                        <option value="2">La keydiyay</option>
                        <option value="3">Lumay</option>
                        <option value="5">Baafin</option>
                        <option value="6">La Qabtay</option>
                        <option value="4">La Burburiyay</option>
                    </select>
                </div>

                {{-- ================= Taariikhda ================= --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">Taariikhda *</label>
                    <input type="date" class="form-control" name="date"
                           value="{{ date('Y-m-d') }}" required>
                </div>

                {{-- ================= Fadhi ================= --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">Fadhiga *</label>
                    <select class="form-control select2" id="FadhiId" name="FadhiId" required>
                        <option value="">Dooro Fadhiga</option>
                        @foreach($Department as $dep)
                            <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- ================= Store ================= --}}
                <div class="col-md-6 d-none" id="store_wrapper">
                    <label class="form-label fw-bold">Bakhaarka *</label>
                    <select class="form-control select2" id="store_id" name="store_id">
                        <option value="">Marka hore dooro Fadhiga</option>
                    </select>
                </div>

                {{-- ================= Dynamic Xaalada2 ================= --}}
                <div class="col-md-12 d-none" id="Xaalada2_container">
                    <div class="row">
                       <div class="col-md-6 d-none" id="wrapper_B">
    <label class="form-label fw-bold">Raadi askari  *</label>

    <select class="form-control select2-askari" name="AskariId" style="width:100%">
        <option value="">Dooro Askari...</option>
    </select>
</div>

                        <div class="col-md-6 d-none" id="wrapper_C">
                            <label class="form-label fw-bold">Xaalad Labaad *</label>
                            <select class="form-control" name="Xaalada2C">
                                <option value="">Dooro...</option>
                                <option value="3">Lumay</option>
                                <option value="5">Baafin</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- ================= Shaqsi ================= --}}
                <div class="col-md-6 d-none" id="Shaqsi_wrapper">
                    <label class="form-label fw-bold">Shaqsi *</label>
                    <select id="ShaqsiSearch" name="ShaqsiId" class="form-control"></select>
                </div>

                <div class="col-md-6 d-none" id="ShaqsiDoc_wrapper">
                    <label class="form-label fw-bold">Warqadda Lahanshaha *</label>
                    <input type="file" class="form-control" name="ShaqsiDoc"
                           accept=".pdf,.jpg,.jpeg,.png">
                </div>

                {{-- ================= Hub ================= --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">Qaybta Hubka *</label>
                    <select class="form-control select2" id="QaybtaHubka" name="QaybtaHubka" required>
                        <option value="">Dooro Noca Hubka</option>
                        @foreach($items as $item)
                            <option value="{{ $item->ItemId }}">{{ $item->ItemName }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Lambarka Taxanaha *</label>
                    <input type="text" class="form-control" id="LambarkaTaxanaha"
                           name="LambarkaTaxanaha" required>
                    <span class="text-danger LambarkaTaxanaha_error"></span>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Calamada Dawlada *</label>
                    <input type="text" class="form-control"
                           name="Calamaden" value="SO-C.B.S-2025" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Shaqeyn Kara *</label>
                    <select class="form-control" name="ShaqeynKara" required>
                        <option value="1">Wuu Shaqenaya</option>
                        <option value="2">Ma shaqenayo</option>
                    </select>
                </div>
                {{-- ================= Lahansho ================= --}}
<div class="col-md-6">
    <label class="form-label fw-bold">Lahansho *</label>
    <select class="form-control" name="Lahansho" required>
        <option value="">Dooro Lahansho</option>
        <option value="Dawlada">Dawlada</option>
        <option value="Shaqsi">Shaqsi</option>
        <option value="Qabiil">Qabiil</option>
    </select>
</div>


                <div class="col-md-12">
                    <label class="form-label fw-bold">Sawirada Hubka *</label>
                    <input type="file" class="form-control" id="sawiradaHubka" multiple>
                    <div id="preview-container" class="mt-2 d-flex flex-wrap gap-2"></div>
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-bold">Faahfaahinta Hubka *</label>
                    <textarea class="form-control" name="faahfaahintaHubka" rows="4" required></textarea>
                </div>

            </div>

            <div class="mt-4 border-top pt-3">
                <button type="submit" id="saveBtn" class="btn btn-success px-4">
                    <i class="fa fa-save"></i> Save
                </button>
                <a href="{{ route('keydin.list') }}" class="btn btn-secondary px-4">Back</a>
            </div>

        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(function () {

    const csrf = $('meta[name="csrf-token"]').attr('content');
    let selectedFiles = [];
    let serialValid = false;

    $('.select2').select2({ width: '100%' });

    $('#LambarkaTaxanaha').on('input', function () {
        this.value = this.value.replace(/\s+/g, '');
    });

    function toggleDynamicFields() {
        const x1 = $('#Xaalada1').val();

        $('#Xaalada2_container,#wrapper_B,#wrapper_C,#Shaqsi_wrapper,#ShaqsiDoc_wrapper,#store_wrapper')
            .addClass('d-none');

        $('#ShaqsiDoc,#store_id').prop('required', false);

        if (x1 === '0') {
            $('#Xaalada2_container,#store_wrapper').removeClass('d-none');
            $('#store_id').prop('required', true);
        }

        if (x1 === '1') {
            $('#Xaalada2_container,#wrapper_B,#wrapper_C').removeClass('d-none');
        }

        if (x1 === '2') {
            $('#Shaqsi_wrapper,#ShaqsiDoc_wrapper').removeClass('d-none');
            $('#ShaqsiDoc').prop('required', true);
        }
    }

    $('#Xaalada1').on('change', toggleDynamicFields);
    toggleDynamicFields();

    $('#FadhiId').on('change', function () {
        const id = this.value;
        const store = $('#store_id');
        store.html('<option>Loading...</option>');

        if (!id) return;

        $.get("{{ route('get.stores.by.department') }}", { department_id: id })
            .done(res => {
                store.html('<option value="">Dooro Bakhaarka</option>');
                res.forEach(s =>
                    store.append(`<option value="${s.StoradaId}">${s.StoreName}</option>`)
                );
            });
    });

    $('#ShaqsiSearch').select2({
        placeholder: 'Raadi Shaqsi',
        ajax: {
            url: "{{ route('shaqsi.search') }}",
            method: 'POST',
            delay: 250,
            dataType: 'json',
            data: p => ({ _token: csrf, search: p.term }),
            processResults: res => ({
                results: res.data.map(i => ({
                    id: i.ShaqsiyaadkaId,
                    text: i.magacaShaqsiga + ' (' + i.TalefanLambarka + ')'
                }))
            })
        }
    });


        $('.select2-askari').select2({
        placeholder: 'Raadi Askari...',
        allowClear: true,
        minimumInputLength: 1,
        ajax: {
            url: '{{ route("search.askari") }}',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });

    $('#LambarkaTaxanaha').on('blur', function () {
        const serial = this.value;
        const hub = $('#QaybtaHubka').val();
        if (!serial || !hub) return;

        $.post("{{ route('keydin.checkSerial') }}", {
            _token: csrf,
            LambarkaTaxanaha: serial,
            QaybtaHubka: hub
        }).done(res => {
            if (res.exists) {
                serialValid = false;
                $(this).addClass('is-invalid');
                $('.LambarkaTaxanaha_error').text('Serial-kan hore ayaa loo diiwaangeliyay');
            } else {
                serialValid = true;
                $(this).removeClass('is-invalid').addClass('is-valid');
                $('.LambarkaTaxanaha_error').text('');
            }
        });
    });

    $('#sawiradaHubka').on('change', function () {
        Array.from(this.files).forEach(file => {
            if (!file.type.startsWith('image/')) return;
            selectedFiles.push(file);

            const r = new FileReader();
            r.onload = e => {
                const box = $(`
                    <div class="position-relative">
                        <img src="${e.target.result}" width="100" class="img-thumbnail">
                        <button type="button"
                            class="btn btn-danger btn-sm position-absolute top-0 end-0">&times;</button>
                    </div>
                `);
                box.find('button').on('click', () => {
                    selectedFiles = selectedFiles.filter(f => f !== file);
                    box.remove();
                });
                $('#preview-container').append(box);
            };
            r.readAsDataURL(file);
        });
        this.value = '';
    });

    $('#keydinForm').on('submit', function (e) {
        e.preventDefault();

        let valid = true;
        $('[required]:visible').each(function () {
            if (!this.value) {
                $(this).addClass('is-invalid');
                valid = false;
            }
        });

        if (!valid || !serialValid) {
            Swal.fire('Error', 'Fadlan buuxi xogta saxda ah', 'error');
            return;
        }

        const btn = $('#saveBtn').prop('disabled', true)
            .html('<i class="fa fa-spinner fa-spin"></i> Saving...');

        const fd = new FormData(this);
        fd.delete('sawiradaHubka[]');
        selectedFiles.forEach(f => fd.append('sawiradaHubka[]', f));

        $.ajax({
            url: "{{ route('keydin.store') }}",
            method: 'POST',
            data: fd,
            processData: false,
            contentType: false
        }).done(() => {
            Swal.fire('Guul!', 'Waa la keydiyay', 'success')
                .then(() => location.href = "{{ route('keydin.create') }}");
        }).fail(() => {
            btn.prop('disabled', false).html('Save');
        });
    });

});
</script>
@endpush
