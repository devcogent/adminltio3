@extends('frount.index')

@section('content')
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
           <div class="card card-info">
            <div class="card-header">
                <h5>Reports</h5>
             </div>
             <div class="card-body">
            
                            <form action="{{ route('reports.index') }}" method="POST" id="quickForm">

                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="form-group col-md-2">
                                        <label>Select CRM Type</label>
                                        <select class="form-control select2bs4 " style="width: 100%;" name="crm_type"
                                            id="crm_type" >

                                            <option value="">Select CRM </option>
                                            <option value="1" @if(isset($crmtype) && $crmtype == "1") ? selected : '' @endif>Client Data</option>
                                            <option value="2" @if(isset($crmtype) && $crmtype == "2") ? selected : '' @endif>Agent Input</option>

                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Select CRM </label>
                                        <select class="form-control select2bs4 " style="width: 100%;" name="crm_name"
                                            id="crm_name" >
                                            <option value="">Select CRM </option>
                                        </select>
                                     <span id="process_status_list"></span>
                                        
                                    </div>
                                       
                                    
                                    <div class="form-group col-md-2">
                                        <label>Date From </label>
                                        <input type="date" name="date_from" value="{{$datefrom}}" class="form-control"  />
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Date To </label>
                                        <input type="date" name="date_to" value="{{$dateto}}"  class="form-control"  />
                                    </div>



                                    <div class="form-group col-md-2">
                                        <label>Status </label>
                                        <select class="form-control select2bs4 " style="width: 100%;" name="status_by"
                                            id="status_by">
                                            <option value="1"  @if(isset($statusby) && $statusby == "1") ? selected : '' @endif>Upload Date</option>
                                            <option value="2"  @if(isset($statusby) && $statusby == "2") ? selected : '' @endif>Tagging Date</option>

                                        </select>
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label>Record </label>
                                        <select class="form-control select2bs4 " style="width: 100%;" name="record_by"
                                            id="record_by" required>
                                            <option value="1" @if(isset($recordby) && $recordby == "1") ? selected : '' @endif>Unique</option>
                                            <option value="2" @if(isset($recordby) && $recordby == "2") ? selected : '' @endif>Multi</option>

                                        </select>
                                    </div>
                                        <button type="submit" class="btn btn-success my-2 ml-2">Search</button>
                                 </div>
                                 
                            </form>


                            @if (!empty($finalDatas))
                            <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h5>Reports</h5>
                                </div>
                                <div class="card-body">
                                <table id="example1" class="table table-striped table-bordered">
                                    <thead>

                                        <tr>
                                            <?php
                                            foreach ($finalDatas as $key => $data) {
                                                foreach ((array) $data as $k => $v) {
                                                    if ($k != 'created_by') {
                                                        echo '<th>' . strtoupper(str_replace('_',' ',$k)) . '</th>';
                                                    }
                                                }
                                                break;
                                            } ?>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @php $i=1; @endphp
                                        <?php
                                        foreach ($finalDatas as $key => $data) {
                                            //print_r((array)$data);
                                            echo '<tr>';
                                            foreach ((array) $data as $k => $v) {

                                                if ($k != 'created_by') {
                                                    echo '<td>' . strtoupper($v) . '</td>';
                                                }
                                              }
                                            echo '</tr>';
                                        } ?>

                                    </tbody>

                                </table>
                                </div>
                            </div>
                        </div>
                    </div>

                            @endif

                            @if (!empty($table_header) && !empty($arr_set))
                            <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h5>Reports</h5>
                                </div>
                                <div class="card-body">
                                <table id="example1" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <?php
                                            foreach ($table_header as $data) {
                                                echo '<th>' . strtoupper(str_replace('_',' ',$data)) . '</th>';
                                            }
                                            ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($arr_set as $data2) {
                                            echo '<tr>';
                                            foreach ($data2 as $k) {
                                                if(strtotime($k))
                                                {
                                                   $k = date("Y-m-d H:i:s", strtotime($k));
                                                }
                                                echo '<td>' . strtoupper($k) . '</td>';
                                            }
                                            echo '</tr>';
                                        } ?>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                            @endif


                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

         var crm_type = '{{$crmtype}}';
         var selectedValue = '{{$crmname}}';
            $.ajax({
                url: "{{ route('getcrmType') }}",
                type: 'POST',
                data: {
                    "crm_type": crm_type,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(response) {
                    if (response.status == 'success') {
                        $('#crm_name').html(response.html);
                        $('#crm_name').val(selectedValue);
                        
                    }
                    
                }
             });

        $("#crm_type").change(function() {
            var crm_type = $(this).val();
            $('#process_status_list').html('');
            $('#process_status_list').html('Please Wait <i class="fa fa-spinner fa-spin" style="font-size:30px"></i>');
                
            $.ajax({
                url: "{{ route('getcrmType') }}",
                type: 'POST',
                data: {
                    "crm_type": crm_type,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(response) {
                    if (response.status == 'success') {
                        $('#crm_name').html(response.html);
                        $('#process_status_list').html('');
                    }
                    if(response.status == 'fail')
                    {
                        $('#process_status_list').text('CRM Not Found').addClass('text-danger');
                        $('#crm_name').html(response.html);
                    }
                }
             });
        });
    </script>
<script>
$(function(){
  $('#quickForm').validate({
    rules: {
      crm_type: {
        required: true,
      },
      crm_name: {
        required: true,
      },
      date_from: {
        required: true,
      },
      date_to: {
        required: true,
      },
      status_by:{
        required: true,
      },
      record_by:{
        required: true,
      }
    },
    errorElement: 'span',
        errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
        }
    });
});
</script>

@endsection
