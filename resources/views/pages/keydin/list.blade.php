@extends('layouts.admin')

@section('content')
<div class="content">

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
        <div>
            <h3 class="fw-bold mb-1">{{ $pageTitle }}</h3>
            <nav>
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="ti ti-smart-home"></i></a></li>
                    <li class="breadcrumb-item">{{ $pageTitle }}</li>
                    <li class="breadcrumb-item active">{{ $subTitle }}</li>
                </ol>
            </nav>
        </div>

  
        <a href="{{ route('keydin.create') }}" class="btn btn-primary btn-lg shadow-sm d-flex align-items-center">
            <i class="ti ti-circle-plus me-2"></i> KuDar HubCusub 
        </a>
       
    </div>

    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm">
            <strong><i class="fa fa-check-circle me-2"></i></strong>{{ Session::get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-0 stats-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Dhammaan</p>
                        <h3 class="fw-bold">{{ $AllKeydin ?? 0 }}</h3>
                    </div>
                    <div class="icon-circle bg-dark text-white"><i class="ti ti-package fs-4"></i></div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-0 stats-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">La Bixiyay</p>
                        <h3 class="fw-bold">{{ $ActiveKeydin ?? 0 }}</h3>
                    </div>
                    <div class="icon-circle bg-success text-white"><i class="ti ti-check fs-4"></i></div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-0 stats-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Kaydsan</p>
                        <h3 class="fw-bold">{{ $InactiveKeydin ?? 0 }}</h3>
                    </div>
                    <div class="icon-circle bg-warning text-white"><i class="ti ti-box fs-4"></i></div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-0 stats-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Shaqsiyadka</p>
                        <h3 class="fw-bold">{{ $shaqsiyadka ?? 0 }}</h3>
                    </div>
                    <div class="icon-circle bg-info text-white"><i class="ti ti-calendar-plus fs-4"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-3 mb-4">
        <div class="card-header bg-white fw-bold">Raadinta / Shaandhaynta</div>
        <div class="card-body">
              <form method="GET" action="{{ route('keydin.raadi') }}" class="row g-3">

            <div class="col-md-3">
                <select name="qaybta" class="form-control select2">
                    <option value="">-- Qaybta Hubka --</option>
                    @foreach ($Item as $q)
                        <option value="{{ $q->ItemId }}">{{ $q->ItemName }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <select name="fadhiga" class="form-control select2">
                    <option value="">-- Fadhiga --</option>
                    @foreach ($fadhiyada as $f)
                        <option value="{{ $f->id }}">{{ $f->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <input type="text" name="Qorinumber" class="form-control" placeholder="Qorinumber" value="{{ request('Qorinumber') }}">
            </div>

            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">All</option>
                    <option value="1">La Bixiyay</option>
                    <option value="0">Kaydsan</option>
                </select>
            </div>
    <!-- DATE FROM -->
            <div class="col-md-3">
                <input type="date" name="date_from" class="form-control"
                    value="{{ request('date_from') }}" placeholder="Date From">
            </div>

            <!-- DATE TO -->
            <div class="col-md-3">
                <input type="date" name="date_to" class="form-control"
                    value="{{ request('date_to') }}" placeholder="Date To">
            </div>
               <div class="col-md-3">
                <select name="status1" class="form-select">
                       <option value="">Dooro Xaalada</option>
                        <option value="1">La baxshay</option>
                        <option value="2">La keydiyay</option>
                        <option value="3">Lumay</option>
                        <option value="5">Baafin</option>
                        <option value="6">La Qabtay</option>
                        <option value="4">La Burburiyay</option>
                </select>
            </div>
            <div class="col-md-1 d-grid">
                <button class="btn btn-primary"><i class="ti ti-search"></i></button>
            </div>

        </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Sawirka</th>
                            <th>Nooca Hubka</th>
                            <th>Fadhiga</th>
                            <th>Serial Number</th>
                            <th>Xaaladda</th>
                            <th>Taariikhda</th>
                            <th class="text-end">Ficil</th>
                        </tr>
                    </thead>
                    <tbody>
                      @forelse ($keydins as $item)
    <tr>
        <td>
            {{-- Image Logic --}}
            @php
                $img = null;
                if ($item->keydin_image1) {
                    $imgs = explode(',', $item->keydin_image1);
                    $img = trim($imgs[0]);
                }
                $imageUrl = $img ? "https://hoggankasaadka.s3.ap-northeast-1.amazonaws.com/{$img}" : "https://via.placeholder.com/55?text=No+Img";
            @endphp
            <img src="{{ $imageUrl }}" style="width:50px; height:50px; object-fit:cover; border-radius:8px;">
        </td>
        <td>{{ $item->QaybtaHubkaRelation->ItemName ?? 'N/A' }}</td>
        <td>{{ $item->FadhiIdRelation->name ?? 'N/A' }}</td>
        <td><strong>{{ $item->keydin_lambarka1 }}</strong></td>
        
        {{-- UPDATED STATUS BADGE --}}
        <td>
            <span class="badge 
                @if($item->keydin_Xalada == 1) bg-success 
                @elseif($item->keydin_Xalada == 2) bg-info 
                @else bg-secondary @endif">
                
                @if($item->keydin_Xalada == 1)
                    La Bixiyay
                @elseif($item->keydin_Xalada == 2)
                    Shaqsiyaadka
                @else
                    Kaydsan
                @endif
            </span>
        </td>

        <td>{{ $item->keydin_CreateDate }}</td>
        <td class="text-end">
            <a href="{{ route('keydin.show', $item->keydin_ID) }}" class="btn btn-sm btn-light rounded-circle" title="Fiiri">
                <i class="ti ti-eye"></i>
            </a>

            @if(auth()->user()->role_id == 1)
                <a href="{{ route('keydin.edit', $item->keydin_ID) }}" class="btn btn-sm btn-light rounded-circle" title="Wax ka badal">
                    <i class="ti ti-edit"></i>
                </a>

                <button type="button" class="btn btn-sm btn-light rounded-circle delete-record" 
                        data-id="{{ $item->keydin_ID }}" 
                        data-name="{{ $item->keydin_lambarka1 }}">
                    <i class="ti ti-trash text-danger"></i>
                </button>

                <form id="delete-form-{{ $item->keydin_ID }}" action="{{ route('keydin.destroy', $item->keydin_ID) }}" method="POST" style="display:none;">
                    @csrf
                    @method('DELETE')
                </form>
            @endif
        </td>
    </tr>
@empty
    <tr><td colspan="7" class="text-center py-4">Lama helin wax xog ah.</td></tr>
@endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-3">
                {{ $keydins->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    .stats-card:hover { transform: translateY(-3px); transition: 0.3s; }
    .icon-circle { width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
</style>
@endsection

@push('scripts')


<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        // 1. SUCCESS ALERT: Show after Redirect (Store/Update/Delete)
        @if(Session::has('success'))
            Swal.fire({
                icon: 'success',
                title: 'Guul!',
                text: "{{ Session::get('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        // 2. ERROR ALERT: Show if something fails
        @if(Session::has('fail'))
            Swal.fire({
                icon: 'error',
                title: 'Dhibaato!',
                text: "{{ Session::get('fail') }}",
            });
        @endif

        // 3. DELETE CONFIRMATION: SweetAlert before form submission
        const deleteButtons = document.querySelectorAll('.delete-record');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const recordId = this.getAttribute('data-id');
                const serialName = this.getAttribute('data-name');
                const targetForm = document.getElementById('delete-form-' + recordId);

                Swal.fire({
                    title: 'Ma hubtaa?',
                    text: "Waxaad tirtiraysaa Hubka leh Serial: " + serialName,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Haa, tirtir!',
                    cancelButtonText: 'Iska daa',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // This triggers the form, page reloads, and Part 1 (Success Alert) shows up
                        targetForm.submit();
                    }
                });
            });
        });
    });
</script>
@endpush