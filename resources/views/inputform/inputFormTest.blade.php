@extends('frount.index')

@section('content')
<style>
    p {
        margin: 10px 0px 10px !important;
    }
</style>
<?php $checkYes = 0; ?>
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>{{strtoupper($crmform->form_name)}} <small></small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <form role="form" id="quickForm" action="{{route('SubmitAgentForm')}}" method="POST">
                        <div class="x_content">
                            <br />
                            <div class="row">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <input name="form_id" type="hidden" value="{{$crmform->id}}">
                                <input name="form_name" type="hidden" value="{{$crmform->form_name}}" />
                                <input name="created_by" type="hidden" value="{{ Auth::id()}}" />

                                @if(!empty($crm_fields))
								@php $counter=1; @endphp	
                                @foreach ( $crm_fields as $form_field )
								@if($counter=="1")
									<div class="row" style="margin-bottom:15px">
								@elseif($counter%3=="1")	
							    <div class="row" style="margin-bottom:15px">
								@else
								@endif
							
                                <?php
								
                                switch ($form_field->field_type) {
                                    case "text": ?>
                                        <div class="col-md-4">
                                            <label style="text-transform: uppercase;">{{ $form_field->label_name }}</label>
                                            <input type="{{ ($form_field->is_numaric=='yes') ? 'number' : 'text' }}" placeholder="Enter {{$form_field->label_name}}" class="form-control" name="{{$form_field->field_name}}" {{ ($form_field->is_required=='yes') ? 'required' : '' }} />
                                        </div>
                                    <?php break;
                                    case "text_area": ?>
                                        <div class="col-md-4">
                                            <label style="text-transform: uppercase;">{{$form_field->label_name}}</label>

                                            <textarea class="form-control" placeholder="Enter {{$form_field->label_name}}" name="{{$form_field->field_name}}" {{ ($form_field->is_required=='yes') ? 'required' : '' }}></textarea>
                                        </div>
                                    <?php break;
                                    case "drop_down": ?>
                                        <div class="col-md-4 qwerty_1">
                                            <label style="text-transform: uppercase;">{{$form_field->label_name}}</label>
                                            <?php $filedsoptions = App\Models\CrmFormFieldOption::where('crm_filed_id', $form_field->id)->get();
                                               //dd( $filedsoptions);
                                            ?>
                                            <select onchange="getParent(this.value, {{$form_field->id}})" class="form-control select2bs4" style="width: 100%;" id="field_type_{{$form_field->id}}"  fieldcounter=0 name="{{$form_field->field_name}}" {{ ($form_field->is_required=='yes') ? 'required' : '' }}>

                                                <option value="">Select {{$form_field->label_name}}</option>
                                                <?php if($form_field->field_depend == '' || $form_field->field_depend == 'null') { ?>
                                                    <?php
                                                 foreach ($filedsoptions as $options) { ?>
                                                    <option value="{{$options->options}}" onclick="getParent('{{$options->options}}', '{{$options->crm_filed_id}}' )" id="{{$options->crm_filed_id}}" >{{$options->options}}</option>
                                                <?php } } ?>



                                            </select>
                                        </div>
                                    <?php break;
                                    case "check_box": ?>
                                        <div class="col-md-4">
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
                                                    <input type="checkbox" name="{{$form_field->field_name}}[]" value="{{$options->options}}" data-parsley-mincheck="2" class="flat" /> {{$options->options}}
                                                <?php } ?>
                                            </p>
                                        </div>
                                    <?php break;
                                    case "radio_button": ?>
                                        <?php $filedsoptions = App\Models\CrmFormFieldOption::where('crm_filed_id', $form_field->id)->get();
                                        ?>
                                        <div class="col-md-4">
                                            <label style="text-transform: uppercase;">{{$form_field->label_name}}</label>

                                            <p>
                                                <?php foreach ($filedsoptions as $options) { ?>
                                                    {{$options->options}}:
                                                    <input type="radio" class="flat form-control" {{ ($form_field->is_required=='yes') ? 'required' : '' }} name="{{$form_field->field_name}}" value="{{$options->options}}" />
                                                <?php } ?>
                                            </p>
                                        </div>
                                    <?php break;
                                    case "date_picker": ?>
                                        <div class="col-md-4">
                                            <label style="text-transform: uppercase;">{{$form_field->label_name}}</label>
                                            <input type="date" placeholder="Enter {{$form_field->label_name}}" class="form-control" name="{{$form_field->field_name}}" {{ ($form_field->is_required=='yes') ? 'required' : '' }}>
                                        </div>
                                <?php break;
                                    default:
                                        echo "nothing";
                                }

                                ?>
								
								
								@if($counter%3=="")	
							    </div>
								
								@endif
							
							@php $counter++; @endphp

                                @endforeach
                                @else
                                <h2 align="center"><span class="label label-danger">No crm Mapped!</span></h2>
                                @endif


                            </div>
                            <div class="row" align="center"></br>
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                    <button type="submit" class="btn btn-success " counter=0>Save </button>
                                </div>
                            </div>
                        </div>
                    </form>
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



<script>


 const getParent = (parent_name, crm_filed_id) => {


        //var selected = $(".qwerty_1").children("select").attr("id");
        var selected = $(".qwerty_1").children("select").length;
        counter = parseInt($(this).attr("counter"))
        newcount = counter + 1
        $(this).attr("counter", newcount)

    $.ajax({
            url: "{{route('addChildField')}}",
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
