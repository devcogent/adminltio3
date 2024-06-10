@extends('frount.index')

@section('content')
<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Reports </h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form action="{{route('agent-reports',['crmID' => $crmID, 'crmFrm' => $crmFrm])}}" method="POST" id="myform">

                            {{ csrf_field() }}
                            <input type="hidden" name="crm_name" value="{{ $crmID }}">
                            <input type="hidden" name="crm_form" value="{{ $crmFrm }}">
                            <div class="row">
                                <!-- <div class="form-group col-md-3">
                                    <label>Select CRM </label>
                                    <select class="form-control select2bs4 " style="width: 100%;" name="crm_name" id="crm_name" required>
                                        <option value="">Select CRM </option>
                                        @foreach($crm_name as $st)
                                        <option value="{{$st->id}}">{{$st->crm_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Select Form </label>
                                    <select class="form-control select2bs4 " style="width: 100%;" name="crm_form" id="crm_form" required>
                                        <option value="" selected>Select Form </option>

                                    </select>
                                </div> -->
                                <div class="form-group col-md-2">
                                    <label>Date From </label>
                                    <input type="date" name="date_from" class="form-control" value="{{$selecteddate_from}}" required />
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Date To </label>
                                    <input type="date" name="date_to" class="form-control" value="{{$selecteddate_to}}" required />
                                </div>
								<div class="form-group col-md-2">
								<label>Action </label>
                                    <input type="submit"  class="form-control btn btn-success" value="Get Data" />
                                </div>
                            </div>
                            <div class="row">
                                

                            </div>
                            <div id="process_status_list">
                            </div>
                        </form>


                        @if(!empty($finalDatas))
                        <table id="datatable1" class="table table-striped table-bordered">
                            <thead>

                                <tr>
                                    <th>Edit</th>
                                    <?php
                                    foreach ($finalDatas as $key => $data) {
                                        // print_r((array)$data);
                                        foreach ((array)$data as $k => $v) {
                                            if ($k != "created_by") {
                                                echo '<th>' . strtoupper($k) . '</th>';
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
                                     //print_r((array)$data);die;
                                    $id = Crypt::encryptString($data->id);
                                    $url = URL::to('/');
                                    echo "<tr>";
                                    echo '<td><a target="_blank" href="'.$url.'/'.$tablename.'/edit/'.$id.'" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="" style="font-size: 10px;" data-original-title="Edit"> <i class="fa fa-edit"></i> </a></td>';
                                    foreach ((array)$data as $k => $v) {
                                        if ($k != "created_by") {
                                            echo '<td>' . strtoupper($v) . '</td>';
                                        }
                                    }
                                    echo "</tr>";
                                } ?>

                            </tbody>

                        </table>
                        @endif
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $("#crm_name").change(function() {
        var crm_id = $(this).val();
        $('#process_status_list').html('');
        $('#process_status_list').html('Please Wait <i class="fa fa-spinner fa-spin" style="font-size:30px"></i>');
        $.ajax({
            url: "{{route('getcrmForm')}}",
            type: 'POST',
            data: {
                "crm_id": crm_id,
                "_token": "{{ csrf_token() }}",
            },
            success: function(response) {
                if (response.status == 'success') {
                    $('#crm_form').html(response.html);
                    $('#process_status_list').html('');
                }
            },
            error: function(response) {
                window.console.log(response);
            }
        });

    });
	
	
</script>

@endsection