@extends('frount.index')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h5>Edit Details <a href="{{ route('users') }}" class="btn  btn-danger btn-sm float-right"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;Go Back</a></h5>
                    </div>
                    <div class="card-body">
                            <form role="form" id="quickForm" action="{{route('users.update')}}" method="POST">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="id" value="{{ $users->id  }}">
                                <input type="hidden" name="db" value="{{ $db }}">

                                <div class="row">
                                    <div class="col-md-6 col-xl-6 col-sm-6 col-lg-6">
                                    <div class="form-group{{ $errors->has('emp_id') ? ' has-error' : '' }}">
                                        <label for="emp_id" class="control-label">User Id</label>
                                         <input id="emp_id" type="text" class="form-control" name="emp_id" value="{{ $users->emp_id }}" required autofocus>
                                            @if ($errors->has('emp_id'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('emp_id') }}</strong>
                                            </span>
                                            @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label for="name" class="control-label">Name</label>
                                            <input id="name" type="name" class="form-control" name="name" value="{{ $users->name }}" required>
                                            @if ($errors->has('name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                            @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label for="email" class="control-label">E-Mail Address</label>
                                         <input id="email" type="email" class="form-control" name="email" value="{{ $users->email }}" required>
                                           @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                            @endif
                                    </div>
                                </div>
                                    <div class="col-md-6 col-xl-6 col-sm-6 col-lg-6">
                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <label for="password" class="control-label">Password</label>
                                           <input id="password" type="password" autocomplete="new-password" class="form-control" name="password" placeholder="Password (Leave Blank For old password )">
                                           @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                            @endif
                                     </div>

                                    @php $type = Auth::user()->emp_type; @endphp

                                    @if ($type == "super_admin")
                                    <div class="form-group{{ $errors->has('crm_limit') ? ' has-error' : '' }}">
                                        <label for="crm_limit" class="control-label">CRM Limit</label>
                                           <input id="crm_limit" type="number" autocomplete="crm_limit" class="form-control" name="crm_limit" value="{{ $users->crm_limit }}" required placeholder="Enter CRM Limit">
                                            @if ($errors->has('crm_limit'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('crm_limit') }}</strong>
                                            </span>
                                            @endif
                                    </div>
                                    @endif

                                    @if ($type == "admin")
                                        <div class="form-group">
                                            <label for="user_access" class="control-label">Edit access</label>
                                            @php
                                                $is_access = '';
                                                $not_access = '';
                                            @endphp
                                                @if($users->user_access == 1)
                                                @php $is_access = 'selected';@endphp
                                                @endif
                                                @if($users->user_access == 0 || $users->user_access == null )
                                                @end  $not_access = 'selected'; @endphp
                                                @endif
                                               <select id="user_access" name="user_access" class="form-control">
                                                   <option value="1" {{ $is_access }}>Yes</option>
                                                   <option value="0" {{ $not_access }}>No</option>
                                                </select>
                                        </div>
                                       @endif



                                    @if($type == "super_admin")
                                        <input type="hidden" id="emp_type" tabindex="17" name="emp_type" value="admin" checked data-field="admin" class="chk">
                                        <input type="hidden" value="1" name="user_access">
                                    @else
                                        <div class="form-group">
                                            <label for="Role" class="control-label">Employe Type</label>
                                            <div class="form-group">
                                                <input type="radio" id="emp_type" tabindex="17" name="emp_type" value="agent" <?php if ($users->emp_type == "agent") echo 'checked="checked"'; ?> checked data-field="Agent" class="chk"> Agent
                                            </div>
                                            <div class="form-group">
                                                <input type="radio" id="emp_type" tabindex="17" name="emp_type" value="supervisor" <?php if ($users->emp_type == "supervisor") echo 'checked="checked"'; ?> data-field="supervisor" class="chk"> Supervisor
                                            </div>

                                        </div>

                                    @endif
                                    </div>
                                    <div class="form-group">

                                        <div class="col-md-12" align="center">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </div>
                        </div>

                        </form>
                    </div>


                </div>
            </div>
        </div>
    </div>
</section>
</div>
</div>

@endsection
