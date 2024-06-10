
<style>

    .qwsert{

        display: none;
    }

    </style>
<div class="row" id="FieldRow_{{$counter}}">
    <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 8%">
        <select class="form-control select2bs4 filedTypecheck" style="width: 100%;" name="field_type[]" id="field_type_{{$counter}}" required fieldcounter={{$counter}}>
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

    <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 8%">
        <input type="text" placeholder="Enter field name" class="form-control" name="field_name[]" required>
        <input type="hidden" name="field_name_old[]" value="null">
    </div>
    <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 8%">
        <input type="text" placeholder="Enter Label name" class="form-control" name="label_name[]" required >
    </div>
    <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 8%">
        <input type="number" placeholder="Order By" class="form-control" name="sortBy[]" required value="{{$counter}}" >
    </div>
    <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 8%">
        <input type="number" placeholder="Min lenght" class="form-control" name="minlength[]" required value="10">
    </div>
    <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 8%">
        <input type="number" placeholder="Max Lenght" class="form-control" name="length[]" required value="50" >
    </div>
    <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 8%">
        <select class="form-control select2bs4" style="width: 100%;" disabled name="is_numaric[]" id="is_numaric_{{$counter}}" required fieldcounter=0 style="width: 10%">
            <option value="no" selected>No</option>
            <option value="yes">Yes</option>
        </select>
    </div>
    <div class="col-md-1 col-sm-12 col-xs-12 form-group" >
        <select class="form-control select2bs4" style="width: 100%;" name="is_required[]" id="is_required_{{$counter}}" required fieldcounter={{$counter}} >
            <option value="no">No</option>
            <option value="yes" selected>Yes</option>
        </select>
    </div>
    {{-- <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 8%">
        <select class="form-control select2bs4" style="width: 100%;" name="is_depend[]" id="is_depend_{{$counter}}"  fieldcounter=0 onchange="dependFiled({{$counter}})">
            <option value="no" selected>No</option>
            <option value="yes">Yes</option>
         </select>
    </div> --}}
    <div class="col-md-1 col-sm-12 col-xs-12 form-group " style="width: 8%">
        <select class="form-control select2bs4" style="width: 100%;" name="is_unique[]" id="is_unique_{{$counter}}" fieldcounter=0>
            <option value="no" selected>No</option>
            <option value="yes">Yes</option>

        </select>
    </div>
    <div class="col-md-1 col-sm-12 col-xs-12 form-group " style="width: 8%">
        <select class="form-control select2bs4" style="width: 100%;" name="is_audit[]" id="is_audit_{{$counter}}" fieldcounter=0>
            <option value="no" selected>No</option>
            <option value="yes">Yes</option>

        </select>
    </div>
    <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="width: 8%">
        <button type="button" class="btn btn-danger remove " id="clone_btn" counter="{{$counter}}"><i class="fa fa-minus"></i></button>
    </div>


    <div class="col-md-1 col-sm-12 col-xs-12 form-group " style="width: 8%">
        <select class="form-control select2bs4 qwsert" style="width: 100%;" name="field_depend[]" id="field_depend_{{$counter}}"  fieldcounter=0>
            <option value="null"></option>

        </select>
    </div>


</div>
<script>
    $('.filedTypecheck1').change(function() {
        //alert(counter = parseInt($(this).attr("counter")))
        alert($(this).attr('fieldcounter'));
    });
</script>
