@extends('frount.index')

@section('content')
<!-- Main content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>
        <!-- top tiles -->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Edit Category <small></small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <form role="form" id="quickForm" action="{{route('crmmaster.update')}}" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="{{ $crm_masters->id  }}">
                            <div class="card-body">


                                <div class="form-group{{ $errors->has('crm_name') ? ' has-error' : '' }}">
                                    <label for="crm_name" class="col-md-8 control-label">CRM Name</label>

                                    <div class="col-md-6">
                                        <input id="crm_name" type="text" class="form-control" name="crm_name" value="{{ $crm_masters->crm_name }}" required autofocus>

                                        @if ($errors->has('crm_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('crm_name') }}</strong>
                                        </span>
                                        @endif</br>
                                    </div>
                                </div>


                                <div class="form-group">

                                    <div class="col-md-6" align="center">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">

                    </div>
                    </form>

                </div>
            </div>
        </div>
    </div>





</div>

</div>
<!-- /page content -->
@endsection
