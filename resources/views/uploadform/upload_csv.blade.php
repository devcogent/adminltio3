@extends('frount.index')

@section('content')
<?php $checkYes = 0; ?>
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
           <div class="card card-info">
            <div class="card-header">
                <h5>{{strtoupper($crmform->form_name)}}  <a href="{{route('crmmaster')}}" class="btn  btn-danger btn-sm float-right"> <i class="fa fa-arrow-circle-left" aria-hidden="true"></i> &nbsp;Go Back</a></h5>
             </div>
             <div class="card-body">
                    <form role="form" id="quickForm" action="{{url('upload-csv')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <input class="form-control" type="file" name="uplaod_file" required>
                            </div>

                            <div class="col-md-4">
                                <button type="button" class="btn btn-info" style="float: right;"> <a  href="{{url('download-csv/'.$crmform->form_name)}}" style="color:white"><i class="fa fa-download" aria-hidden="true"></i>&nbsp; Download Sample</a></button>
                            </div>


                        </div>

                        <input type="hidden" name="table_name" value="{{ $crmform->form_name }}">
                        <button type="submit" class="btn btn-success mt-3" counter=0>Upload File</button>

                    </form>
              </div>
            </div>
        </div>
    </div>

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
