@extends('frount.index')
@section('content')
<?php $checkYes = 0; ?>
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
           <div class="card card-info">
            <div class="card-header">
                <h5>CTI PAGE :- {{ strtoupper($crmform[0]['form_name'])}}  <a href="{{route('crmmaster')}}" class="btn  btn-danger btn-sm float-right"> <i class="fa fa-arrow-circle-left" aria-hidden="true"></i> &nbsp;Go Back</a></h5>
             </div>
             <div class="card-body">
                  @php
                      $array = explode('_client_data', $crmform[0]['form_name']);
                  @endphp

                    <div class="jumbotron">
                        <h4 class="display-4">1. CTI LINK</h4>
                             Url:- <a href="{{ url($array[0].'/open-cti-page/'.$array[0].'_agent_input') }}?userid=user@123&{{ $remitUniqeFiled }}" target="_blank"> {{ url($array[0].'/open-cti-page/'.$array[0].'_agent_input') }}?userid=user@123&{{ $remitUniqeFiled }}  <a>

                    </div>
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
