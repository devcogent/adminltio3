@extends('frount.index')
@section('content')
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
           <div class="card card-info">
            <div class="card-header">
                <h5 id="heading"><a href="{{url('crm-master')}}" class="btn  btn-danger btn-sm float-right"> <i class="fa fa-plus"></i> Back</a></h5>
            </div>
            <div class="card-body">
        @if ($form_count < 3)
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <form role="form" id="quickForm" name="createForm" action="{{route('crmmaster.createForm')}}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="crm_id" value="{{ $crm_masters->id  }}">
                    <input type="hidden" name="crm_name" value="{{ $crm_masters->crm_name  }}">
                    <div class="x_panel">
                        <?php
                        $my_form_status = '0';
                        $remit_ext = [];
                            $crmform  = App\Models\CrmForm::where('crm_id', $crm_masters->id)->get()->toArray();
                            foreach ($crmform as $crm_ext) {
                                $remit_ext[] = $crm_ext['form_type'];
                            }
                        ?>
                        <div class="x_content">
                            <div class="row">
                               @if ($crm_masters->crm_type == 2 && !in_array('2', $remit_ext) )
                                    <input type="hidden" name="form_type" value="2">
                                    <input type="hidden" name="form_name" value="agent_input">
                                    <input type="hidden" name="cti_type" value="4">
                                    <?php $crm_get_type = 'Only Agent Input'; ?>
                               @elseif ($crm_masters->crm_type == 1 && !in_array('1', $remit_ext) && !in_array('2', $remit_ext))
                                    <input type="hidden" name="form_type" value="1">
                                    <input type="hidden" name="form_name" value="client_data">
                                    <?php $crm_get_type = 'Client Data'; ?>
                               @elseif ($crm_masters->crm_type == 1 && in_array('1', $remit_ext) && !in_array('2', $remit_ext))
                                    <input type="hidden" name="form_type" value="2">
                                    <input type="hidden" name="form_name" value="agent_input">
                                    <input type="hidden" name="cti_type" value="3">
                                    <?php $crm_get_type = 'Agent Input with Client Data'; ?>
                               @else
                                   <?php
                                      $my_form_status = '1';
                                      $crm_get_type = 'You have already created Agent Input or Client Data';
                                    ?>
                                @endif
                            </div>
                        </div>

                        <input type="hidden" id="title" value="Manage {{$crm_masters->crm_name}} CRM Fields ( {{ $crm_get_type }} )">


                    </div>
                   @if ($my_form_status == '0')
                    <div class="x_panel">
                        <div class="x_content">

                            <div class="row">

                                <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 9%">
                                    <label>Field Type</label>
                                </div>
                                <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 9%">
                                    <label>Field Name</label>
                                </div>
                                <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 9%">
                                    <label>Label Name</label>
                                </div>
                                <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 9%">
                                    <label>Order By</label>
                                </div>
                                <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 9%">
                                    <label>Min Length </label>
                                </div>
                                <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 9%">
                                    <label>Max Length </label>
                                </div>
                                <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 9%">
                                    <label>Is Numeric </label>
                                </div>
                                <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 9%">
                                    <label>Required </label>
                                </div>
                                <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 9%">
                                    <label>Is Unique </label>
                                </div>
                                <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 9%">
                                    <label>Audit Trail </label>
                                </div>
                                <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 9%">
                                    <label>Add More </label>
                                </div>


                            </div>
                            <div id="mainRow">
                                <div class="row" id="FieldRow">
                                    <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 9%">
                                        <select class="form-control select2bs4 filedTypecheck" style="width: 100%;" name="field_type[]" id="field_type_0" required fieldcounter=0>
                                            <option value="" selected>Select Field Type</option>
                                            <option value="text">Text</option>
                                            {{-- <option value="mobile">Mobile</option> --}}
                                            <option value="email">Email</option>
                                            {{-- <option value="zip">Zip</option> --}}
                                            <option value="drop_down">Drop Down</option>
                                            <option value="text_area">Text area</option>
                                            <option value="radio_button">Radio button</option>
                                            <option value="check_box">Check Box</option>
                                            <option value="date_picker">Date picker</option>
                                            <option value="date_time_picker">Date Time picker</option>
                                        </select>
                                    </div>

                                    <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 9%">
                                        <input type="text" required placeholder="Enter field name" class="form-control" name="field_name[]">
                                        {{-- <input type="hidden" name="field_name_old[]" value="null"> --}}
                                    </div>
                                    <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 9%">
                                        <input type="text" required placeholder="Enter Label name" class="form-control" name="label_name[]">
                                    </div>
                                    <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 9%">
                                        <input type="number" placeholder="Order By" class="form-control" name="sortBy[]" required value="1">
                                    </div>
                                    <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 9%">
                                        <input type="number" placeholder="Min lenght" class="form-control" name="minlength[]" required value="0">
                                    </div>
                                    <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 9%">
                                        <input type="number" placeholder="Max Lenght" class="form-control" name="length[]" required  value="50">
                                    </div>
                                    <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 9%">
                                        <select class="form-control select2bs4" disabled style="width: 100%;" name="is_numaric[]" id="is_numaric_0" required fieldcounter=0 style="width: 10%">
                                            <option value="no" selected>No</option>
                                            <option value="yes">Yes</option>

                                        </select>
                                    </div>
                                    <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                        <select class="form-control select2bs4" style="width: 100%;" name="is_required[]" id="is_required_0" required fieldcounter=0 style="width: 9%">
                                            <option value="no" >No</option>
                                            <option value="yes" selected>Yes</option>

                                        </select>
                                    </div>
                                    <div class="col-md-1 col-sm-12 col-xs-12 form-group " style="width: 9%">
                                        <select class="form-control select2bs4" style="width: 100%;" name="is_unique[]" id="is_unique_0" fieldcounter=0>
                                            <option value="no">No</option>
                                            <option value="yes" selected>Yes</option>

                                        </select>
                                    </div>

                                    <div class="col-md-1 col-sm-12 col-xs-12 form-group " style="width: 9%">
                                        <select class="form-control select2bs4" style="width: 100%;" name="is_audit[]" id="is_audit_0" fieldcounter=0>
                                            <option value="no">No</option>
                                            <option value="yes" selected>Yes</option>

                                        </select>
                                    </div>

                                    <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 9%">
                                        <button type="button" class="btn btn-success " id="clone_btn" counter=0><i class="fa fa-plus" counter=0></i></button>
                                    </div>

                                    <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 9%">
                                        <select class="form-control select2bs4 qwsert" style="width: 100%;" name="field_depend[]" id="field_depend_0" fieldcounter=0>
                                            <option value="null"></option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row" align="center">
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                    <button type="submit" id="btnSubmit" class="btn btn-success " counter=0>Save </button>
                                </div>
                            </div>

                            <span style="color:red">Note:- select parent and child dependencies in <b>edit</b> section after creation form</span>


                        </div>
                    </div>
                    @else
                      <div></div>
                   @endif

                </form>
            </div>

            @else
<br><br><br><br><br>
            <center><h2>You Have Already Created From <b>Client Data/ User Input</b>  </h2></center>

           @endif



        </div>
    </div>
</div>





</div>

</div>
</section>
</div>
</div>
<script>
$('#form_type').change(function(e){
  form_type =  $('#form_type').val();
  var crm_name = @json($crm_masters->crm_name);
  if(form_type == 2) {
    $("#inputTxt").val(`agent_input`);
    $('#type_lbl').html(`<div class="col-md-1 col-sm-6 col-xs-6 form-group"><Label>Cti Form Type</Label> </div>`).show();
    $('#cls_form_name').html(`<select name="cti_type" class="form-control" id="cti_type" required="required">

                                    <option value='1'>With CTI</option>
                                    <option value='2'>With Out CTI</option>
                                </select> <input type="hidden" name="form_type_value" value="client_data" >` ).show();
  } else {
        $('#cls_form_name').html(`<input type="hidden" name="form_type_value" value="" >`).hide();
        $("#inputTxt").val(`client_data`);
  }

});

</script>
<script>

$('#heading').text($('#title').val());

    $('#inputTxt').keypress(function(e) {
        var txt = String.fromCharCode(e.which);
        //console.log(txt + ' : ' + e.which);
        if (!txt.match(/[A-Za-z_]/)) {
            $('#questionhide').show();

            $(":submit").attr("disabled", true);
            return false;
        } else {
            $('#questionhide').hide();

            $(":submit").removeAttr("disabled");
        }
    });


    $("#clone_btn").click(function() {

        //var numberOfSpans =  $('#field_type option').length;
        counter = parseInt($(this).attr("counter"))
        newcount = counter + 1
        $(this).attr("counter", newcount)
        $.ajax({
            url: "{{route('addNewField')}}",
            type: 'POST',
            data: {
                "counter": counter,
                "_token": "{{ csrf_token() }}",
            },
            success: function(response) {
                if (response.status == 'success') {

                    $("#mainRow").append(response.html);
                } else {
                    alert("Somtning went Wrong !")
                }
            },
            error: function(response) {
                window.console.log(response);
            }
        });

    });
    $('#mainRow').on('click', '.remove', function() {
        //alert(counter = parseInt($(this).attr("counter")))
        $(this).parent().parent().remove();
    });

    $('#mainRow').on('click', '.remove', function() {
        //alert(counter = parseInt($(this).attr("counter")))
        $(this).parent().parent().remove();
    });
    $('#mainRow').on('change', '.filedTypecheck', function() {
        //alert(counter = parseInt($(this).attr("counter")))
        var is_numaric = $(this).attr('fieldcounter');
        if ($(this).val() == "text") {
            // $("#is_numaric_" + is_numaric).show()
            $("#is_numaric_" + is_numaric).attr('disabled', false)
        } else {
            //$("#is_numaric_" + is_numaric).hide()
            $("#is_numaric_" + is_numaric).attr('disabled', true)
        }


    });


    $('#quickForm').on('submit', function() {
        $('input, select').prop('disabled', false);
    });

    $("#field_depend_0").hide();

    dependFiled = (count_val) => {

        let field_type = "#field_type_" + count_val;
        let flt = $(field_type).val();
        let depend = "#is_depend_" + count_val;
        let get_dep_val = $(depend).val();
        let depend_filed_value = "#field_depend_" + count_val;
        let depend_filed_value2 = "field_depend_" + count_val;
        var a = new Array();
        $(depend_filed_value).children("option").each(function(x) {
            test = false;
            b = a[x] = $(this).val();
            for (i = 0; i < a.length; i++) {
                if (b == a[i]) test = true;
            }
            if (test) $(this).remove();
        });

        if (get_dep_val === 'yes' && flt != 'drop_down') {

            Swal.fire({
                title: '<strong>Please Select Field Type Drop Down</u></strong>',
                icon: 'info',
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText: '<i class="fa fa-thumbs-up"></i> Great!',
                confirmButtonAriaLabel: 'Thumbs up, great!',
                cancelButtonText: '<i class="fa fa-thumbs-down"></i>',
                cancelButtonAriaLabel: 'Thumbs down'
            })
        }


        if (get_dep_val === 'yes' && flt === 'drop_down') {
            $('input[name^="field_name"]').each(function() {
                let filed_value = $(this).val();
                let option_data = `<option value="${filed_value}">${filed_value}</option>`;
                $(depend_filed_value).css("display", "block");
                $(depend_filed_value).eq(0).append(option_data);


            });
            $(depend_filed_value).each(function() {
                $(this).find("option:last").remove();
            });
        } else {
            let option_data = `<option value="null">N/A</option>`;
            $(depend_filed_value).hide();
            $(depend_filed_value).eq(0).append(option_data);
            var list = document.getElementById(depend_filed_value2);
            listItems = list.getElementsByTagName("option");
            listItems.remove();

        }
    }
</script>

@endsection
