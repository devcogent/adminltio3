@extends('frount.index')
@section('content')
<?php $checkYes = 0; ?>
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="card card-info">
                                <div class="card-header">
                                    <h5>KEY EVENT PROCESSING</h5>
                                </div>
                            <div class="card-body">

                        <p>Note:- Key Event will take few minutes to restore the newly generated key.</p>

                            <div class="col-md-12" align="center">
                                <a class="btn btn-primary" href="{{ url('get-backup') }}" onclick="return confirm('Are you sure?')" style="float: left;"> Continue To Restore Key</a>
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
