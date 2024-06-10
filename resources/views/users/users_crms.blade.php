@extends('frount.index')

@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h5>Users CRM</h5>
                    </div>
                    <div class="card-body">
                                    <table id="example1" class="table table-striped table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <td>Id</td>
                                                <td>Crm Name</td>
                                                <td>Crm Type</td>
                                                <td>Creator By</td>
                                                <td>Creator type</td>
                                                <td>Created At</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($allCrms as $rows)
                                                <tr>
                                                    <th scope="row">{{ $rows->id }} </th>
                                                    <th scope="row">{{ $rows->crm_name }} </th>
                                                    <th scope="row">
                                                    {{ $rows->crm_type == 1 ? 'CLIENT DATA' : 'AGENT INPUT' }} </th>
                                                    <th scope="row">{{ $rows->emp_id }} </th>
                                                    <th scope="row">{{ $rows->emp_type }} </th>
                                                    <th scope="row">{{ $rows->created_at }} </th>
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
    </div>

<script>
          $(document).on('click', '.usercrm', function() {
            var userId = $(this).attr('userId');
            //alert(userId);
            $.ajax({
                url: "{{ route('getUserCrm') }}",
                type: 'POST',
                data: {
                    "user_id": userId,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(response) {
                    if (response.status == 'success') {
                        $('#usercrmlist').html(response.html);

                        $('#ModelId').click();
                        $("form[name='Submitusercrm']").find("input[name='USerid']:first").val(userId);
                    } else {
                        toastr.options.closeButton = true
                        toastr.options.tapToDismiss = true
                        toastr.options.timeOut = 0
                        toastr.options.extendedTimeOut = 0
                        toastr.warning('No crm Mapped Kindly Mapped')
                    }


                },
                error: function(response) {
                    window.console.log(response);
                }
            });
        });
    </script>
    <button type="button" style="display:none" class="btn btn-primary" data-toggle="modal"
        data-target=".bs-example-modalCrm" id="ModelId">Small modal</button>

    <div class="modal fade bs-example-modalCrm" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" align="center" style="width:60%;margin-left: 23%;">
                <form role="form" id="quickForm" action="{{ route('UserCrmUpdate') }}" method="POST"
                    name="Submitusercrm">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel2">Manage USER CRM</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control " id="USerid" name="USerid" autocomplete="off" />
                        <h4>Select CRM</h4>

                        <div class="row" id="usercrmlist">

                        </div>
                        </br></br></br>
                    </div>
                    <div class="modal-footer">
                        <div class="row" align="center">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">SUBMIT</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script>
            $("#city").select2({
                allowClear: true,
                width: 'resolve',
                placeholder: "Select CRM"

            });
        </script>
    </div>

    <script>
        function myfun(kbid, db) {
            var r = confirm("Do you really want to Delete?")
            if (r == true) {
                var appUrl = "{{ env('APP_URL') }}";
                window.location.href = `${appUrl}/users/delete/${kbid}/${db}`;
            } else {
                //nothing to do here
            }
        }
    </script>
@endsection
