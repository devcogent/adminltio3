@extends('frount.index')
@section('content')
    <?php $checkYes = 0; ?>
                        <section class="content">
                            <div class="container-fluid">
                              <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                   <div class="card card-info">
                                    <div class="card-header">
                                        <h5>{{strtoupper($crmform->form_name)}}</h5>
                                     </div>
                                     <div class="card-body">



                        <form role="form" id="quickForm" action="{{ url(explode('_client_data', $crmform->form_name)[0].'/upload-csv-agent-submit') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                                <div class="row">
                                    <div class="col-md-4 col-sm-4 col-lg-4">
                                        <input class="form-control" type="file" name="uplaod_file" required>
                                        <input type="hidden" name="table_name" value="{{ $crmform->form_name }}">
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-lg-4">
                                        <button type="submit" class="btn btn-success float-left" counter=0><i class="fa fa-upload" aria-hidden="true"></i>&nbsp;Upload</button>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-lg-4">
@php $crmname =  Request::segment(1) @endphp
                                        <button type="button" class="btn btn-info float-left"> <a
                                            href="{{ url($crmname.'/download-csv/' . $crmform->form_name) }}" style="color:white"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;Download
                                            Format</a></button>
                                    </div>







                            </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
                        </section>

    </div>
    </div>
    <!-- /page content -->
    <?php if ($checkYes == 1) { ?>
    <script type="text/javascript">
        $('#quickForm').on('submit', function() {
            checked = $("input[type=checkbox]:checked").length;
            if (!checked) {

                alert("You must check at least one checkbox.");
                return false;
            }


        });
    </script>
    <?php } ?>
@endsection
