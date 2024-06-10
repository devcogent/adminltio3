
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ $brand_data->crm_title }} </title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/images/'.$brand_data->logo_url)}}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('public/plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{ asset('public/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('public/dist/css/adminlte.min.css?v=3.2.0')}}">
    <link rel="stylesheet" href="{{asset('public/plugins/toastr/toastr.min.css')}}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
<div class="card card-outline card-primary">
<div class="card-header text-center">
    <h4><img src="{{ asset('public/images/'.$brand_data->logo_url)}}"  width="{{ $brand_data->width_img }}%" height="{{ $brand_data->height_img }}%"></h4>
</div>
<div class="card-body">
        <form class="form-horizontal" method="POST" action="{{ route('login.custom') }}">
            {{ csrf_field() }}
            <div {{ $errors->has('emp_id') ? ' has-error' : '' }}>
                <input id="login" type="text" class="form-control{{ $errors->has('emp_id') || $errors->has('email') ? ' is-invalid' : '' }}" name="emp_id" value="{{ old('emp_id') ?: old('email') }}" required autofocus placeholder="enter user name or user id">
                <input name="full_url" type="hidden" value="{{ $full_url }}">
                <input name="db" type="hidden" value="{{ Request::segment(1) }} ">

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
            </div>
        </form>
    </div>
  </div>
</div>
<script src="{{ asset('public/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('public/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('public/dist/js/adminlte.min.js?v=3.2.0')}}"></script>
<script src="{{asset('public/plugins/toastr/toastr.min.js')}}"></script>
<script>
    $(document).ready(function() {
        toastr.options.timeOut = 3000;
        @if (Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @elseif (Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @elseif (Session::has('info'))
            toastr.info("{{ Session::get('info') }}");
        @endif
    });
</script>
</body>
</html>







