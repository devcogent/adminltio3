@extends('frount.index')

@section('content')

    <?php $checkYes = 0; ?>
                        <section class="content">
                            <div class="container-fluid">
                              <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                   <div class="card card-info">
                                    <div class="card-header">
                                        <h5>CHANGE KEY</h5>
                                     </div>
                                     <div class="card-body">

                        <p>Note:- Once you proceed with <b>"change key"</b>, the system will generate a new key for your CRMs and log you out. You need to log back in to the system and then proceed with the <b>"key event."</b> The <b>"key event"</b> may take some time to start, depending on the amount of existing data.</p>


                            <div class="col-md-12" align="center">
                                <a class="btn btn-primary" href="{{ url('change-key') }}" onclick="return confirm('Are you sure?')" style="float: left;">Change Key</a>
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
