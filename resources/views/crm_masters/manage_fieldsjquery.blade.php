@extends('frount.index')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script src="{{ asset('public/js/form-builder/form-builder.min.js')}}"></script>
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>
        <!-- top tiles -->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Manage {{$crm_masters->crm_name}}CRM <small></small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <form role="form" id="quickForm" action="{{route('crmmaster.create')}}" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="card-body">

                                <div id="build-wrap" class="form-wrapper-div"></div>


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

</div>
<!-- /page content -->
<script>
    $(function() {
        $('#build-wrap').formBuilder();
    });
</script>
@endsection