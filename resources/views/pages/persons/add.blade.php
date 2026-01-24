@extends('layouts.admin')

@section('content')
<div class="content">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">Register Person</h3>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    <div>
        @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-bs-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> {{ Session::get('success') }}</h4>
        </div>
        @endif
        @if (Session::has('fail'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-bs-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> {{ Session::get('fail') }}</h4>
        </div>
        @endif
    </div>

    <div class="row">
        <div class="col-lg-12">
        <div class="card">
        <div class="card-header">
            <h5 class="card-title">Basic Inputs</h5>
        </div>
        <div class="card-body">
        <!-- Form Start -->
        <form id="pForm" method="post" action="{{ route('persons.store') }}" enctype="multipart/form-data">
        @csrf
        @method('post')

        <div class="row">

            {{-- Profile Image Upload --}}
            <div class="col-md-12">
                <div class="d-flex align-items-center flex-wrap bg-light w-100 rounded p-3 mb-4">
                    <div class="d-flex align-items-center justify-content-center avatar avatar-xxl rounded-circle border border-dashed me-2 flex-shrink-0">
                        <img src="{{ asset('upload/userImge/userimg.PNG') }}" alt="Profile Image" class="rounded-circle">
                    </div>
                    <div class="profile-upload">
                        <h6 class="mb-1">Upload Profile Image</h6>
                        <p class="fs-12">Image should be below 4MB</p>
                        <div class="profile-uploader d-flex align-items-center">
                            <div class="drag-upload-btn btn btn-sm btn-primary me-2">
                                Upload
                                <input type="file" name="personImd" class="form-control">
                            </div>
                            <a href="javascript:void(0);" class="btn btn-light btn-sm">Cancel</a>
                        </div>
                        <span class="text-danger">@error('personImd') {{ $message }} @enderror</span>
                    </div>
                </div>
            </div>

            {{-- Other Fields --}}
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-form-label">Full Name</label>
                    <input class="form-control" type="text" id="fullName" name="fullName" placeholder="Full Name" value="{{ old('fullName') }}">
                    <span class="text-danger">@error('fullName') {{ $message }} @enderror</span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-form-label">Gender</label>
                    <div>
                        <label class="me-3">
                            <input type="radio" name="gender" value="Male" {{ old('gender') == 'Male' ? 'checked' : '' }}> Male
                        </label>
                        <label>
                            <input type="radio" name="gender" value="Female" {{ old('gender') == 'Female' ? 'checked' : '' }}> Female
                        </label>
                    </div>
                    <span class="text-danger">@error('gender') {{ $message }} @enderror</span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-form-label">Email</label>
                    <input class="form-control" type="text" id="email" name="email" placeholder="email@example.com" value="{{ old('email') }}">
                    <span class="text-danger">@error('email') {{ $message }} @enderror</span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-form-label">Phone</label>
                    <input class="form-control" type="text" id="phone" name="phone" placeholder="+252 xxxxxxxxx" value="{{ old('phone') }}">
                    <span class="text-danger">@error('phone') {{ $message }} @enderror</span>
                </div>
            </div>

            {{-- Multi Photo Capture with Popup --}}
            <div class="col-md-12">
                <h5 class="mb-2">Take Multiple Photos</h5>

                <!-- Button to open modal -->
                <button type="button" class="btn btn-success my-2" data-bs-toggle="modal" data-bs-target="#cameraModal">
                    📷 Open Camera
                </button>

                <!-- All Clear button (hidden by default) -->
                <button type="button" id="clearAllBtn" class="btn btn-danger my-2 d-none">
                    🗑️ Clear All
                </button>

                <!-- Previews will show here -->
                <div id="preview-container" class="d-flex flex-wrap"></div>

                <!-- Hidden input to send Base64 JSON -->
                <input type="hidden" name="photos" id="photos-data">
            </div>
        </div>

        <hr>
        <div class="d-flex align-items-center justify-content-end">
            <a href="{{ route('persons.index') }}" type="button" class="btn btn-outline-light border me-3">Cancel</a>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
        </form>
        </div>
        </div>
        </div>
    </div>
</div>

<!-- Camera Modal -->
<div class="modal fade" id="cameraModal" tabindex="-1" aria-labelledby="cameraModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Take Photo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <video id="video" width="500px" height="500px" autoplay class="border rounded"></video>
        <br>
        <button type="button" id="capture" class="btn btn-primary mt-2">📸 Capture</button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Done</button>
      </div>
    </div>
  </div>
</div>

<script>
    const video = document.getElementById('video');
    const captureBtn = document.getElementById('capture');
    const previewContainer = document.getElementById('preview-container');
    const photosData = document.getElementById('photos-data');
    const clearAllBtn = document.getElementById('clearAllBtn');
    let capturedPhotos = [];

    // Listen for Bootstrap modal open/close
    const cameraModal = document.getElementById('cameraModal');

    cameraModal.addEventListener('shown.bs.modal', function () {
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                video.srcObject = stream;
            });
    });

    cameraModal.addEventListener('hidden.bs.modal', function () {
        let stream = video.srcObject;
        if (stream) {
            let tracks = stream.getTracks();
            tracks.forEach(track => track.stop());
        }
        video.srcObject = null;
    });

    // Capture photo
    captureBtn.addEventListener('click', () => {
        let canvas = document.createElement('canvas');
        canvas.width = 320;
        canvas.height = 240;
        canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);

        let imageData = canvas.toDataURL('image/png');
        capturedPhotos.push(imageData);

        photosData.value = JSON.stringify(capturedPhotos);

        // Show preview
        let imgWrapper = document.createElement('div');
        imgWrapper.classList.add('m-1','position-relative');

        let img = document.createElement('img');
        img.src = imageData;
        img.classList.add('border','rounded');
        img.style.width = "100px";

        // remove button
        let removeBtn = document.createElement('button');
        removeBtn.innerHTML = "&times;";
        removeBtn.type = "button";
        removeBtn.classList.add('btn','btn-sm','btn-danger','position-absolute');
        removeBtn.style.top = "0";
        removeBtn.style.right = "0";

        removeBtn.onclick = () => {
            imgWrapper.remove();
            capturedPhotos = capturedPhotos.filter(p => p !== imageData);
            photosData.value = JSON.stringify(capturedPhotos);
            toggleClearAll();
        };

        imgWrapper.appendChild(img);
        imgWrapper.appendChild(removeBtn);
        previewContainer.appendChild(imgWrapper);

        toggleClearAll();
    });

    // Clear all photos
    clearAllBtn.addEventListener('click', () => {
        capturedPhotos = [];
        previewContainer.innerHTML = "";
        photosData.value = "";
        toggleClearAll();
    });

    // Show/hide clear all button
    function toggleClearAll() {
        if (capturedPhotos.length > 0) {
            clearAllBtn.classList.remove('d-none');
        } else {
            clearAllBtn.classList.add('d-none');
        }
    }
</script>
@endsection
