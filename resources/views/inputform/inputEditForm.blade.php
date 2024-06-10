@extends('frount.index')

@section('content')
<style>
    p {
        margin: 10px 0px 10px !important;
    }
</style>
<?php $checkYes = 0; ?>
                    <section class="content">
                        <div class="container-fluid">
                          <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                               <div class="card card-info">
                                <div class="card-header">
                                    <h5>{{strtoupper($crmform->form_name)}}  <a href="{{ redirect()->back()->getTargetUrl() }}" class="btn  btn-danger btn-sm float-right"> <i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp; Go Back</a></h5>
                                 </div>
                                <div class="card-body">
                     <form role="form" id="quickForm" action="{{url(Request::segment(1).'/editAgentForm')}}" method="POST">

                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <input name="form_id" type="hidden" value="{{$crmform->id}}">
                                <input name="form_name" type="hidden" value="{{$crmform->form_name}}" />
                                <input name="created_by" type="hidden" value="{{ Auth::id()}}" />
                                <input name="field_id" type="hidden" value="{{ $id }}" />

                                @if(!empty($crm_fields))
								@php $counter=1; @endphp
								@php $get_audit_para=[]; @endphp
                                @foreach ( $crm_fields as $form_field )
                                @php
                                if($form_field->is_audit == 'yes'){
                                    $get_audit_para[] = $form_field->field_name;
                                }
                                @endphp
								@if($counter == 1)
									<div class="row" style="margin-bottom:15px">
								@elseif($counter>3)
							    <div class="row" style="margin-bottom:15px">
								@else
								@endif
                                <?php
                                switch ($form_field->field_type) {
                                    case "text":

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
                                    $txtName = $form_field->field_name;

                                     ?>
                                        <div class="col-md-4" style="display:{{ $get_hide }}" id="{{$form_field->field_name}}">
                                            <label style="text-transform: uppercase;">{{ $form_field->label_name }}</label>
                                            <input
                                            @if($form_field->is_numaric=='yes')
                                             pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length=={{$form_field->length}}) return false;"
                                             @endif
                                            minlength="{{$form_field->minlength}}" maxlength="{{$form_field->length}}" type="{{ ($form_field->is_numaric=='yes') ? 'number' : 'text' }}" placeholder="Enter {{$form_field->label_name}}" class="form-control" value="{{$finalDatas[0]->$txtName}}" name="{{$form_field->field_name}}" {{ $required_filed }} {{ $req }} />
                                        </div>
                                    <?php break;

                                    case "mobile":

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

                                    $mobileName = $form_field->field_name;

                                     ?>
                                        <div class="col-md-4" style="display:{{ $get_hide }}" id="{{$form_field->field_name}}">
                                            <label style="text-transform: uppercase;">{{$form_field->label_name}}</label>
                                           <input
                                           @if($form_field->field_type=='mobile')
                                             pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length=={{$form_field->length}} ) return false;"
                                             @endif
                                            min="1111111111" max="9999999999" type="number" placeholder="Enter {{$form_field->label_name}}" class="form-control" value="{{$finalDatas[0]->$mobileName}}"name="{{$form_field->field_name}}" {{ $required_filed }} {{ $req }} />
                                        </div>
                                    <?php break;

                                    case "email":
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

                                    $emailName = $form_field->field_name;

                                    ?>
                                        <div class="col-md-4" style="display:{{ $get_hide }}" id="{{$form_field->field_name}}">
                                            <label style="text-transform: uppercase;">{{$form_field->label_name}}</label>
                                           <input type="email" placeholder="Enter {{$form_field->label_name}}" class="form-control" name="{{$form_field->field_name}}" {{ $required_filed }} {{ $req }} value="{{$finalDatas[0]->$emailName}}" />
                                        </div>
                                    <?php break;

                                    case "zip":
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

                                    $zipName = $form_field->field_name;
                                    ?>
                                        <div class="col-md-4" style="display:{{ $get_hide }}" id="{{$form_field->field_name}}">
                                            <label style="text-transform: uppercase;">{{$form_field->label_name}}</label>
                                           <input
                                           @if($form_field->field_type=='zip')
                                             pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length=={{$form_field->length}} ) return false;"
                                             @endif
                                            type="number" min="100000" max="999999" type="" placeholder="Enter {{$form_field->label_name}}" class="form-control" name="{{$form_field->field_name}}"  {{ $required_filed }} {{ $req }} value="{{$finalDatas[0]->$zipName}}"/>
                                        </div>
                                    <?php break;


                                    case "text_area":
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

                                        $txaraName = $form_field->field_name;
                                      ?>
                                        <div class="col-md-4" style="display:{{ $get_hide }}" id="{{$form_field->field_name}}">
                                            <label style="text-transform: uppercase;">{{$form_field->label_name}}</label>

                                            <textarea class="form-control" placeholder="Enter {{$form_field->label_name}}" name="{{$form_field->field_name}}"  {{ $required_filed }} {{ $req }}>{{$finalDatas[0]->$txaraName}}
                                            </textarea>
                                        </div>
                                    <?php break;
                                    case "drop_down":
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
                                                    $get_function .= "; getChildShow(this.value,'".$get_child_rows->option_id."','".$get_child_rows->dropdown_id_from."')";
                                                    $all_child_name .= $get_child_rows->dropdown_id_from.',';
                                                }
                                            }
                                        ?>
                                        <div class="col-md-4 qwerty_1" style="display:{{ $get_hide }}" id="{{$form_field->field_name}}">
                                            <?php //dd($form_field->id); ?>
                                            <label style="text-transform: uppercase;">{{$form_field->label_name}}</label>
                                            <?php $filedsoptions = App\Models\CrmFormFieldOption::where('crm_filed_id', $form_field->id)->get();
                                            $dropName = $form_field->field_name;
                                            ?>
                                            <select onchange="getParent(this.value, {{$form_field->id}}){{$get_function}}" class="form-control select2bs4" style="width: 100%;" id="field_type_{{$form_field->id}}"  fieldcounter=0 name="{{$form_field->field_name}}" {{ $required_filed }} my_child={{ $all_child_name }} {{ $req }} }}>

                                                <option value="">Select {{$form_field->label_name}}</option>
                                                <?php if($form_field->field_depend == '' || $form_field->field_depend == 'null') { ?>
                                                    <?php
                                                 foreach ($filedsoptions as $options) {
                                                    $selected = '';
                                                    if($finalDatas[0]->$dropName == $options->options)
                                                    $selected = 'selected="selected"';
                                                    ?>
                                                    <option  value="{{$options->options}}" onclick="getParent('{{$options->options}}', '{{$options->crm_filed_id}}' )" id="{{$options->crm_filed_id}}"  {{ $selected }}>{{$options->options}}</option>
                                                <?php } } ?>



                                            </select>
                                        </div>
                                    <?php break;
                                    case "check_box":
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

                                    $checkName = $form_field->field_name;

                                    $checkArry = explode(",",$finalDatas[0]->$checkName);

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
                                                <?php foreach ($filedsoptions as $options) {

                                                    $checked = '';
                                                    if(in_array($options->options,$checkArry)){
                                                        $checked = 'checked="checked"';
                                                    }


                                                    ?>
                                                    <input {{ $checked }} type="checkbox" name="{{$form_field->field_name}}[]" value="{{$options->options}}" {{ $required_filed }} {{ $req }} data-parsley-mincheck="2" class="flat" /> {{$options->options}}
                                                <?php } ?>
                                            </p>
                                        </div>
                                    <?php break;
                                    case "radio_button":
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

                                    $radioName = $form_field->field_name;

                                     ?>
                                        <?php $filedsoptions = App\Models\CrmFormFieldOption::where('crm_filed_id', $form_field->id)->get();
                                        ?>
                                        <div class="col-md-4" style="display:{{ $get_hide }}" id="{{$form_field->field_name}}">
                                            <label style="text-transform: uppercase;">{{$form_field->label_name}}</label>

                                            <p>
                                                <?php foreach ($filedsoptions as $options) {

                                                    $checked = '';
                                                    if($finalDatas[0]->$radioName == $options->options)
                                                    $checked = 'checked="checked"';

                                                    ?>
                                                    {{$options->options}}:
                                                    <input {{ $checked }}  type="radio" class="flat form-control" {{ ($form_field->is_required=='yes') ? 'required' : '' }} name="{{$form_field->field_name}}" value="{{$options->options}}" {{ $required_filed }} onclick="{{ $get_function }}" my_child={{ $all_child_name }}/>
                                                <?php } ?>
                                            </p>
                                        </div>
                                    <?php break;
                                    case "date_picker":

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

                                    $datePickerName = $form_field->field_name;

                                    ?>
                                        <div class="col-md-4">
                                            <label style="text-transform: uppercase;">{{$form_field->label_name}}</label>
                                            <input type="date" value="{{$finalDatas[0]->$datePickerName}}"  placeholder="Enter {{$form_field->label_name}}" class="form-control" name="{{$form_field->field_name}}"{{ $required_filed }} {{ $req }}>
                                        </div>
                                <?php break;

                                case "date_time_picker":

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

                                    $datePickerName = $form_field->field_name;

                                    ?>
                                        <div class="col-md-4">
                                            <label style="text-transform: uppercase;">{{$form_field->label_name}}</label>
                                            <input type="time" value="{{$finalDatas[0]->$datePickerName}}"  placeholder="Enter {{$form_field->label_name}}" class="form-control" name="{{$form_field->field_name}}"{{ $required_filed }} {{ $req }}>
                                        </div>
                                <?php break;

                                    default:
                                        echo "nothing";
                                }

                                ?>
								@if($counter == 3)
                                @php  $counter=0;   @endphp
                                </div>

                                @endif

							@php $counter++; @endphp
                                @endforeach
                                @else
                                <h2 align="center"><span class="label label-danger">No crm Mapped!</span></h2>
                                @endif


                            </div>
                            <div class="row"></br>
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                    <button type="submit" class="btn btn-success " counter=0>Update </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
                        </div>
                    </section>

    <button id="get_history" class="btn btn-light">History</button>

    @if(!empty($crm_input_history) && isset($crm_input_history[0]))

    <div class="row" id="togal_class" style="display: none">

        <div class="col-md-12 col-sm-12 col-xs-12">
            {{-- <h5>History</h5> --}}
            <div class="x_panel">
                <section class="content">
                    <div class="container-fluid">
                      <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <div class="card card-info">
                            <div class="card-header">
                                <h5>History</h5>
                             </div>
                            <div class="card-body">
    <table class="table table-bordered table-striped" id="example1">
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
                            </div>
                           </div>
                        </div>
                      </div>
                    </div>
                </section>

    </div></div></div>
      @else
      <h2>No! history Found<h2>
     @endif
     {{-- <td></td> --}}
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



<script>
$(document).ready(function(){
$("#get_history").click(function(){
    $("#togal_class").toggle(300);
  });
});
$(document).ready( function () {

    $('#myTable').DataTable();

} );


 const getParent = (parent_name, crm_filed_id) => {


        //var selected = $(".qwerty_1").children("select").attr("id");
        var selected = $(".qwerty_1").children("select").length;
        counter = parseInt($(this).attr("counter"))
        newcount = counter + 1
        $(this).attr("counter", newcount)
        let url_child = @json(url(Request::segment(1).'/addChildField'))

    $.ajax({
            url: url_child,
            type: 'POST',
            data: {
                "counter": counter,
                "parent_name": parent_name,
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
                    for (let i = 0; i < qwe.length; i++) {

                         let state_data = `<option value="${qwe[i]['options']}">${qwe[i]['options']}</option>`;
                         $(`#field_type_${qwe[0]['crm_filed_id']}`).append(state_data);
                   }
                    }else {
                         $(`#field_type_${qwe[0]['id']}`).empty();
                    }
                } else {
                 //alert("Somtning went Wrong !");
                }
            },
            error: function(response) {
                window.console.log(response);
            }
        });


 }




</script>

<script>
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
@endsection
