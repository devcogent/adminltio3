@extends('frount.index')
@section('content')
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
           <div class="card card-info">
            <div class="card-header">
                <h5>Manage Option <a href="{{route('crmmaster')}}" class="btn  btn-danger btn-sm float-right"> <i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;Go Back</a></h5>
             </div>
             <div class="card-body">

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        {{ csrf_field() }}
                        <div class="row">

                            <div class="col-md-1">
                                <label>Select Form </label>
                            </div>
                            <div class="form-group col-md-5">
                                <select class="form-control select2bs4 " style="width: 100%;" name="crmform" id="crmform">
                                    <option value="" selected>Select Form </option>
                                    @foreach($crmform as $st)
                                    <option value="{{$st->id}}">{{$st->form_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div id="process_status_list">
                        </div>
             </div>
           </div>
        </div>
      </div>
    </div>
</section>
</div>
</div>



<!-- /page content -->
<script>
    $("#crmform").change(function() {
        var crmform_id = $(this).val();
        $('#process_status_list').html('');
        $('#process_status_list').html('Please Wait <i class="fa fa-spinner fa-spin" style="font-size:30px"></i>');
        $.ajax({
            url: "{{route('getcrmFormfields')}}",
            type: 'POST',
            data: {
                "crmform_id": crmform_id,
                "_token": "{{ csrf_token() }}",
                "crm_name": "{{ $crm_name }}"
            },
            success: function(response) {
                if (response.status == 'success') {
                    $('#process_status_list').html(response.html);
                } else {
                    $('#process_status_list').html('No Data Found');
                }
            },
            error: function(response) {
                window.console.log(response);
            }
        });

    });
</script>



@endsection
