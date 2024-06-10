@extends('frount.index')

@section('content')

<?php $checkYes = 0; ?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h5>Without CTI Random Pick</h5>
                    </div>
                    <div class="card-body">


                    <form role="form" id="quickForm" action="{{url(Request::segment(1).'/openSearchAgentDataRandom')}}" method="POST">
                             <div class="row">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <input name="tid" type="hidden" value="{{$tid}}" />
                                <input name="table_agent_input" type="hidden" value="{{$table_agent_input}}" />
                                <input name="crmform" type="hidden" value="{{$crmform}}" />
                                <?php
                                    Config::set('database.connections.mysql.database',env('DB_DATABASE'));
                                    DB::purge('mysql');
                                ?>
                                <input name="user_get_id" type="hidden" value="{{Auth::user()->emp_id}}" />
                                <?php
                                    Config::set('database.connections.mysql.database', 'cgcrm_'.explode('_client_data',$table_agent_input)[0]);
                                    DB::purge('mysql');
                                ?>
                                <input name="from_data_id" type="hidden" value="{{$from_data_id}}" />
                                <input name="old_url" type="hidden" value="{{$old_url}}" />
                               <button type="submit" class="btn btn-primary my-4" counter=0>Get Data </button>
                            </div>
                    </form>

        <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-4" style="float: left;">
                <div class="card card-info">
                    <div class="card-header">
                             <h3 class="card-title">Client Data</h3>
                    </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered table" style="width:100%">
                        <tbody>
                        <?php
                        if(isset($search_agent_input_data)) {
                        foreach ($search_agent_input_data as $key => $data) {

                            foreach ((array)$data as $k => $v) {

                                if ($k != "created_by") {
                                    echo ' <tr><td><b>' . strtoupper($k) . '</b></td>';
                                    echo ' <td>' . strtoupper($v) . '</td></tr>';
                                }else {
                                    break;
                                }
                            }
                        } }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
            <div class="col-md-8 col-sm-8 col-xs-8" style="float: right;">
                  <div class="card card-info">
                        <div class="card-header">
                                 <h3 class="card-title">Agent Input CTI</h3>
                        </div>
                        <div class="card-body">
                           <form role="form" id="quickForm" action="{{url(Request::segment(1).'/openSubmitAgentFormWithOut')}}" method="POST">

                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <input name="form_id" type="hidden" value="{{$crmform->id}}">
                                <input name="form_name" type="hidden" value="{{$crmform->form_name}}" />
                                 <input name="from_data_id" type="hidden" value="{{$from_data_id}}" />
                                <input name="tid" type="hidden" value="{{$tid}}" />
                                <input name="created_by" type="hidden" value="{{ $user_data->id}}" />
                                <input name="old_url" type="hidden" value="{{$old_url}}" />


                                @if(!empty($crm_fields))

								@php $counter=1;

                                @endphp
                                @foreach ( $crm_fields as $form_field )
								@if($counter==1)
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
                                    } ?>
                                        <div class="col-md-4">
                                            <label style="text-transform: uppercase;">{{$form_field->label_name}}</label>
                                            <input id="datefield" min='{{$min}}' max='{{$max}}' type="date" placeholder="Enter {{$form_field->label_name}}" class="form-control" name="{{$form_field->field_name}}" {{ ($form_field->is_required=='yes') ? 'required' : '' }}>
                                        </div>
                                    <?php break;
                                    case "date_time_picker":
                                    $maxlen = $form_field->length;
                                    $minlen = $form_field->minlength;
                                    $max = $min = '';
                                    if($maxlen!='-1' ){
                                    $max = date('Y-m-d',strtotime("+".$maxlen." days"));
                                    }
                                    if($minlen!='-1' ){
                                    $min = date('Y-m-d',strtotime("-".$minlen." days"));
                                    } ?>
                                        <div class="col-md-4">
                                            <label style="text-transform: uppercase;">{{$form_field->label_name}}</label>
                                            <input id="datefield" min='{{$min}}' max='{{$max}}' type="time" placeholder="Enter {{$form_field->label_name}}" class="form-control" name="{{$form_field->field_name}}" {{ ($form_field->is_required=='yes') ? 'required' : '' }}>
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
                        @if(isset($search_agent_input_data))
                             <button type="submit" class="btn btn-success " counter=0>Save </button>
                        @endif
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
                "form_name": "{{  explode('_client_data',$table_agent_input)[0] }}",
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

@endsection
