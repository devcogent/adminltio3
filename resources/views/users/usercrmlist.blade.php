<div class="col-md-12">
    <select class="form-control" name="crmList[]" id="crmList" width="400px" multiple="multiple" style="width: 75%">
        <option value=""> Select CRM</option>
        <?php foreach ($crm_masters as $gvalue) {
            $sel = '';
            if (in_array($gvalue->id, $uc)) {
                $sel = ' selected="selected" ';
            } ?>
            <option value="<?php echo $gvalue->id ?>" {{$sel}}> <?php echo $gvalue->crm_name ?></option>
        <?php } ?>

    </select>
</div>
<script>
    $("#crmList").select2({
        allowClear: true,
        width: 'resolve',
        placeholder: "Select CRM"

    });
</script>