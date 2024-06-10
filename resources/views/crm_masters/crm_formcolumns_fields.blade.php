<style>
    .qwsert {

        display: none;
    }
</style>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<form role="form" id="quickForm" name="createForm" action="{{ route('update-column') }}" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="crm_forms" value="{{ $crm_forms }}">
    <input type="hidden" name="crm_name" value="{{ $crm_name }}">
    <div class="x_panel">
        <div class="x_content">

            <div class="row">
                <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 8%">
                    <label>Field Type</label>
                </div>
                <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 8%">
                    <label>Field Name</label>
                </div>
                <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 8%">
                    <label>Label Name</label>
                </div>
                <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 8%">
                    <label>Order By</label>
                </div>
                <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 8%">
                    <label>Min Length </label>
                </div>
                <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 8%">
                    <label>Max Length </label>
                </div>
                <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 8%">
                    <label>Is Numeric </label>
                </div>
                <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 8%">
                    <label>Required </label>
                </div>

                {{-- <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 8%">
                    <label>Dependent </label>
                </div> --}}
                <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 8%">
                    <label>Is Unique </label>
                </div>
                <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 9%">
                    <label>Audit Trail </label>
                </div>
                <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 8%">
                    <label>Add More </label>
                </div>

                <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 8%">
                    <label> Dep Filed </label>
                </div>

            </div>
            <div id="mainRow">
                <div class="row" id="FieldRow">

                    @if (!empty($crm_fields) && $crm_fields->count())
                        @php $i=0; @endphp
                        @foreach ($crm_fields as $cat)

                        @php
                              $i = $i+1;
                        @endphp
                            <div class="row">

                                <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 8%">

                                    @php
                                    $field_type_text = '';
                                    $field_type_mobile = '';
                                    $field_type_email = '';
                                    $field_type_zip = '';
                                    $field_type_drop_down = '';
                                    $field_type_text_area = '';
                                    $field_type_radio_button = '';
                                    $field_type_check_box = '';
                                    $field_type_date_picker = '';
                                    if($cat->field_type == 'text') { $field_type_text = 'selected'; }
                                    if($cat->field_type == 'mobile') { $field_type_mobile = 'selected'; }
                                    if($cat->field_type == 'email') { $field_type_email = 'selected'; }
                                    if($cat->field_type == 'zip') { $field_type_zip = 'selected'; }
                                    if($cat->field_type == 'drop_down') { $field_type_drop_down = 'selected'; }
                                    if($cat->field_type == 'text_area') { $field_type_text_area = 'selected'; }
                                    if($cat->field_type == 'radio_button') { $field_type_radio_button = 'selected'; }
                                    if($cat->field_type == 'check_box') { $field_type_check_box = 'selected'; }
                                    if($cat->field_type == 'date_picker') { $field_type_date_picker = 'selected'; }
                                    if($cat->field_type == 'date_time_picker') { $field_type_date_picker = 'selected'; }
                                    @endphp
                                    <select class="form-control select2bs4 filedTypecheck" style="width: 100%;"
                                        name="field_type[]" id="field_type_{{ $i }}" required fieldcounter={{ $i }}>
                                        <option value="" selected>Select Field Type</option>
                                        <option value="text" {{ $field_type_text  }}>Text</option>
                                        {{-- <option value="mobile" {{ $field_type_mobile  }}>Mobile</option> --}}
                                        <option value="email"  {{ $field_type_email  }}>Email</option>
                                        {{-- <option value="zip"  {{ $field_type_zip  }}>Zip</option> --}}
                                        <option value="drop_down" {{ $field_type_drop_down  }}>Drop Down</option>
                                        <option value="text_area" {{ $field_type_text_area }}>Text area</option>
                                        <option value="radio_button" {{ $field_type_radio_button}} >Radio button</option>
                                        <option value="check_box" {{ $field_type_check_box}}>Check Box</option>
                                        <option value="date_picker" {{ $field_type_date_picker}}>Date picker</option>
                                        <option value="date_time_picker" {{ $field_type_date_picker}}>Date Time picker</option>

                                    </select>
                                </div>
                                @php
                                $checkValue = '';
                                $checkValue = $cat->id . '@@' . $cat->field_name;
                                @endphp

                                <input type="hidden" class="selectedDelete" name="column_name[]"
                                value="{{ $checkValue }}">


                                <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 8%">

                                    <input type="text" required placeholder="Enter field name" class="form-control"
                                        name="field_name[]" value="{{ $cat->field_name }}" my_counter={{ $i }}>
                                    <input type="hidden" name="field_name_old[]" value="{{ $cat->field_name }}">

                                </div>
                                <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 8%">
                                    <input type="text" required placeholder="Enter Label name" class="form-control"
                                        name="label_name[]" value="{{ $cat->label_name }}">
                                </div>
                                <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 8%">
                                    <input type="number" placeholder="Order By" class="form-control" name="sortBy[]"
                                        required value="{{ $cat->sortBy }}">
                                </div>
                                <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 8%">
                                    <input type="number" placeholder="Min lenght" class="form-control"
                                        name="minlength[]" required value="{{ $cat->minlength }}">
                                </div>
                                <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 8%">
                                    <input type="number" placeholder="Max Lenght" class="form-control" name="length[]"
                                        required value="{{ $cat->length }}">
                                </div>
                                <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 8%">
                                    <select class="form-control select2bs4"  style="width: 100%;"
                                        name="is_numaric[]" id="is_numaric_{{ $i }}" required fieldcounter=0
                                        style="width: 8%">
                                        @php
                                        $is_num_no = '';
                                        $is_num_yes = '';
                                        if($cat->is_numaric == 'no') {
                                            $is_num_no = 'selected';
                                        }
                                        else {
                                        $is_num_yes = 'selected';
                                        }
                                        @endphp
                                        <option value="no" {{ $is_num_no }}>No</option>
                                        <option value="yes" {{ $is_num_yes }}>Yes</option>

                                    </select>
                                </div>
                                <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                    @php
                                    $is_required_no = '';
                                    $is_required_yes = '';
                                    if($cat->is_required == 'no') {
                                        $is_required_no = 'selected';
                                    }
                                    else {
                                    $is_required_yes = 'selected';
                                    }
                                    @endphp
                                    <select class="form-control select2bs4" style="width: 100%;" name="is_required[]"
                                        id="is_required_{{ $i }}" required fieldcounter={{ $i }} style="width: 8%">
                                        <option value="no" {{ $is_required_no }}>No</option>
                                        <option value="yes" {{ $is_required_yes }}>Yes</option>

                                    </select>
                                </div>

                                {{-- ============================================ --}}
                                @php
                                $field_depend_no = '';
                                $field_depend_yes = '';
                                if($cat->field_depend != 'no' && $cat->field_depend != null) {
                                    $field_depend_no = 'selected';
                                }
                                else {
                                $field_depend_yes = 'selected';
                                }
                                @endphp
                                {{-- <div class="col-md-1 col-sm-12 col-xs-12 form-group " style="width: 8%">
                                    <select class="form-control select2bs4" style="width: 100%;" name="is_depend[]"
                                        id="is_depend_{{ $i }}" fieldcounter={{ $i }} onchange="dependFiled({{ $i }})">
                                        <option value="" selected disabled>-select-</option>
                                        <option value="no">No</option>
                                        <option value="yes">Yes</option>

                                    </select>
                                </div> --}}
                                <div class="col-md-1 col-sm-12 col-xs-12 form-group " style="width: 8%">

                                    @php
                                    $is_unique_no = '';
                                    $is_unique_yes = '';
                                    if($cat->is_unique == 'no') {
                                        $is_unique_no = 'selected';
                                    }
                                    else {
                                    $is_unique_yes = 'selected';
                                    }
                                    @endphp
                                    <select class="form-control select2bs4" style="width: 100%;" name="is_unique[]" id="is_unique_{{ $i }}" fieldcounter=0>
                                        <option value="no" {{ $is_unique_no }}>No</option>
                                        <option value="yes" {{ $is_unique_yes }}>Yes</option>

                                    </select>
                                </div>


                                <div class="col-md-1 col-sm-12 col-xs-12 form-group " style="width: 8%">

                                    @php
                                    $is_audit_no = '';
                                    $is_audit_yes = '';
                                    if($cat->is_audit == 'no') {
                                        $is_audit_no = 'selected';
                                    }
                                    else {
                                    $is_audit_yes = 'selected';
                                    }
                                    @endphp
                                    <select class="form-control select2bs4" style="width: 100%;" name="is_audit[]" id="is_audit_{{ $i }}" fieldcounter=0>
                                        <option value="no" {{ $is_audit_no }}>No</option>
                                        <option value="yes" {{ $is_audit_yes }}>Yes</option>

                                    </select>
                                </div>

                                {{-- ============================================ --}}
                                @if ($i == 1)
                                <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 8%">
                                    <button type="button" class="btn btn-success " id="clone_btn" counter={{ count($crm_fields) }}><i class="fa fa-plus"
                                        counter={{ count($crm_fields) }}></i></button>
                                </div>

                                @else
                                <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 8%">
                                    <button type="button" class="btn btn-danger remove " id="clone_btn" counter={{ count($crm_fields) }}><i class="fa fa-minus"
                                            counter={{ count($crm_fields) }}></i></button>
                                </div>
                                @endif

                                <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 8%">

                                    @if($cat->field_type == 'drop_down' && ($cat->field_depend == 'null' || $cat->field_depend == ''))
                                    <select class="form-control select2bs4" style="width: 100%;" name="field_depend[]" id="field_depend_{{ $i }}" fieldcounter=0 onchange="makeDepand(this.value,{{ $i }})">
                                        <option value="null" selected>-select-</option>
                                        @foreach ($crm_fields as $dep_filed)

                                            <?php
                                                $dep_sel = '';
                                                if($cat->field_depend == $dep_filed->field_name) {
                                                    $dep_sel = 'selected';
                                                }
                                            ?>
                                @if($dep_filed->field_type == 'drop_down' && $dep_filed->field_name != $cat->field_name && ($dep_filed->field_depend == 'null' || $dep_filed->field_depend == ''))
                                        @if(!in_array($dep_filed->field_name, $get_dep))
                                                <option value="{{ $dep_filed->field_name }}" {{ $dep_sel }}>{{ $dep_filed->field_name }}</option>
                                         @endif
                                            @endif

                                        @endforeach

                                    </select>

                                    @else

                                     <p><b>{{ $cat->field_depend != 'null' ? $cat->field_depend : '' }}</b></p>
                                     <input type="hidden" name="field_depend[]" value="{{  $cat->field_depend  }}">
                                    @endif
                                </div>
                                {{-- <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 10%">
                                    <select class="form-control select2bs4 qwsert" style="width: 100%;" name="field_depend[]" id="field_depend_{{ $i }}" fieldcounter=0>
                                        <option value="null"></option>

                                    </select>
                                </div> --}}
                                {{-- <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 8%">
                                    <input type="text" class="form-control" disabled  value="{{ $cat->field_depend }}">
                                </div> --}}



                            </div>
                        @endforeach
                        <div class="row">
                        </div>

                    @else
                        <tr>
                            <td colspan="10">There are no data.</td>
                        </tr>
                    @endif

                    <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 8%">
                        <select class="form-control select2bs4 qwsert" style="width: 100%;" name="field_depend[]"
                            id="field_depend_{{ $i }}" fieldcounter=0>
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
            {{-- <span style="color:red">Note:- Chosen parent dropdown after create form</span> --}}

        </div>
    </div>

</form>



<script>
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
            url: "{{ route('updateField') }}",
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

        var selectedDelete = new Array();
        var n = jQuery(".selectedDelete:checked").length;
        if (n > 0) {
            alert("Are you sure want to delete checked item. After deletion old data will be lose?");
        }
        //alert(n);
        //return false;
        $('input, select').prop('disabled', false);
    });

    // $("#field_depend_0").hide();

    dependFiled = (count_val) => {

        let field_type = "#field_type_" + count_val;
        console.log(field_type);
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
                // console.log(option_data);
                // console.log(filed_value);
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

<script type="text/javascript">

function makeDepand(value, selectefCount) {

     var getSibs = $(`input[value=${value}]`).siblings();
     var getSibAtt = getAttributes(getSibs);
     var sibCount = $(getSibAtt).attr('my_counter');
     var totalRecord =  @json($crm_fields->count());
        console.log(totalRecord);
        console.log(sibCount);
        console.log(selectefCount);
      for (let index = 0; index <= totalRecord; index++) {
          if(index != selectefCount) {
              $(`#field_depend_${index} option[value=${value}]`).remove();
          }

      }
     $(`#field_depend_${sibCount}`).hide();

}


function getAttributes ( $node ) {
    var attrs = {};
    $.each( $node[0].attributes, function ( index, attribute ) {
        attrs[attribute.name] = attribute.value;
    } );

    return attrs;
}


</script>
{{-- <script>
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
</script> --}}
