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

                            <form
                                action="{{ url(Request::segment(1) . '/agent-reports', ['crmID' => $crmID, 'crmFrm' => $crmFrm]) }}"
                                method="POST" id="quickForm">

                                {{ csrf_field() }}
                                <input type="hidden" name="crm_name" value="{{ $crmID }}">
                                <input type="hidden" name="crm_form" value="{{ $crmFrm }}">
                                <div class="row">
                                @php
                                    $selecteddate_from = date("d-m-Y", strtotime($selecteddate_from));
                                    $selecteddate_to = date("d-m-Y", strtotime($selecteddate_to));
                                @endphp
                                    <div class="form-group col-md-2">
                                        <label>Date From</label>
                                            <div class="input-group date" id="reservationdate2" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input" name="date_from" value="{{ $selecteddate_from }}" data-target="#reservationdate2">
                                            <div class="input-group-append" data-target="#reservationdate2" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label>Date From</label>
                                            <div class="input-group date" id="reservationdate1" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input" name="date_to" value="{{ $selecteddate_to }}" data-target="#reservationdate1">
                                            <div class="input-group-append" data-target="#reservationdate1" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group col-md-2">
                                        <label></label>
                                        <input type="submit" class="btn btn-success" value="Get Data" style="margin-top: 2rem !important;" />


                                    </div>

                                </div>
                        </div>

                        <div id="process_status_list">
                        </div>
                        </form>
                    </div>


                </div>
            </div>

            @if (!empty($finalDatas))
                <section class="content">
                    <div class="container-fluid">
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
                                                    @if (Auth::user()->user_access == 1)
                                                        <th>Edit</th>
                                                    @endif
                                                    <?php
                                                    foreach ($finalDatas as $key => $data) {
                                                        foreach ((array) $data as $k => $v) {
                                                            if ($k != 'created_by') {
                                                                echo '<th>' . strtoupper(str_replace('_',' ',$k)) . '</th>';
                                                            }
                                                        }
                                                        break;
                                                    } ?>
                                                    {{-- <th>Cti</th> --}}
                                                    @if (!empty($cti_page))
                                                        <th>Get Cti</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @php
                                                    $i = 1;
                                                    $current_uri = request()->segments();
                                                    $tid = $current_uri[1];
                                                @endphp
                                                <?php
                                                if (!empty($cti_page)) {
                                                    $cti = 'cti-page/' . $cti_page[0]->form_name;
                                                    $open_cti = 'open-cti-page/' . $cti_page[0]->form_name;
                                                } else {
                                                    $cti = '#';
                                                    $open_cti = '#';
                                                }
                                                foreach ($finalDatas as $key => $data) {
                                                    $id = Crypt::encryptString($data->id);
                                                    $url = URL::to('/');
                                                    echo '<tr>';

                                                    if (Auth::user()->user_access == 1) {
                                                        echo '<td><a target="_blank" href="' . $url . '/' . Request::segment(1) . '/' . $tablename . '/edit/' . $id . '" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="" style="font-size: 10px;" data-original-title="Edit"> <i class="fa fa-edit"></i> </a></td>';
                                                    }
                                                    $url_q = '';
                                                    foreach ((array) $data as $k => $v) {
                                                        if ($k == 'created_at' || $k == 'updated_at') {
                                                            echo '<td >' . date('Y-m-d h:i:s', strtotime($v)) . '</td>';
                                                        } else {
                                                            if ($k != 'created_by') {
                                                                echo '<td >' . strtoupper($v) . '</td>';
                                                            }

                                                            if (!empty($is_unique)) {
                                                                foreach ($is_unique as $u_key => $u_data) {
                                                                    if ($is_unique[$u_key]->field_name == $k) {
                                                                        $url_q .= $is_unique[$u_key]->field_name . '=' . $data->$k . '&';
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }

                                                    $url_q = substr($url_q, 0, -1);

                                                    if (!empty($cti_page)) {
                                                        echo '<td><a href="' . url($open_cti) . '?' . 'userid=' . Auth::user()->emp_id . '&' . $url_q . '" style="color:rgb(69, 69, 244)" target="_blank">Click</a></td>';
                                                    }
                                                    echo '</tr>';
                                                } ?>

                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endif
        </div>
    </section>
    </div>
    </div>


    <script>

        $("#crm_name").change(function() {
            var crm_id = $(this).val();
            $('#process_status_list').html('');
            $('#process_status_list').html(
                'Please Wait <i class="fa fa-spinner fa-spin" style="font-size:30px"></i>');
            $.ajax({
                url: "{{ route('getcrmForm') }}",
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

<script>

$(function(){

  
$('#quickForm').validate({
    rules: {
       date_from: {
        required: true,
      },
      date_to: {
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
