@extends('frount.index')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h5>Add Details <a href="{{ route('users') }}" class="btn  btn-danger btn-sm float-right"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;Go Back</a></h5>
                    </div>
                    <div class="card-body">
                        <form role="form" id="quickForm" action="{{ route('users.create') }}" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xl-6 col-lg-6">
                                <div class="form-group{{ $errors->has('emp_id') ? ' has-error' : '' }}">
                                    <label for="emp_id" class="col-md-4 control-label">User Id/Username</label>
                                     <input id="emp_id" type="text" class="form-control" name="emp_id" value="{{ old('emp_id') }}"  autofocus placeholder="Enter username/employee Id">
                                     @if ($errors->has('emp_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('emp_id') }}</strong>
                                    </span>
                                    @endif
                                </div>


                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Name</label>
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}"  placeholder="Enter Name">
                                    @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                                    <input id="email" type="email" class="form-control @if($errors->has('email')) is-invalid @endif" name="email" value="{{ old('email') }}" placeholder="Enter Email Id">
                                    @if ($errors->has('email'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xl-6 col-lg-6">

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="col-md-4 control-label">Password</label>
                                    <input id="password" type="password" autocomplete="new-password" class="form-control @if ($errors->has('password')) is-invalid  @endif" name="password" value="{{ old('email') }}"  placeholder="Enter password">
                                    @if ($errors->has('password'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                @php $type = Auth::user()->emp_type; @endphp

                                @if ($type == "super_admin")
                                <div class="form-group{{ $errors->has('crm_limit') ? ' has-error' : '' }}">
                                    <label for="crm_limit" class="col-md-4 control-label">CRM Limit</label>
                                    <input id="crm_limit" type="number" autocomplete="crm_limit" class="form-control @if ($errors->has('crm_limit')) is-invalid @endif" name="crm_limit" value="{{ old('crm_limit') }}"  placeholder="Enter CRM Limit">
                                    @if ($errors->has('crm_limit'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('crm_limit') }}</strong>
                                    </span>
                                    @endif
                                 </div>
                                @endif



                                @if ($type == "admin")
                                <div class="form-group">
                                    <label for="password" class="col-md-4 control-label">Edit access</label>
                                    <select id="user_access" name="user_access" class="form-control">
                                        <option value="">Please Select</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                 </div>
                                @endif


                                @if($type == "admin")
                                <div class="form-group">
                                    <label for="process_name" class="col-md-4 control-label">Select Process</label>
                                    <select id="process_name" name="process_name" class="form-control @if ($errors->has('process_name')) is-invalid @endif">
                                        <option selected="selected" value="">--select process--</option>
                                        @foreach ($crm_list as $rows_crm_list)
                                        <option value="{{ $rows_crm_list->crm_name }}">
                                            {{ $rows_crm_list->crm_name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('process_name') }}</strong>
                                    </span>
                                </div>
                                @endif

                                @if ($type == "super_admin")
                                <div class="form-group">
                                    <label for="Role" class="control-label">Employe Type</label>
                                    <input type="hidden" value="1" name="user_access">
                                    <div class="col-md-2">
                                        <input type="radio" id="emp_type" tabindex="17" name="emp_type" value="admin" data-field="admin" class="chk" checked> Admin
                                    </div>
                                </div>
                                @endif


                            </div>
                            <div class="col-md-6 col-sm-6 col-xl-6 col-lg-6">
                                 @if($type == "admin")
                                <div class="form-group">
                                    <label for="Role" class="control-label">Employe Type</label>
                                    <div class="form-group">
                                        <input type="radio" name="emp_type" value="agent" checked data-field="Agent" class="chk"> Agent
                                    </div>
                                    <div class="form-group">
                                        <input type="radio" name="emp_type" value="supervisor" data-field="supervisor" class="chk"> Supervisor
                                    </div>
                                 </div>
                                 @endif
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary float-right">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

 </section>
 </div>
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>

$(function(){

  $('#quickForm').validate({
        rules: {
        emp_type: {
            required: true,
        },
        process_name: {
            required: true,
        },
        user_access: {
            required: true,
        },
        crm_limit: {
            required: true,
        },
        password:{
            required: true,
        },
        email:{
            required: true,
            email:true
        },
        emp_id:{
            required: true,
        },
        name:{
            required:true,
        }
        },
        errorElement: 'span',
            errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
            }
        });
    });
</script>
