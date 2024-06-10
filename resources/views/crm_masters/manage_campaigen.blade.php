@extends('frount.index')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h5>Manage Campaign (NGUCCC)</h5>
                    </div>
                    <div class="card-body">
                    <form role="form" id="quickForm" name="createForm" action="{{ url('saveCampaigen') }}" method="POST">
                        @csrf
                                <div id="mainRow">
                                    <div class="row" id="FieldRow">

                                        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                            <label>CAMPAIGN</label>
                                            <input autofocus type="text" required placeholder="Enter Campaign Name"
                                                class="form-control" name="camp_name" value="{{ old('camp_name') }}">
                                            <input type="hidden" name="crm_type" value="1">
                                        </div>


                                        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                            <label>Domain</label>
                                            <input type="text" required placeholder="Enter Domain Name"
                                                class="form-control" name="domain_name" value="{{ old('domain_name') }}">
                                        </div>

                                        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                            <label>Skill</label>
                                            <input type="text" required placeholder="Enter Skill Name"
                                                class="form-control" name="skill_name" value="{{ old('skill_name') }}">
                                        </div>

                                        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                            <label>Q NAME</label>
                                            <input type="text" required placeholder="Enter Q Name" class="form-control"
                                                name="q_name" value="{{ old('q_name') }}">
                                        </div>

                                        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                            <label>LIST NAME</label>
                                            <input type="text" required placeholder="Enter List Name"
                                                class="form-control" name="list_name" value="{{ old('list_name') }}">
                                        </div>


                                        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                            <label>API URL</label>
                                            <input type="text" required placeholder="Enter Api Url" class="form-control"
                                                name="api_url" value="{{ old('api_url') }}">
                                        </div>

                                        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                            <label>CRM</label>
                                            <select class="form-control select2bs4 filedTypecheck" style="width: 100%;"
                                                name="crm_id" id="crm_id" required fieldcounter=0
                                                onchange="getDropdownDiff(this.value)" value="{{ old('crm_id') }}">
                                                <option value="" selected="selected">--Select--</option>
                                                @foreach ($data['get_crm'] as $get_crm_rows)
                                                    <option value="{{ $get_crm_rows->crm_name }}_client_data">
                                                        {{ $get_crm_rows->crm_name }}_client_data</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>

                                </div>


                                <section class="content">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="card card-info">
                                                    <div class="card-header">
                                                        <h6>Additional Parameters</h6>
                                                    </div>
                                                    <div class="card-body">

                                <div class="row">
                                    <div class="col-md-4 col-lg-4 col-sm-4">
                                        <div class="form-group">
                                            <input type="text" placeholder="Enter Parameters Name"
                                                class="form-control" name="enter_parameters[]"
                                                value="{{ old('enter_parameters') }}">
                                        </div>
                                        <div class=" form-group">
                                            <select class="form-control select2bs4 filedTypecheck" style="width: 100%;"
                                                name="option_unique[]" id="option_unique_one" fieldcounter=0>
                                                <option value="" selected>--Select--</option>
                                            </select>
                                        </div>

                                        <div class=" form-group">
                                            <input type="text" placeholder="Enter Parameters Name"
                                                class="form-control" name="enter_parameters[]"
                                                value="{{ old('enter_parameters') }}">
                                        </div>
                                        <div class=" form-group">
                                            <select class="form-control select2bs4 filedTypecheck" style="width: 100%;"
                                                name="option_unique[]" id="option_unique_two" fieldcounter=0>
                                                <option value="" selected>--Select--</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <input type="text" placeholder="Enter Parameters Name"
                                                class="form-control" name="enter_parameters[]"
                                                value="{{ old('enter_parameters') }}">
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control select2bs4 filedTypecheck" style="width: 100%;"
                                                name="option_unique[]" id="option_unique_seven" fieldcounter=0>
                                                <option value="" selected>--Select--</option>
                                            </select>
                                        </div>


                                    </div>
                                    <div class="col-md-4 col-lg-4 col-sm-4">
                                        <div class=" form-group">
                                            <input type="text" placeholder="Enter Parameters Name"
                                                class="form-control" name="enter_parameters[]"
                                                value="{{ old('enter_parameters') }}">
                                        </div>
                                        <div class=" form-group">
                                            <select class="form-control select2bs4 filedTypecheck" style="width: 100%;"
                                                name="option_unique[]" id="option_unique_three" fieldcounter=0>
                                                <option value="" selected>--Select--</option>
                                            </select>
                                        </div>


                                        <div class="form-group">
                                            <input type="text" placeholder="Enter Parameters Name"
                                                class="form-control" name="enter_parameters[]"
                                                value="{{ old('enter_parameters') }}">
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control select2bs4 filedTypecheck" style="width: 100%;"
                                                name="option_unique[]" id="option_unique_four" fieldcounter=0>
                                                <option value="" selected>--Select--</option>
                                            </select>
                                        </div>



                                    </div>
                                    <div class="col-md-4 col-lg-4 col-sm-4">
                                        <div class="form-group">
                                            <input type="text" placeholder="Enter Parameters Name"
                                                class="form-control" name="enter_parameters[]"
                                                value="{{ old('enter_parameters') }}">
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control select2bs4 filedTypecheck" style="width: 100%;"
                                                name="option_unique[]" id="option_unique_five" fieldcounter=0>
                                                <option value="" selected>--Select--</option>
                                            </select>
                                        </div>



                                        <div class="form-group">
                                            <input type="text" placeholder="Enter Parameters Name"
                                                class="form-control" name="enter_parameters[]"
                                                value="{{ old('enter_parameters') }}">
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control select2bs4 filedTypecheck" style="width: 100%;"
                                                name="option_unique[]" id="option_unique_six" fieldcounter=0>
                                                <option value="" selected>--Select--</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>









                                <div class="row" align="center">
                                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                        <button type="submit" id="btnSubmit" class="btn btn-success " counter=0>Save
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </form>
                </div>
            </div>
    </div>
</section>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h5>Manage Campaign (VERV)</h5>
                                </div>
                                <div class="card-body">

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <form role="form" id="quickForm" name="createForm" action="{{ url('saveCampaigen') }}"
                        method="POST">
                        @csrf
                                   <div id="mainRow">
                                    <div class="row" id="FieldRow">

                                        <div class="col-md-2 col-sm-12 col-xs-12 form-group" style="width: 10%">
                                            <label>CAMPAIGN </label>
                                            <input autofocus type="text" required placeholder="Enter Campaign Name"
                                                class="form-control" name="camp_name" value="{{ old('camp_name') }}">
                                            <input type="hidden" name="crm_type" value="2">

                                        </div>


                                        <div class="col-md-2 col-sm-12 col-xs-12 form-group" style="width: 10%">
                                            <label>TOKEN </label>
                                            <input type="text" required placeholder="Enter Tken Name"
                                                class="form-control" name="token_name" value="{{ old('token_name') }}">
                                        </div>

                                        <div class="col-md-2 col-sm-12 col-xs-12 form-group" style="width: 10%">
                                            <label>Q NAME</label>
                                            <input type="text" required placeholder="Enter Skill Name"
                                                class="form-control" name="skill_name" value="{{ old('skill_name') }}">
                                        </div>

                                        <div class="col-md-2 col-sm-12 col-xs-12 form-group" style="width: 10%">
                                            <label> FORMAT</label>
                                            <select class="form-control select2bs4 filedTypecheck" style="width: 100%;"
                                                name="date_format" id="date_format" required fieldcounter=0>
                                                <option value="" selected="selected">--Select--</option>
                                                <option value="dmY">D-M-Y</option>
                                                <option value="Ymd">Y-M-D</option>
                                            </select>
                                        </div>

                                        <div class="col-md-2 col-sm-12 col-xs-12 form-group" style="width: 10%">
                                            <label>LIST NAME</label>
                                            <input type="text" required placeholder="Enter List Name"
                                                class="form-control" name="list_name" value="{{ old('list_name') }}">
                                        </div>


                                        <div class="col-md-2 col-sm-12 col-xs-12 form-group" style="width: 10%">
                                            <label>API URL</label>
                                            <input type="text" required placeholder="Enter Api Url"
                                                class="form-control" name="api_url" value="{{ old('api_url') }}">
                                        </div>

                                        <div class="col-md-2 col-sm-12 col-xs-12 form-group" style="width: 10%">
                                            <label>CRM</label>
                                            <select class="form-control select2bs4 filedTypecheck" style="width: 100%;"
                                                name="crm_id" id="crm_id" required fieldcounter=0
                                                onchange="getDropdown(this.value)" value="{{ old('crm_id') }}">
                                                <option value="" selected="selected">--Select--</option>
                                                @foreach ($data['get_crm'] as $get_crm_rows)
                                                    <option value="{{ $get_crm_rows->crm_name }}_client_data">
                                                        {{ $get_crm_rows->crm_name }}_client_data</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-2 col-sm-12 col-xs-12 form-group" style="width: 10%">
                                            <label>DEPEND</label>
                                            <select class="form-control select2bs4 filedTypecheck" style="width: 100%;"
                                                name="depend_status" id="depend_status" required fieldcounter=0
                                                onchange="dependStatus(this.value)">
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-sm-12 col-xs-12 form-group" style="width: 10%">
                                            <label>DROPDOWN</label>
                                            <select class="form-control select2bs4 filedTypecheck" style="width: 100%;"
                                                name="dropdown_id" id="dropdown_id" required fieldcounter=0
                                                onchange="getOptions(this.value)">
                                                <option value="" selected>--Select--</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-sm-12 col-xs-12 form-group" style="width: 10%">
                                            <label>OPTION</label>
                                            <select class="form-control select2bs4 filedTypecheck" style="width: 100%;"
                                                name="option_id" id="option_id" required fieldcounter=0>
                                                <option value="" selected>--Select--</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row" align="center">
                                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                        <button type="submit" id="btnSubmit" class="btn btn-success " counter=0>Save
                                        </button>
                                    </div>
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
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h5>Campaign List</h5>
                                </div>
                                <div class="card-body">
                                <table id="example1" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th>Campaign Name</th>
                                            <th>Campaign Type</th>
                                            <th>Api Parameters</th>
                                            <th>Token</th>
                                            <th>Skill Name</th>
                                            <th>Q Name</th>
                                            <th>Date Format</th>
                                            <th>List Name</th>
                                            <th>Api Url</th>
                                            <th>Drop Down</th>
                                            <th>Options</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['crm_campaigns'] as $campaign_rows)
                                            <tr>
                                                <td><a href="{{ url('/deleteCampaign', $campaign_rows->id) }}"
                                                        onclick="return confirm('Are you sure?')"
                                                        class="btn btn-danger btn-sm" data-toggle="tooltip"
                                                        data-placement="top" title="Delete" style="font-size: 10px;"> <i
                                                            class="fa fa-trash"></i> </a></td>
                                                <td>{{ $campaign_rows->camp_name }}</td>
                                                <td>{{ $campaign_rows->crm_type == 2 ? 'VERV' : 'NGUCCC' }}</td>
                                                <td>{{ $campaign_rows->api_parameters }}</td>
                                                <td>{{ $campaign_rows->token_name }}</td>
                                                <td>{{ $campaign_rows->skill_name }}</td>
                                                <td>{{ $campaign_rows->q_name }}</td>
                                                <td>{{ $campaign_rows->date_format }}</td>
                                                <td>{{ $campaign_rows->list_name }}</td>
                                                <td>{{ $campaign_rows->api_url }}</td>
                                                <td>{{ $campaign_rows->dropdown_id }}</td>
                                                <td>{{ $campaign_rows->option_id }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function dependStatus(id) {
            if (id == '0') {
                $("#dropdown_id").hide();
                $("#option_id").hide();
                $(".dp1").hide();
                $(".op1").hide();
                $('#option_id').removeAttr('required');
                $('#dropdown_id').removeAttr('required');

            } else {
                $("#dropdown_id").show();
                $("#option_id").show();
                $(".dp1").show();
                $(".op1").show();
                $('#option_id').attr('required');
                $('#dropdown_id').attr('required');
            }

        }

        function getDropdown(id) {

            $.ajax({
                url: "{{ url('crm-get-dropdown') }}",
                type: 'get',
                data: {
                    "id": id,
                },
                success: function(response) {
                    if (response) {
                        $('#dropdown_id').html(response);
                    } else {
                        $('#dropdown_id').html('No Data Found');
                    }
                },
                error: function(response) {
                    window.console.log(response);
                }
            });


        }



        function getOptions(field_name) {

            crm_id = $("#crm_id").val();
            $.ajax({
                url: "{{ url('crm-get-dropdown-option') }}",
                type: 'get',
                data: {
                    "field_name": field_name,
                    "crm_id": crm_id
                },
                success: function(response) {
                    if (response) {
                        $('#option_id').html(response);
                    } else {
                        $('#option_id').html('No Data Found');
                    }
                },
                error: function(response) {
                    window.console.log(response);
                }
            });

        }



        function getDropdownDiff(crm_name) {

            crm_id = $("#crm_id").val();
            $.ajax({
                url: "{{ url('getUniquePara') }}",
                type: 'get',
                data: {
                    "crm_name": crm_name,
                },
                success: function(response) {
                    if (response) {
                        $('#option_unique_one').html(response);
                        $('#option_unique_two').html(response);
                        $('#option_unique_three').html(response);
                        $('#option_unique_four').html(response);
                        $('#option_unique_five').html(response);
                        $('#option_unique_six').html(response);
                        $('#option_unique_seven').html(response);
                    } else {
                        // $('#option_unique_one').html('No Data Found');
                        $('#option_unique_one').html('No Data Found');
                        $('#option_unique_two').html('No Data Found');
                        $('#option_unique_three').html('No Data Found');
                        $('#option_unique_four').html('No Data Found');
                        $('#option_unique_five').html('No Data Found');
                        $('#option_unique_six').html('No Data Found');
                        $('#option_unique_seven').html('No Data Found');
                    }
                },
                error: function(response) {
                    window.console.log(response);
                }
            });


        }
    </script>

@endsection
