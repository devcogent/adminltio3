@extends('frount.index')
@section('content')
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
           <div class="card card-info">
            <div class="card-header">
                <h5>CRM List  <a href="{{url('crm-master')}}" class="btn  btn-danger btn-sm float-right"> <i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp; Go Back</a></h5>
             </div>
            <div class="card-body">
                        <form role="form" id="quickForm" action="{{route('crmmaster.create')}}" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-lg-6">
                                            <label for="crm_name" class="control-label">CRM Name</label>
                                            <input id="crm_name" type="text" class="form-control" name="crm_name" value="{{ old('crm_name') }}" autofocus placeholder="Enter CRM name">
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-lg-6">
                                            <label for="crm_name" class="control-label">CRM Type</label>
                                            <select class="form-control" name="crm_type">
                                                <option value="">Select CRM Type</option>
                                                <option value="1">Client data</option>
                                                <option value="2">Agent input</option>
                                            </select>
                                            @if ($errors->has('crm_name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('crm_name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary add-submit mt-4">Submit</button>
                            </form>
            </div>
           </div>
        </div>
      </div>
    </div>
</div>
</div>
</div>
</section>
<script>
$(function(){
  $('#quickForm').validate({
    rules: {
      crm_type: {
        required: true,
      },
      crm_name: {
        required: true,
      },
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
@endsection





