
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/images/'.$brand_data->logo_url)}}" />
  <title>{{ $brand_data->crm_title }} </title>

  <!-- Bootstrap -->
  <link href="{{ asset('public/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="{{ asset('public/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
  <!-- NProgress -->
  <link href="{{ asset('public/vendors/nprogress/nprogress.css')}}" rel="stylesheet">
  <!-- bootstrap-wysiwyg -->
  <link rel="stylesheet" href="{{ asset('public/plugins/toastr/toastr.min.css')}}">

  <!-- Custom styling plus plugins -->
  <link href="{{ asset('public/build/css/custom.min.css')}}" rel="stylesheet">
  <link href="{{ asset('public/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
  <link href="{{ asset('public/css/select2.min.css')}}" rel="stylesheet">
  <!-- Datatables -->
  <script src="{{ asset('public/vendors/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{ asset('public/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
  <link href="{{ asset('public/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{ asset('public/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{ asset('public/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{ asset('public/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{ asset('public/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">

  <script src="{{ asset('public/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
  <script src="{{ asset('public/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
  <script src="{{ asset('public/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
  <script src="{{ asset('public/vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
  <script src="{{ asset('public/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
  <script src="{{ asset('public/vendors/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
  <script src="{{ asset('public/vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
  <script src="{{ asset('public/vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
  <script src="{{ asset('public/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
  <script src="{{ asset('public/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
  <script src="{{ asset('public/vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
  <script src="{{ asset('public/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
  <script src="{{ asset('public/vendors/datatables.net-scroller/js/dataTables.scroller.min.js')}}"></script>
  <script src="{{ asset('public/plugins/toastr/toastr.min.js')}}"></script>
  <script src="{{ asset('public/js/select2.min.js')}}"></script>
  <script src="{{ asset('public/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
  <script src="{{ asset('public/plugins/jquery-validation/additional-methods.min.js')}}"></script>
   <!-- Datatables -->
    <script src="{{ asset('public/js/jquery.dataTables.min.js')}}"></script>
  <script src="{{ asset('public/js/dataTables.buttons.min.js')}}"></script>
  <script src="{{ asset('public/js/jszip.min.js')}}"></script>
  <script src="{{ asset('public/js/buttons.html5.min.js')}}"></script>
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
            <center><div class="navbar nav_title" style="border: 0;" ><br>
                <a href="#" class=""><img id="logo_img" src="{{ asset('public/images/'.$brand_data->logo_url)}}" height="75px" width="75%"></i> <span></span></a></br>
              </div></center>

              <div class="clearfix"></div>
              <!-- menu profile quick info -->
              <div class="profile clearfix">
                 <div class="" align="center" style="background: #FFF;">
                  {{-- <img src="{{ asset('public/images/cog.png')}}" style="padding: 10px 30px;"> --}}

                     <div class="profile_info"><br><br>
                  <h2> <span style="text-align:center;color:#FFF !important;font-weight: bold;">O<sup>3</sup> CRM</span>
                  </h2><br>
                    @if (Auth::user())
                   <b style="text-transform:uppercase"> {{ Auth::user()->emp_type }} </b>
                  @endif


                </div>
                </div>

              </div>


          <!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
	<div class="menu_section">
	</div>
</div>
<!-- /sidebar menu -->

<!-- /menu footer buttons -->
<div class="sidebar-footer hidden-small">

</div>
<!-- /menu footer buttons -->
</div>
</div>
<!-- top navigation -->
<div class="top_nav">
	<div class="nav_menu">
		<nav>
			<div class="nav toggle">
                <a id="menu_toggle" onclick="logoShift()"><i class="fa fa-bars"></i></a>
                <input type="hidden" id="togal_value" value='1'>
			</div>

			<ul class="nav navbar-nav navbar-right">
				<li class="">
					<a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        {{ $user_data->name }}
						{{-- {{ Auth::user()->name }} --}}
					</a>

				</li>
			</ul>
		</nav>
	</div>
</div>
<!-- /top navigation -->





<style>
    p {
        margin: 10px 0px 10px !important;
    }
</style>
<?php $checkYes = 0; ?>

<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-4" style="float: left;">
                <div class="x_panel">
                    Upload Data

                    <div class="x_title">
                    </div>
                    <table class="table table-striped table-bordered table" style="width:100%">
                        <tbody>
                        <?php
                        foreach ($agent_input_data as $key => $data) {

                            foreach ((array)$data as $k => $v) {

                                if ($k != "created_by") {
                                    echo ' <tr><td><b>' . strtoupper($k) . '</b></td>';
                                    echo ' <td>' . strtoupper($v) . '</td></tr>';
                                }else {
                                    break;
                                }
                            }
                        } ?>
                        </tbody>

                    </table>
                </div>
            </div>
            <div class="col-md-8 col-sm-8 col-xs-8" style="float: right;">
                <div class="x_panel">
                    Agent Input CTI

                    <div class="x_title">

                    </div>
                    <form role="form" id="quickForm" action="{{url(Request::segment(1).'/openSubmitAgentForm')}}" method="POST">
                        <div class="x_content">
                            <br>
                            <div class="row">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <input name="form_id" type="hidden" value="{{$crmform->id}}">
                                <input name="form_name" type="hidden" value="{{$crmform->form_name}}" />
                                <input name="from_data_id" type="hidden" value="{{$from_data_id}}" />
                                <input name="tid" type="hidden" value="{{$tid}}" />
                                <input name="created_by" type="hidden" value="{{ $user_data->id}}" />

                                @if(!empty($crm_fields))

								@php $counter=1;

                                @endphp
                                @php $get_audit_para=[]; @endphp
                                @foreach ( $crm_fields as $form_field )
                                @php
                                if($form_field->is_audit == 'yes'){
                                    $get_audit_para[] = $form_field->field_name;
                                }
                                @endphp
								@if($counter=="1")
									<div class="row" style="margin-bottom:15px">
								@elseif($counter>3)
							    <div class="row" style="margin-bottom:15px">
								@else
								@endif
                                <?php
                                switch ($form_field->field_type) {
                                    case "text": ?>
                                        <?php
                                            $get_hide = 'block';
                                            $required_filed = '';
                                            if (in_array($form_field->field_name, $row_child)){
                                                $get_hide = 'none';
                                            }
                                            if($get_hide == 'block' && $form_field->is_required == 'yes') {
                                                $required_filed = 'required=required';
                                            }
                                            $req = 'req=no';
                                            if($form_field->is_required) {
                                            $req = 'req=yes';
                                            }
                                        ?>
                                        <div class="col-md-4" style="display:{{ $get_hide }}" id="{{$form_field->field_name}}">
                                            <label style="text-transform: uppercase;">{{ $form_field->label_name }}</label>
                                            <input id="input_{{$form_field->field_name}}"
                                            @if($form_field->is_numaric=='yes')
                                             pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length=={{$form_field->length}} ) return false;"
                                             @endif
                                              minlength="{{$form_field->minlength}}" maxlength="{{$form_field->length}}" type="{{ ($form_field->is_numaric=='yes') ? 'number' : 'text' }}" placeholder="Enter {{$form_field->label_name}}" class="form-control" name="{{$form_field->field_name}}" {{ $required_filed }} {{ $req }} />
                                        </div>
                                    <?php break;

                                    case "mobile": ?>

                                        <?php
                                            $get_hide = 'block';
                                            $required_filed = '';
                                            if (in_array($form_field->field_name, $row_child)){
                                                $get_hide = 'none';
                                            }
                                            if($get_hide == 'block' && $form_field->is_required == 'yes') {
                                                $required_filed = 'required=required';
                                            }

                                            $req = 'req=no';
                                            if($form_field->is_required) {
                                            $req = 'req=yes';
                                            }
                                        ?>
                                        <div class="col-md-4" style="display:{{ $get_hide }}" id="{{$form_field->field_name}}">
                                            <label style="text-transform: uppercase;">{{$form_field->label_name}}</label>
                                           <input
                                           @if($form_field->field_type=='mobile')
                                             pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length=={{$form_field->length}} ) return false;"
                                             @endif
                                            min="1111111111" max="9999999999" type="number" placeholder="Enter {{$form_field->label_name}}" class="form-control" name="{{$form_field->field_name}}" {{ $required_filed }} {{ $req }} />
                                        </div>
                                    <?php break;

                                    case "email": ?>
                                        <?php
                                            $get_hide = 'block';
                                            $required_filed = '';
                                            if (in_array($form_field->field_name, $row_child)){
                                                $get_hide = 'none';
                                            }
                                            if($get_hide == 'block' && $form_field->is_required == 'yes') {
                                                $required_filed = 'required=required';
                                            }

                                            $req = 'req=no';
                                            if($form_field->is_required) {
                                                $req = 'req=yes';
                                            }
                                        ?>
                                        <div class="col-md-4" style="display:{{ $get_hide }}" id="{{$form_field->field_name}}">
                                            <label style="text-transform: uppercase;">{{$form_field->label_name}}</label>
                                           <input type="email" placeholder="Enter {{$form_field->label_name}}" class="form-control" name="{{$form_field->field_name}}" {{ $required_filed }} {{ $req }} />
                                        </div>
                                    <?php break;

                                    case "zip": ?>

                                            <?php
                                                $get_hide = 'block';
                                                $required_filed = '';
                                                if (in_array($form_field->field_name, $row_child)){
                                                    $get_hide = 'none';
                                                }
                                                if($get_hide == 'block' && $form_field->is_required == 'yes') {
                                                    $required_filed = 'required=required';
                                                }

                                                $req = 'req=no';
                                                if($form_field->is_required) {
                                                $req = 'req=yes';
                                                }
                                            ?>
                                            <div class="col-md-4" style="display:{{ $get_hide }}" id="{{$form_field->field_name}}">
                                            <label style="text-transform: uppercase;">{{$form_field->label_name}}</label>
                                           <input
                                           @if($form_field->field_type=='zip')
                                             pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length=={{$form_field->length}} ) return false;"
                                             @endif
                                            type="number" min="100000" max="999999" type="" placeholder="Enter {{$form_field->label_name}}" class="form-control" name="{{$form_field->field_name}}" {{ $required_filed }} {{ $req }} />
                                        </div>
                                    <?php break;



                                    case "text_area": ?>
                                        <?php
                                            $get_hide = 'block';
                                            $required_filed = '';
                                            if (in_array($form_field->field_name, $row_child)){
                                                $get_hide = 'none';
                                            }
                                            if($get_hide == 'block' && $form_field->is_required == 'yes') {
                                                $required_filed = 'required=required';
                                            }
                                            $req = 'req=no';
                                            if($form_field->is_required) {
                                                $req = 'req=yes';
                                            }
                                        ?>
                                        <div class="col-md-4" style="display:{{ $get_hide }}" id="{{$form_field->field_name}}">
                                            <label style="text-transform: uppercase;">{{$form_field->label_name}}</label>

                                            <textarea minlength="{{$form_field->minlength}}" maxlength="{{$form_field->length}}" class="form-control" placeholder="Enter {{$form_field->label_name}}" name="{{$form_field->field_name}}" {{ $required_filed }} {{ $req }} }}></textarea>
                                        </div>
                                    <?php break;
                                    case "drop_down": ?>

                                            <?php
                                            $get_hide = 'block';
                                            $required_filed = '';
                                            if (in_array($form_field->field_name, $row_child)){
                                                $get_hide = 'none';
                                            }
                                            if($get_hide == 'block' && $form_field->is_required == 'yes') {
                                                $required_filed = 'required=required';
                                            }

                                            $req = 'req=no';
                                            if($form_field->is_required) {
                                            $req = 'req=yes';
                                            }
                                            ?>

                                            <?php
                                            $get_function = '';
                                            $all_child_name = '';
                                            if (in_array($form_field->field_name, $row_parent)) {
                                                $get_child = App\Models\crmFieldDependencie::where('crm_id', $crmform->id)->where('dropdown_id',$form_field->field_name)->get();
                                                foreach ($get_child as $get_child_keys => $get_child_rows) {
                                                    $get_function .= "; getChildShow(this.value,'".$get_child_rows->option_id."','".$get_child_rows->dropdown_id_from."')";
                                                    $all_child_name .= $get_child_rows->dropdown_id_from.',';
                                                }
                                            }
                                            ?>
                                            <div class="col-md-4 qwerty_1" style="display:{{ $get_hide }}" id="{{$form_field->field_name}}">
                                            <label style="text-transform: uppercase;">{{$form_field->label_name}}</label>
                                            <?php $filedsoptions = App\Models\CrmFormFieldOption::where('crm_filed_id', $form_field->id)->get();
                                               //dd( $filedsoptions);
                                            ?>
                                            <select onchange="getParent(this.value, {{$form_field->id}}){{$get_function}}" class="form-control select2bs4" style="width: 100%;" id="field_type_{{$form_field->id}}"  fieldcounter=0 name="{{$form_field->field_name}}" {{ $required_filed }} my_child="{{ $all_child_name }}" "{{ $req }}">

                                                <option value="">Select {{$form_field->label_name}}</option>
                                                <?php if($form_field->field_depend == '' || $form_field->field_depend == 'null') { ?>
                                                    <?php
                                                 foreach ($filedsoptions as $options) { ?>
                                                    <option value="{{$options->options}}" onchange="getParent('{{$options->options}}', '{{$options->crm_filed_id}}' )" id="{{$options->crm_filed_id}}" >{{$options->options}}</option>
                                                <?php } } ?>



                                            </select>
                                        </div>
                                    <?php break;
                                    case "check_box": ?>

                                            <?php
                                            $get_hide = 'block';
                                            $required_filed = '';
                                            if (in_array($form_field->field_name, $row_child)){
                                                $get_hide = 'none';
                                            }
                                            if($get_hide == 'block' && $form_field->is_required == 'yes') {
                                                $required_filed = 'required=required';
                                            }
                                            $req = 'req=no';
                                            if($form_field->is_required) {
                                            $req = 'req=yes';
                                            }
                                            ?>
                                            <div class="col-md-4" style="display:{{ $get_hide }}" id="{{$form_field->field_name}}">
                                            <label style="text-transform: uppercase;">{{$form_field->label_name}}</label>
                                            <?php $filedsoptions = App\Models\CrmFormFieldOption::where('crm_filed_id', $form_field->id)->get();
                                            if ($form_field->is_required == 'yes') {
                                                $checkYes = 1;
                                            } else {
                                                $checkYes = 0;
                                            }
                                            ?>

                                            <p style="padding: 5px;">
                                                <?php foreach ($filedsoptions as $options) { ?>
                                                    <input type="checkbox" name="{{$form_field->field_name}}[]" value="{{$options->options}}" data-parsley-mincheck="2" class="flat" {{ $required_filed }} {{ $req }}> {{$options->options}}
                                                <?php } ?>
                                            </p>
                                        </div>
                                    <?php break;
                                    case "radio_button": ?>

                                            <?php
                                            $get_hide = 'block';
                                            $required_filed = '';
                                            if (in_array($form_field->field_name, $row_child)){
                                                $get_hide = 'none';
                                            }
                                            if($get_hide == 'block' && $form_field->is_required == 'yes') {
                                                $required_filed = 'required=required';
                                            }
                                            $req = 'req=no';
                                            if($form_field->is_required) {
                                            $req = 'req=yes';
                                            }

                                            $get_function = '';
                                            $all_child_name = '';
                                            if (in_array($form_field->field_name, $row_parent)) {
                                            $get_child = App\Models\crmFieldDependencie::where('crm_id', $crmform->id)->where('dropdown_id',$form_field->field_name)->get();
                                            foreach ($get_child as $get_child_keys => $get_child_rows) {
                                                $get_function .= "getChildShow(this.value,'".$get_child_rows->option_id."','".$get_child_rows->dropdown_id_from."');";
                                                $all_child_name .= $get_child_rows->dropdown_id_from.',';
                                            }
                                            }
                                            ?>

                                        <?php $filedsoptions = App\Models\CrmFormFieldOption::where('crm_filed_id', $form_field->id)->get();
                                        ?>
                                        <div class="col-md-4" style="display:{{ $get_hide }}" id="{{$form_field->field_name}}">
                                            <label style="text-transform: uppercase;">{{$form_field->label_name}}</label>

                                            <p>
                                                <?php foreach ($filedsoptions as $options) { ?>
                                                    {{$options->options}}:
                                                    <input type="radio" class="flat form-control" {{ ($form_field->is_required=='yes') ? 'required' : '' }} name="{{$form_field->field_name}}" value="{{$options->options}}" {{ $req }} onclick="{{ $get_function }}" my_child={{ $all_child_name }}>
                                                <?php } ?>
                                            </p>
                                        </div>
                                    <?php break;
                                    case "date_picker":

                                    $maxlen = $form_field->length;
                                    $minlen = $form_field->minlength;

                                    $max = $min = '';

                                    if($maxlen!='-1' ){

                                        $max = date('Y-m-d',strtotime("+".$maxlen." days"));
                                    }
                                    if($minlen!='-1' ){

                                        $min = date('Y-m-d',strtotime("-".$minlen." days"));
                                    }

                                    ?>
                                        <div class="col-md-4">
                                            <label style="text-transform: uppercase;">{{$form_field->label_name}}</label>
                                            <input id="datefield" min='{{$min}}' max='{{$max}}' type="date" placeholder="Enter {{$form_field->label_name}}" class="form-control" name="{{$form_field->field_name}}" {{ ($form_field->is_required=='yes') ? 'required' : '' }}>

                                        </div>
                                <?php break;
                                    default:
                                        echo "nothing";
                                }

                                ?>
								@if($counter==3)
                                @php  $counter=0;	@endphp
							    </div>

								@endif

							@php $counter++; @endphp
                                @endforeach
                                @else
                                <h2 align="center"><span class="label label-danger">No crm Mapped!</span></h2>
                                @endif


                            </div>
                            <div class="row" align="center"></br>
                                <div class="col-md-8 col-sm-8 col-xs-8 form-group">
                                    <button type="submit" class="btn btn-success " counter=0>Save </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <button id="get_history" class="btn btn-light">History</button>

    @if(!empty($crm_input_history) && isset($crm_input_history[0]))

    <div class="row" id="togal_class" style="display: none">

        <div class="col-md-12 col-sm-12 col-xs-12">
            {{-- <h5>History</h5> --}}
            <div class="x_panel">
    <table class="table" id="myTable">
        <thead class="thead-light">
          <tr>
              @foreach ( json_decode($crm_input_history[0]->data) as $find_data_keys => $find_data_rows)
                    @foreach ( $find_data_rows as $remit_header_keys => $remit_header_rows)
                        @if ($remit_header_keys != 'audit_trail')
                          <th scope="col">{{ ucwords(str_replace("_"," ",$remit_header_keys)) }}</th>
                        @endif
                        @if ($remit_header_keys == 'audit_trail')
                          @foreach ($remit_header_rows as $audit_trail_header_keys =>  $audit_trail_header_rows  )
                          @if (in_array($audit_trail_header_keys,$get_audit_para))
                              <th scope="col">{{ ucwords(str_replace("_"," ",$audit_trail_header_keys)) }}</th>
                          @endif
                          @endforeach
                        @endif
                    @endforeach
              @endforeach
          </tr>
        </thead>
        <tbody>
            @foreach ( $crm_input_history as $rows_data )
            <tr>
               @foreach ( json_decode($rows_data->data) as $find_data_rows)
                    @foreach ( $find_data_rows as $remit_header_keys => $remit_header_rows)
                        @if ($remit_header_keys != 'audit_trail')
                            <td >{{ $remit_header_rows }}</td>
                        @endif
                        @if ($remit_header_keys == 'audit_trail')
                          @foreach ($remit_header_rows as $audit_trail_header_keys =>  $audit_trail_header_rows  )
                            @if (in_array($audit_trail_header_keys,$get_audit_para))
                                <td>{{ $audit_trail_header_rows }}</td>
                            @endif
                        @endforeach
                      @endif
                    @endforeach
                @endforeach
            </tr>
            @endforeach
        </tbody>
      </table>
    </div></div></div>
      @else
      <h2>No! history Found<h2>
     @endif

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


<script type="text/javascript">


function getChildShow(parent_current_value,parent_fixed_value,child_id) {

if(parent_current_value == parent_fixed_value) {

   $(`#${child_id}`).show(300);
   req_child = $(`#${child_id}`).children().eq(1).attr('req');

   if(req_child == 'yes'){
      $(`#${child_id}`).children().eq(1).attr('required','required');
   }

} else {

   all_child = $(`#${child_id}`).children().eq(1).attr('my_child');
   $(`#${child_id}`).hide(300);
   $(`#${child_id}`).children().eq(1).removeAttr('required');
   $(`#${child_id}`).children().eq(1).val("");

   if(all_child && all_child != '') {
       var all_child_array = all_child.split(',');
       for(i=0; i<all_child_array.length; i++) {
               $(`#${all_child_array[i]}`).hide(300);
               $(`#${all_child_array[i]}`).children().eq(1).removeAttr('required');
               $(`#${all_child_array[i]}`).children().eq(1).val("");

               var all_child_second = $(`#${all_child_array[i]}`).children().eq(1).attr('my_child');

               if(all_child_second && all_child_second != '') {
                   var all_child_array_second = all_child_second.split(',');
                   for(j=0; j<all_child_array_second.length; j++) {
                          $(`#${all_child_array_second[j]}`).hide(300);
                          $(`#${all_child_array_second[j]}`).children().eq(1).removeAttr('required');
                          $(`#${all_child_array_second[j]}`).children().eq(1).val("");

                          var all_child_third = $(`#${all_child_array_second[j]}`).children().eq(1).attr('my_child');

                          if(all_child_third && all_child_third != '') {
                               var all_child_array_third = all_child_third.split(',');
                               for(k=0; k<all_child_array_third.length; k++) {
                                       $(`#${all_child_array_third[k]}`).hide(300);
                                       $(`#${all_child_array_third[k]}`).children().eq(1).removeAttr('required');
                                       $(`#${all_child_array_third[k]}`).children().eq(1).val("");

                                       var all_child_fourt = $(`#${all_child_array_third[k]}`).children().eq(1).attr('my_child');
                                       if(all_child_fourt && all_child_fourt != '') {

                                           var all_child_array_fourt = all_child_fourt.split(',');
                                           for(l=0; l<all_child_array_fourt.length; l++) {
                                                   $(`#${all_child_array_fourt[l]}`).hide(300);
                                                   $(`#${all_child_array_fourt[l]}`).children().eq(1).removeAttr('required');
                                                   $(`#${all_child_array_fourt[l]}`).children().eq(1).val("");

                                                   var all_child_five = $(`#${all_child_array_fourt[l]}`).children().eq(1).attr('my_child');
                                                   if(all_child_five && all_child_five != '') {

                                                       var all_child_array_five = all_child_five.split(',');
                                                       for(m=0; m<all_child_array_five.length; m++) {
                                                               $(`#${all_child_array_five[m]}`).hide(300);
                                                               $(`#${all_child_array_five[m]}`).children().eq(1).removeAttr('required');
                                                               $(`#${all_child_array_five[m]}`).children().eq(1).val("");

                                                           }

                                                   }
                                               }

                                        }
                                   }
                            }
                     }
               }
          }
    }
}

}




</script>


<script>


 const getParent = (parent_name, crm_filed_id) => {

        var selected = $(".qwerty_1").children("select").length;
        counter = parseInt($(this).attr("counter"))
        newcount = counter + 1
        $(this).attr("counter", newcount)

    $.ajax({
            url: "{{route('openAddChildField')}}",
            type: 'POST',
            data: {
                "counter": counter,
                "parent_name": parent_name,
                "form_name": "{{$crmform->form_name}}",
                "crm_filed_id" : crm_filed_id,
                "_token": "{{ csrf_token() }}",
            },
            success: function(response) {

               if (response.status == 'success') {
                    var obj = JSON.stringify(response.html);
                    var qwe = JSON.parse(obj);

                    var a = new Array();
                     $(`#field_type_${qwe[0]['crm_filed_id']}`).children("option").each(function(x){
                     test = false;
                     b = a[x] = $(this).val();
                     for (j=0;j<a.length;j++){
                     if (b ==a[j]) test =true;
                     }
                     if (test) $(this).remove();
                     });


                    if(response.child == 'success') {
                        var state_data1 = `<option value=''>--select--</option>`;
                    for (let i = 0; i < qwe.length; i++) {
                        if(i < 1) {
                          state_data = state_data1.concat(`<option value="${qwe[i]['options']}">${qwe[i]['options']}</option>`);
                        }else {
                           state_data =  `<option value="${qwe[i]['options']}">${qwe[i]['options']}</option>`;
                        }

                        //  let state_data = `<option value="${qwe[i]['options']}">${qwe[i]['options']}</option>`;
                         $(`#field_type_${qwe[0]['crm_filed_id']}`).append(state_data);
                   }
                    }else {
                         $(`#field_type_${qwe[0]['id']}`).empty();
                    }
                } else {
                 alert("Somtning went Wrong !")
                }
            },
            error: function(response) {
                window.console.log(response);
            }
        });

 }


</script>

 <!-- Begin Footer Area -->

 <div class="modal fade bs-example-modal" id="changepassword" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" align="center" style="width:60%;margin-left: 23%;">
        <div class="modal-header">
          <h4 class="modal-title">Change Password</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" id="chnageForm" name="chnageForm" action="{{route('updatePassword')}}">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          {{-- <input type="hidden" name="emp_id" value="{{ Auth::user()->emp_id }}"> --}}
          <div class="form-group row">

            </br>
            <div class="form-group" align="center">
              <label for="new_password" class="col-md-4 col-form-label">{{ __('New password') }}</label>
              <input id="new_password" name="new_password" type="password" class="form-control changepassword" required autofocus style="width: 50%;">
              @if ($errors->has('new_password'))
              <span class="help-block error invalid-feedback">
                <strong>{{ $errors->first('new_password') }}</strong>
              </span>
              @endif
            </div>
          </div>
          <div class="form-group row">


            <div class="form-group" align="center">
              <label for="password_confirm" class="col-md-4 col-form-label">{{ __('Confirm password') }}</label>

              <input id="password_confirm" name="password_confirm" type="password" class="form-control changepassword" required autofocus style="width: 50%;">
              @if ($errors->has('password_confirm'))
              <span class="help-block error invalid-feedback">
                <strong>{{ $errors->first('password_confirm') }}</strong>
              </span>
              @endif
            </div>
          </div>
          </hr>
          <div class="form-group login-row row mb-0" align="center">
            <div class="col-md-12">

              <input type="submit" name="submit" value="Submit" class="btn btn-primary" style="margin-bottom:20px" />
            </div><br>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <div class="footer-area" data-bg-image="{{ asset('public/assets/images/footer/bg/1-1920x465.jpg')}}">

    <!-- footer content -->
    <footer>
      <div class="pull-right">
       {!! $brand_data->footer_text  !!}
      </div>
      <div class="clearfix"></div>
    </footer>
    <!-- /footer content -->
  </div>
  </div>

  <script>
    function logoShift(){
        togal_value = $('#togal_value').val();
        old_width = $('img').attr("width");
        old_height = $('img').attr("height");
        if(togal_value == '1'){
            $('#togal_value').val('0');
        }else {
            $('#togal_value').val('1');
        }
        togal_value = $('#togal_value').val();
        console.log(togal_value);
        if(togal_value == 0) {
           $('#logo_img').attr("width","50");
           $('#logo_img').attr("height","50");
        }
        else{
           console.log(old_width,old_height);
           $('#logo_img').attr("width",`73%`);
           $('#logo_img').attr("height",`73`);
        }
    }
</script>

  <script>
    $(document).ready(function(){
$("#get_history").click(function(){
    $("#togal_class").toggle(300);
  });
});
$(document).ready( function () {

    $('#myTable').DataTable();

} );

  </script>

  <!-- jQuery -->

  <!-- Bootstrap -->
  <script src="{{ asset('public/vendors/bootstrap/dist/js/bootstrap.min.js')}}"></script>
  <!-- FastClick -->
  <script src="{{ asset('public/vendors/fastclick/lib/fastclick.js')}}"></script>
  <!-- NProgress -->
  <script src="{{ asset('public/vendors/nprogress/nprogress.js')}}"></script>
  <!-- Chart.js -->

  <!-- bootstrap-progressbar -->
  <script src="{{ asset('public/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js')}}"></script>
  <!-- iCheck -->
  <script src="{{ asset('public/vendors/iCheck/icheck.min.js')}}"></script>
  <!-- Skycons -->
  <script src="{{ asset('public/vendors/skycons/skycons.js')}}"></script>
  <!-- Flot -->
  <script src="{{ asset('public/vendors/Flot/jquery.flot.js')}}"></script>
  <script src="{{ asset('public/vendors/Flot/jquery.flot.pie.js')}}"></script>
  <script src="{{ asset('public/vendors/Flot/jquery.flot.time.js')}}"></script>
  <script src="{{ asset('public/vendors/Flot/jquery.flot.stack.js')}}"></script>
  <script src="{{ asset('public/vendors/Flot/jquery.flot.resize.js')}}"></script>
  <!-- Flot plugins -->

  <!-- DateJS -->
  <script src="{{ asset('public/vendors/DateJS/build/date.js')}}"></script>

  <!-- bootstrap-daterangepicker -->
  <script src="{{ asset('public/vendors/moment/min/moment.min.js')}}"></script>

  <!-- Custom Theme Scripts -->
  <script src="{{ asset('public/build/js/custom.min.js')}}"></script>
  @if ($message = Session::get('success'))
  <script>
    toastr.success('{{ $message }}')
  </script>
  @endif
  @if ($message = Session::get('error'))
  <script>
    toastr.error('{{ $message }}')
  </script>
  @endif

 <script>
 $('#datatable1').dataTable({
     dom: 'Bfrtip',
     buttons: [
       'excelHtml5',
     ],
     "scrollX": true
     //scrollX: 300,
     //responsive: true,

   });
 </Script>
  </body>

  </html>
