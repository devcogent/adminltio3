
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>O3 | Log in (v2)</title>

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

<link rel="stylesheet" href="{{ asset('public/plugins/fontawesome-free/css/all.min.css')}}">

<link rel="stylesheet" href="{{ asset('public/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">

<link rel="stylesheet" href="{{ asset('public/dist/css/adminlte.min.css?v=3.2.0')}}">
</head>
<body class="hold-transition login-page">
<div class="login-box">

<div class="card card-outline card-primary">
<div class="card-header text-center">
    <h4><img src="{{ asset('public/images/cog.png')}}" /></h4>

</div>
<div class="card-body">
<form class="form-horizontal" method="POST" action="{{ route('login') }}">
    {{ csrf_field() }}

    <div {{ $errors->has('emp_id') ? ' has-error' : '' }}>
       <input id="login" type="text" class="form-control{{ $errors->has('emp_id') || $errors->has('email') ? ' is-invalid' : '' }}" name="login" value="{{ old('emp_id') ?: old('email') }}" required autofocus placeholder="Enter user name or user id">
      @if ($errors->has('emp_id') || $errors->has('email'))
      <span class="invalid-feedback">
        <strong>{{ $errors->first('emp_id') ?: $errors->first('email') }}</strong>
      </span>
      @endif
    </div>
    <div class="my-3">
      <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="current-password" aria-describedby="emailHelp" placeholder="Enter Password">
    </div>
    <div>
      <button type="submit" class="btn btn-primary submit">{{ __('Login') }}</button>
      @if (Route::has('password.request'))
      {{-- <a class="reset_pass" href="{{ route('password.request') }}">
        {{ __('Forgot Your Password?') }}
      </a> --}}
      @endif
    </div>

    <div class="clearfix"></div>
    <!--<div class="separator">
        <p class="change_link">New to site?
        <a href="#signup" class="to_register"> Create Account </a>
       </p><div class="clearfix"></div>
         <br />
      </div>-->
  </form>



</div>

</div>

</div>


<script src="{{ asset('public/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('public/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('public/dist/js/adminlte.min.js?v=3.2.0')}}"></script>
</body>
</html>
