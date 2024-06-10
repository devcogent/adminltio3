<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php

  if(!empty(Session::get('crm_logo'))) {
      $logo = Session::get('crm_logo');?>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/images/' . $logo) }}" />
    <?php
  }else {
      $logo = "cog.png";
      ?>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/images/' . $logo) }}" />
    <?php
  }
  ?>
    {{-- <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/images/'.$logo)}}" /> --}}
    <?php

    if (!empty(Session::get('crm_title'))) {
        $crm_title = Session::get('crm_title');
    } else {
        $crm_title = 'Cogent | O 3 CRM ';
    }
    ?>
    <title> {{ $crm_title }} </title>

    <!-- Bootstrap -->
    <link href="{{ asset('public/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('public/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset('public/vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- bootstrap-wysiwyg -->
    <link rel="stylesheet" href="{{ asset('public/plugins/toastr/toastr.min.css') }}">

    <!-- Custom styling plus plugins -->
    <link href="{{ asset('public/build/css/custom.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/select2.min.css') }}" rel="stylesheet">
    <!-- Datatables -->
    <script src="{{ asset('public/vendors/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('public/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <link href="{{ asset('public/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('public/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('public/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('public/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}"
        rel="stylesheet">

    <script src="{{ asset('public/vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('public/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/vendors/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('public/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/vendors/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('public/vendors/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('public/vendors/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('public/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ asset('public/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('public/vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('public/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js') }}"></script>
    <script src="{{ asset('public/vendors/datatables.net-scroller/js/dataTables.scroller.min.js') }}"></script>
    <script src="{{ asset('public/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('public/js/select2.min.js') }}"></script>
    <script src="{{ asset('public/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('public/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <!-- Datatables -->
    <script src="{{ asset('public/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('public/js/jszip.min.js') }}"></script>
    <script src="{{ asset('public/js/buttons.html5.min.js') }}"></script>
    <style>
        .error {
            color: red;
        }
    </style>

</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <center>
                        <div class="navbar nav_title" style="border: 0;"><br>
                            <a href="#" class=""><img id="logo_img"
                                    src="{{ asset('public/images/' . $logo) }}" height="75px" width="75%"></i>
                                <span></span></a></br>
                        </div>
                    </center>

                    <div class="clearfix"></div>
                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                        <div class="" align="center" style="background: #FFF;">
                            {{-- <img src="{{ asset('public/images/cog.png')}}" style="padding: 10px 30px;"> --}}

                            <div class="profile_info"><br><br>
                                <h2> <span
                                        style="text-align:center;color:#FFF !important;font-weight: bold;">O<sup>3</sup>
                                        CRM</span></h2>
                                <hr>
                                {{-- @if (Auth::user())
                 <b style="text-transform:uppercase"> {{ Auth::user()->emp_type }} </b>
			   @endif --}}
                            </div>
                        </div>

                    </div>
                    <!-- /menu profile quick info -->

                    <br />

