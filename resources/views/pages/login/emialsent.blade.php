<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ getSiteName() }}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="shortcut icon" href="{{ asset('core/public/upload/logo/favicon.png') }}"/>
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('core/resources/views/assets/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('core/resources/views/assets/bower_components/font-awesome/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('core/resources/views/assets/bower_components/Ionicons/css/ionicons.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('core/resources/views/assets/dist/css/AdminLTE.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('core/resources/views/assets/plugins/iCheck/square/blue.css') }}">
  <style>
    body {
      height: 100vh;
      background-repeat: no-repeat;
      background: url('{{asset('core/public/upload/logo/loginPG.jpeg')}}') no-repeat center center fixed;
    }
  </style>
</head>
<body class="hold-transition login-page" style="height:0; background-repeat: no-repeat;background: url('{{asset('core/public/upload/logo/loginPG.jpeg')}}') no-repeat center center fixed">
<div class="login-box">
  <div>
    @if (Session::has('success'))
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> {{ Session::get('success') }}</h4>
      </div>
    @endif
    @if (Session::has('fail'))
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <span><i class="icon fa fa-times"></i> {{ Session::get('fail') }}</span>
      </div>
    @endif
  </div>

  <!-- /.login-logo -->
<div class="login-box-body">
  <img src="{{asset('core/public/upload/logo/Logo.png')}}" width="250" height="80" class="">
<span id="SentSuccessMessage">
</span>
<h3 class="account-title ">Check Your Email</h3>
<p class="account-subtitle">The password reset link has been sent to {{showEmailAddress($email)}}.<br>NOTE: The reset email could take up to 15 minutes to arrive. Be sure to check your spam/junk folder.</p>
  <!-- /.login-box-body -->
  <hr>
<span> Remember Password?</span>
<a href="{{asset('/')}}" class="text-center">Login</a>

</div>
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="{{ asset('core/resources/views/assets/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('core/resources/views/assets/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- iCheck -->
<script src="{{ asset('core/resources/views/assets/plugins/iCheck/icheck.min.js') }}"></script>
<script>
  $(document).ready(function(){
    $('.progress').show();
    var percentage = 0;
    var timer = setInterval(function(){
      percentage = percentage + 20;
      $('.progress-bar').css('width', percentage + '%');
      if (percentage >= 100) {
        clearInterval(timer);
        $('.progress').hide();
      }
    }, 1000);
  });
</script>
</body>
</html>
