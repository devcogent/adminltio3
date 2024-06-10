@extends('frount.index')
@section('content')
    <?php $checkYes = 0; ?>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h5>Manage Filed Dependencies <a href="{{ route('crmmaster') }}"
                                    class="btn  btn-danger btn-sm float-right"> <i class="fa fa-arrow-circle-left"
                                        aria-hidden="true"></i> &nbsp;Go Back</a></h5>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <form role="form" id="quickForm" name="createForm" action="{{ url('saveDependFiled') }}"
                                    method="POST">
                                    @csrf
                                    <div class="x_panel">
                                        <div class="x_content">
                                            <div class="row">
                                                <div class="col-md-3 col-sm-12 col-xs-12 form-group" style="width: 25%">
                                                    <label>CRM AGENT INPUT</label>
                                                </div>
                                                <div class="col-md-3 col-sm-12 col-xs-12 form-group op1" style="width: 25%">
                                                    <label>DEPENDED FILED</label>
                                                </div>
                                                <div class="col-md-3 col-sm-12 col-xs-12 form-group dp1" style="width: 25%">
                                                    <label>TO DROPDOWN</label>
                                                </div>
                                                <div class="col-md-3 col-sm-12 col-xs-12 form-group op1" style="width: 25%">
                                                    <label>TO OPTION</label>
                                                </div>

                                            </div>
                                            <div id="mainRow">
                                                <div class="row" id="FieldRow">

                                                    <div class="col-md-3 col-sm-12 col-xs-12 form-group" style="width: 25%">
                                                        <select class="form-control select2bs4 filedTypecheck"
                                                            style="width: 100%;" name="crm_id" id="crm_id" required
                                                            fieldcounter=0 onchange="getDropdown(this.value)"
                                                            value="{{ old('crm_id') }}">
                                                            <option value="" selected="selected">--Select--</option>
                                                            @foreach ($data['get_crm'] as $get_crm_rows)
                                                                <option value="{{ $get_crm_rows->crm_name }}_agent_input">
                                                                    {{ $get_crm_rows->crm_name }}_agent_input</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 col-sm-12 col-xs-12 form-group" style="width: 25%">
                                                        <select class="form-control select2bs4 filedTypecheck"
                                                            style="width: 100%;" name="dropdown_id_from"
                                                            id="dropdown_id_from" required fieldcounter=0>
                                                            <option value="" selected>--Select--</option>
                                                        </select>
                                                    </div>

                                                    {{-- <div class="col-md-3 col-sm-12 col-xs-12 form-group" style="width: 25%">
                                        <select class="form-control select2bs4 filedTypecheck" style="width: 100%;" name="depend_status" id="depend_status" required fieldcounter=0 onchange="dependStatus(this.value)">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div> --}}
                                                    <div class="col-md-3 col-sm-12 col-xs-12 form-group" style="width: 25%">
                                                        <select class="form-control select2bs4 filedTypecheck"
                                                            style="width: 100%;" name="dropdown_id" id="dropdown_id"
                                                            required fieldcounter=0 onchange="getOptions(this.value)">
                                                            <option value="" selected>--Select--</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 col-sm-12 col-xs-12 form-group" style="width: 25%">
                                                        <select class="form-control select2bs4 filedTypecheck"
                                                            style="width: 100%;" name="option_id" id="option_id" required
                                                            fieldcounter=0>
                                                            <option value="" selected>--Select--</option>
                                                        </select>
                                                    </div>




                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row" align="center">
                                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                                    <button type="submit" id="btnSubmit" class="btn btn-success "
                                                        counter=0>Save </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div></div>
                                </form>
                            </div>
                        </div>
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
                                                <h5>Dependencies List</h5>
                                            </div>
                                            <div class="card-body">

                                                <table id="example1" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Action</th>
                                                            <th>Crm Form</th>

                                                            <th>Drop Down</th>
                                                            <th>Drop Down Value</th>
                                                            <th>Child Filed</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>


                                                        @foreach ($data['crm_filed_dependencie'] as $crm_keys => $crm_filed_dependencie)
                                                            @foreach ($crm_filed_dependencie as $qwe)
                                                                <tr>
                                                                    <?php
                                                                    $url = $qwe->id . '/' . $data['crm'][$crm_keys];
                                                                    ?>
                                                                    <td><a href="{{ url('/deleteDependencie/' . $url) }}"
                                                                            onclick="return confirm('Are you sure?')"
                                                                            class="btn btn-danger btn-sm"
                                                                            data-toggle="tooltip" data-placement="top"
                                                                            title="Delete" style="font-size: 10px;"> <i
                                                                                class="fa fa-trash"></i> </a></td>
                                                                    <?php $crm = App\Models\CrmForm::where('id', $qwe->crm_id)->first(); ?>
                                                                    <td>{{ $data['crm'][$crm_keys] }}</td>

                                                                    <td>{{ $qwe->dropdown_id }}</td>
                                                                    <td>{{ $qwe->option_id }}</td>
                                                                    <td>{{ $qwe->dropdown_id_from }}</td>
                                                                </tr>
                                                            @endforeach
                                                        @endforeach
                                                    </tbody>
                                                </table>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>
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


            getDropdownMakeDepend(id)

            $.ajax({
                url: "{{ url('crm-get-dropdown-manage-filed') }}",
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



        function getDropdownMakeDepend(id) {

            // id = $("#crm_id").val();

            $.ajax({
                url: "{{ url('crm-get-dropdown-make-depend') }}",
                type: 'get',
                data: {
                    "id": id,
                },
                success: function(response) {
                    if (response) {
                        $('#dropdown_id_from').html(response);
                    } else {
                        $('#dropdown_id_from').html('No Data Found');
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
                url: "{{ url('crm-get-dropdown-option-depend') }}",
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
    </script>

@endsection
