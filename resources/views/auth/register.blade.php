@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('emp_id') ? ' has-error' : '' }}">
                            <label for="emp_id" class="col-md-4 control-label">Employee Id</label>

                            <div class="col-md-6">
                                <input id="emp_id" type="text" class="form-control" name="emp_id" value="{{ old('emp_id') }}" required autofocus>

                                @if ($errors->has('emp_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('emp_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('emp_type') ? ' has-error' : '' }}">
                            <label for="emp_type" class="col-md-4 control-label">Employee Type</label>

                            <div class="col-md-6">
                                <select class="form-control select2bs4" style="width: 100%;" name="emp_type" id="emp_type">
                                    <option value="" selected>Select Employee Type</option>
                                    <option value="admin">Admin</option>
                                    <option value="agent">Agent</option>
                                    <option value="manager">Manager</option>

                                </select>

                                @if ($errors->has('emp_type'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('emp_type') }}</strong>
                                </span>
                                @endif
                            </div>

                        </div>
                        <div class="form-group{{ $errors->has('emp_type') ? ' has-error' : '' }}">
                            <label for="emp_type" class="col-md-4 control-label">Employee Zone</label>
                            <div class="col-md-6">
                                <select class="form-control select2bs4" style="width: 100%;" name="zone" id="zone">
                                    <option value="" selected>Select Employee Zone</option>
                                    <option value="North">North</option>
                                    <option value="East">East</option>
                                    <option value="South">South</option>
                                    <option value="West">West</option>

                                </select>

                                @if ($errors->has('zone'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('zone') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" autocomplete="new-password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" autocomplete="new-password" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection