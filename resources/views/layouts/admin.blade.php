<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
   <meta name="description" content="Taliska - Ciidanka Booliska Somaliyeed">
   <meta name="keywords" content="Booliska, Somaliya, bootstrap, Saadka, Taliska, iskuxirka, Admin">
   <meta name="author" content="Eng Abdinajiib Ali Osman - Systemka  iskuxirka Booliska Somaliya">
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <meta name="robots" content="noindex, nofollow">
   <title> </title>

   <!-- Favicon -->
   <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/upload/logo/'.getSiteFavicon()) }}">

   <!-- Apple Touch Icon -->
   <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('public/upload/logo/'.getSiteFavicon()) }}">

   <!-- Theme Script js -->
   <!-- <script src="{{ asset('assets/js/theme-script.js') }}"></script> -->

   <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

   <!-- Feather CSS -->
   <link rel="stylesheet" href="{{ asset('assets/plugins/icons/feather/feather.css') }}">

   <!-- Tabler Icon CSS -->
   <link rel="stylesheet" href="{{ asset('assets/plugins/tabler-icons/tabler-icons.css') }}">

   <!-- Select2 CSS -->
   <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">

   <!-- Fontawesome CSS -->
   <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">

   <!-- Datetimepicker CSS -->
   <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">

   <!-- Summernote CSS -->
   <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-lite.min.css') }}">

   <!-- Daterangepicker CSS -->
   <link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">

   <!-- Color Picker CSS -->
   <link rel="stylesheet" href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/plugins/@simonwep/pickr/themes/nano.min.css') }}">

   <!-- Main CSS -->
   <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

   <!-- Wizard CSS -->
   <link rel="stylesheet" href="{{ asset('assets/plugins/twitter-bootstrap-wizard/form-wizard.css') }}">

   <!-- Datatable CSS -->
   <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
   <!-- Player CSS -->
   <link rel="stylesheet" href="{{ asset('assets/css/plyr.css') }} ">
   <!-- Owl Carousel -->
   <link rel="stylesheet" href="{{ asset('assets/plugins/owlcarousel/owl.carousel.min.css') }} ">

    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

   <!-- Bootstrap Tagsinput CSS -->
   <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}">

   <!-- Owl carousel CSS -->
   <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}  ">

   <style>
      .btn-primary {
    background-color: #0f3b70;
    border: 1px solid #0f3b70;
    color: white;
}
   </style>
</head>


<body>

   <div id="global-loader">
      <div class="page-loader"></div>
   </div>

   <!-- Main Wrapper -->
   <div class="main-wrapper">

      <!-- Header -->
      <div class="header">
         <div class="main-header">

            <div class="header-left">
               <a href="{{asset('dashboard/')}}" class="logo">
                  <img src="{{ asset('public/upload/logo/'.getSiteLogo()) }}" alt="Logo">
               </a>
               <a href="index.html" class="dark-logo">
                  <img src="{{ asset('public/upload/logo/'.getSiteLogo()) }}" alt="Logo">
               </a>
            </div>

            <a id="mobile_btn" class="mobile_btn" href="#sidebar">
               <span class="bar-icon">
                  <span></span>
                  <span></span>
                  <span></span>
               </span>
            </a>

            <div class="header-user">
               <div class="nav user-menu nav-list">

                  <div class="me-auto d-flex align-items-center" id="header-search">
                     <a id="toggle_btn" href="javascript:void(0);" class="btn btn-menubar me-1">
                        <i class="ti ti-arrow-bar-to-left"></i>
                     </a>
                     <!-- Search -->
                     <div class="d-inline-flex me-1">
                        <h1>{{getDepartmentNameByUserId()}}</h1>
                     </div>



                  </div>


                  <div class="d-flex align-items-center">
                     <div class="me-1">
                     <input type="text" id="armySearch" class="form-control" placeholder="Search Army Phone">
<div id="autocomplete-results" class="list-group"></div>
                     </div>
 <div class="me-1">
                        <a href="#" class="btn btn-menubar btnFullscreen">
                           <i class="ti ti-maximize"></i>
                        </a>
                     </div>

                     <div class="dropdown me-1">
                        <a href="#" class="btn btn-menubar" data-bs-toggle="dropdown">
                           <i class="ti ti-layout-grid-remove"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                           <div class="card mb-0 border-0 shadow-none">
                              <div class="card-header">
                                 <h4>Applications</h4>
                              </div>
                              <div class="card-body">                               

                                 <a href="todo.html" class="d-block py-2">
                                    <span class="avatar avatar-md bg-transparent-dark me-2"><i class="ti ti-subtask text-gray-9"></i></span>To Do
                                 </a>                             
                                 <a href="notes.html" class="d-block py-2">
                                    <span class="avatar avatar-md bg-transparent-dark me-2"><i class="ti ti-notes text-gray-9"></i></span>Notes
                                 </a>                             

                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="me-1">
                        <a href="chat.html" class="btn btn-menubar position-relative">
                           <i class="ti ti-brand-hipchat"></i>
                           <span class="badge bg-info rounded-pill d-flex align-items-center justify-content-center header-badge">5</span>
                        </a>
                     </div>
                     <div class="me-1">
                        <a href="email.html" class="btn btn-menubar">
                           <i class="ti ti-mail"></i>
                        </a>
                     </div>
                     <div class="me-1 notification_item">
                        <a href="#" class="btn btn-menubar position-relative me-1" id="notification_popup"
                        data-bs-toggle="dropdown">
                        <i class="ti ti-bell"></i>
                        <span class="notification-status-dot"></span>
                     </a>
                     <div class="dropdown-menu dropdown-menu-end notification-dropdown p-4">
                        <div class="d-flex align-items-center justify-content-between border-bottom p-0 pb-3 mb-3">
                           <h4 class="notification-title">Notifications (2)</h4>
                           <div class="d-flex align-items-center">
                              <a href="#" class="text-primary fs-15 me-3 lh-1">Mark all as read</a>
                              <div class="dropdown">
                                 <a href="javascript:void(0);" class="bg-white dropdown-toggle"
                                 data-bs-toggle="dropdown">
                                 <i class="ti ti-calendar-due me-1"></i>Today
                              </a>
                              <ul class="dropdown-menu mt-2 p-3">
                                 <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1">
                                       This Week
                                    </a>
                                 </li>
                                 <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1">
                                       Last Week
                                    </a>
                                 </li>
                                 <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1">
                                       Last Month
                                    </a>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                     <div class="noti-content">
                        <div class="d-flex flex-column">
                           <div class="border-bottom mb-3 pb-3">
                              <a href="activity.html">
                                 <div class="d-flex">
                                    <span class="avatar avatar-lg me-2 flex-shrink-0">
                                       <img src="{{asset('assets/img/profiles/avatar-27.jpg')}} " alt="Profile">
                                    </span>
                                    <div class="flex-grow-1">
                                       <p class="mb-1"><span
                                          class="text-dark fw-semibold">Shawn</span>
                                       performance in Math is below the threshold.</p>
                                       <span>Just Now</span>
                                    </div>
                                 </div>
                              </a>
                           </div>
                           <div class="border-bottom mb-3 pb-3">
                              <a href="activity.html" class="pb-0">
                                 <div class="d-flex">
                                    <span class="avatar avatar-lg me-2 flex-shrink-0">
                                       <img src="{{asset('assets/img/profiles/avatar-23.jpg')}} " alt="Profile">
                                    </span>
                                    <div class="flex-grow-1">
                                       <p class="mb-1"><span
                                          class="text-dark fw-semibold">Sylvia</span> added
                                       appointment on 02:00 PM</p>
                                       <span>10 mins ago</span>
                                       <div
                                       class="d-flex justify-content-start align-items-center mt-1">
                                       <span class="btn btn-light btn-sm me-2">Deny</span>
                                       <span class="btn btn-primary btn-sm">Approve</span>
                                    </div>
                                 </div>
                              </div>
                           </a>
                        </div>
                        <div class="border-bottom mb-3 pb-3">
                           <a href="activity.html">
                              <div class="d-flex">
                                 <span class="avatar avatar-lg me-2 flex-shrink-0">
                                    <img src="{{asset('assets/img/profiles/avatar-25.jpg')}}  " alt="Profile">
                                 </span>
                                 <div class="flex-grow-1">
                                    <p class="mb-1">New student record <span class="text-dark fw-semibold"> George</span> 
                                       is created by <span class="text-dark fw-semibold">Teressa</span>
                                    </p>
                                    <span>2 hrs ago</span>
                                 </div>
                              </div>
                           </a>
                        </div>
                        <div class="border-0 mb-3 pb-0">
                           <a href="activity.html">
                              <div class="d-flex">
                                 <span class="avatar avatar-lg me-2 flex-shrink-0">
                                    <img src="{{asset('assets/img/profiles/avatar-01.jpg')}} " alt="Profile">
                                 </span>
                                 <div class="flex-grow-1">
                                    <p class="mb-1">A new teacher record for <span class="text-dark fw-semibold">Elisa</span> </p>
                                    <span>09:45 AM</span>
                                 </div>
                              </div>
                           </a>
                        </div>
                     </div>
                  </div>
                  <div class="d-flex p-0">
                     <a href="#" class="btn btn-light w-100 me-2">Cancel</a>
                     <a href="activity.html" class="btn btn-primary w-100">View All</a>
                  </div>
               </div>
            </div>
            <div class="dropdown profile-dropdown">
               <a href="javascript:void(0);" class="dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                  <span class="avatar avatar-sm online">
                     <img src="{{ asset(Session()->get('photo')) }}" alt="img" class="img-fluid rounded-circle">
                  </span>
               </a>
               <div class="dropdown-menu shadow-none">
                  <div class="card mb-0">
                     <div class="card-header">
                        <div class="d-flex align-items-center">
                           <span class="avatar avatar-lg me-2 avatar-rounded">
                         <img src="{{ asset(Session()->get('photo')) }}" alt="img">
                           </span>
                           <div>
                              <h5 class="mb-0">{{Session()->get('full_name')}}</h5>
                              <p class="fs-12 fw-medium mb-0">{{Session()->get('username')}}</p>
                           </div>
                        </div>
                     </div>
                     <div class="card-body">
                        <a class="dropdown-item d-inline-flex align-items-center p-0 py-2"
                        href="profile.html">
                        <i class="ti ti-user-circle me-1"></i>My Profile
                     </a>
                       <a class="dropdown-item d-inline-flex align-items-center p-0 py-2"
                        href="">
                        <i class="ti ti-user-circle me-1"></i>Depart Profile
                     </a>
                     <a class="dropdown-item d-inline-flex align-items-center p-0 py-2" href="bussiness-settings.html">
                        <i class="ti ti-settings me-1"></i>Settings
                     </a>

                     <a class="dropdown-item d-inline-flex align-items-center p-0 py-2"
                     href="profile-settings.html">
                     <i class="ti ti-circle-arrow-up me-1"></i>My Account
                  </a>
                
               </div>
               <div class="card-footer py-1">
    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item d-inline-flex align-items-center p-0 py-2">
                                            <i class="ti ti-logout me-2"></i>Logout
                                        </button>
                                    </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
</div>

<!-- Mobile Menu -->
<div class="dropdown mobile-user-menu">
   <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
      <i class="fa fa-ellipsis-v"></i>
   </a>
   <div class="dropdown-menu dropdown-menu-end">
      <a class="dropdown-item" href="profile.html">My Profile</a>
      <a class="dropdown-item" href="profile-settings.html">Settings</a>
      <a class="dropdown-item" href="login.html">Logout</a>
   </div>
</div>
<!-- /Mobile Menu -->

</div>

</div>
<!-- /Header -->

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
   <!-- Logo -->
   <div class="sidebar-logo">
      <a href="{{asset('dashboard/')}}" class="logo logo-normal">
         <img src="{{ asset('public/upload/logo/'.getSiteLogo()) }}" alt="Logo1" width="200" height="100">
      </a>
      <a href="{{asset('dashboard/')}}" class="logo-small">
         <img src="{{ asset('public/upload/logo/'.getSiteLogo()) }} " alt="Logo2">
      </a>
      <a href="{{asset('dashboard/')}}" class="dark-logo">
         <img src="{{ asset('public/upload/logo/'.getSiteLogo()) }} " alt="Logo3">
      </a>
   </div>
   <!-- /Logo -->
   <div class="modern-profile p-3 pb-0">
      <div class="text-center rounded bg-light p-3 mb-4 user-profile">
         <div class="avatar avatar-lg online mb-3">
            <img src="{{asset('assets/img/profiles/avatar-02.jpg')}}" alt="Img" class="img-fluid rounded-circle">
         </div>
         <h6 class="fs-12 fw-normal mb-1">Adrian Herman</h6>
         <p class="fs-10">System Admin</p>
      </div>
      <div class="sidebar-nav mb-3">
         <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded nav-justified bg-transparent"
         role="tablist">
         <li class="nav-item"><a class="nav-link active border-0" href="#">Menu</a></li>
         <li class="nav-item"><a class="nav-link border-0" href="chat.html">Chats</a></li>
         <li class="nav-item"><a class="nav-link border-0" href="email.html">Inbox</a></li>
      </ul>
   </div>
</div>

<div class="sidebar-inner slimscroll">


   @include('layouts.sidebar')
</div>
</div>
<!-- /Sidebar -->

<!-- Page Wrapper -->
<div class="page-wrapper">

   @yield('content')
   <div class="footer d-sm-flex align-items-center justify-content-between border-top bg-white p-3">
      <p class="mb-0">2022 - 2025 &copy; Taliska Ciidan Booliska Somaliya.</p>
      <p>Designed &amp; Developed By <a href="javascript:void(0);" class="text-primary">Taliska Ciidan Booliska Somaliya.</a></p>
   </div>

</div>
<!-- /Page Wrapper -->

</div>
<!-- /Main Wrapper -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- jQuery -->
<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>

<!-- Bootstrap Core JS -->
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

<!-- Feather Icon JS -->
<script src="{{ asset('assets/js/feather.min.js') }}"></script>

<!-- Slimscroll JS -->
<script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>

<!-- Apex Chart JS -->
<script src="{{ asset('assets/plugins/apexchart/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/plugins/apexchart/chart-data.js') }}"></script>

<!-- Chart JS -->
<script src="{{ asset('assets/plugins/chartjs/chart.min.js') }}"></script>
<script src="{{ asset('assets/plugins/chartjs/chart-data.js') }}"></script>

<!-- Datetimepicker JS -->
<script src="{{ asset('assets/js/moment.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>

<!-- Daterangepicker JS -->
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>

<!-- Summernote JS -->
<script src="{{ asset('assets/plugins/summernote/summernote-lite.min.js') }}"></script>

<!-- Select2 JS -->
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>

<!-- Peity Chart JS -->
<script src="{{ asset('assets/plugins/peity/jquery.peity.min.js') }}"></script>
<script src="{{ asset('assets/plugins/peity/chart-data.js') }}"></script>

<!-- Color Picker JS -->
<script src="{{ asset('assets/plugins/@simonwep/pickr/pickr.es5.min.js') }}"></script>

<!-- Custom JS -->
<script src="{{ asset('assets/js/theme-colorpicker.js') }}"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>
<!-- Datatable JS -->
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}"></script> 
<!-- Bootstrap Tagsinput JS -->
<script src="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
<!-- Custom JS -->
<script src="{{ asset('assets/js/todo.js') }}"></script>


<!-- Daterangepikcer JS -->

<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<!-- Wizard JS -->
<script src="{{ asset('assets/plugins/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') }} "></script>
<script src="{{ asset('assets/plugins/twitter-bootstrap-wizard/prettify.js') }} "></script>
<script src="{{ asset('assets/plugins/twitter-bootstrap-wizard/form-wizard.js') }}"></script>
<!-- Sticky Sidebar JS -->
<script src="{{ asset('assets/plugins/theia-sticky-sidebar/ResizeSensor.js') }}"></script>
<script src="{{ asset('assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}"></script>




<!-- Color Picker JS -->
<script src="{{ asset('assets/js/plyr-js.js') }} "></script>



<!-- Owl Carousel -->
<script src="{{ asset('assets/plugins/owlcarousel/owl.carousel.min.js') }}"></script>



<!-- Theiastickysidebar JS -->
<script src="{{ asset('assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.min.js') }} "></script>
<script src="{{ asset('assets/plugins/theia-sticky-sidebar/ResizeSensor.min.js') }}"></script>

<!-- Custom JS -->
<script src="{{ asset('assets/js/file-manager.js')}}"></script>


<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>


   <!-- Owl Carousel JS -->
   <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>



   <!-- Custom JS -->
   <script src="{{ asset('assets/js/email.js') }}"></script>
 @stack('scripts')
</body>
<script>
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
   $(document).ready(function () {
         const armyShowBaseUrl = "{{ url('armies') }}";
    $('#armySearch').on('keyup', function () {
        let query = $(this).val();
        if (query.length >= 2) {
            $.ajax({
                url: "",
                type: "GET",
                data: { term: query },
                success: function (data) {
                    let resultsDiv = $('#autocomplete-results');
                    resultsDiv.empty();
                    if (data.length > 0) {
                        data.forEach(item => {
                              let url = `${armyShowBaseUrl}/${item.id}`;
                            resultsDiv.append(`
                                <a href="${url}" class="list-group-item list-group-item-action">
                                    ${item.first_name} ${item.middle_name} - ${item.last_name} (${item.phone})
                                </a>
                            `);
                        });
                    } else {
                        resultsDiv.append(`<div class="list-group-item disabled">No matches</div>`);
                    }
                }
            });
        } else {
            $('#autocomplete-results').empty();
        }
    });
});

</script>

</html>