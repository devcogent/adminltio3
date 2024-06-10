@extends('frount.index')
@section('content')
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
           <div class="card card-info">
            <div class="card-header">
                <h5>User List <a href="{{route('users.add')}}" class="btn  btn-success btn-sm float-right"> <i class="fas fa-plus"></i> Add User</a></h5>
             </div>
             <div class="card-body">
              <table id="example1" class="table table-striped table-bordered" width="100%">
                <thead>
                  <tr>
                    <td>Id</td>
                    <td>Action</td>
                    <td>Username</td>
                    <td>Name</td>
                    <td>Email</td>
                    <td>Employee Type</td>
                    <td>Process Name</td>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($all_users as $uers_couns)
                    @foreach ($uers_couns as $rows )
                    @if (Auth::user()->emp_type == "super_admin")
                        <?php

                             $process_name = env('DB_DATABASE');
                         ?>
                        @else
                        <?php

                             $process_name = $rows->process_name;
                         ?>
                    @endif
                      <tr>
                        <th scope="row">{{ $rows->id }} </th>
                        <th scope="row"><a href={{ url("users/edit/".$rows->id.'/'.$process_name) }} class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit" style="font-size: 10px;"> <i class="fa fa-edit"></i>  </a>
                          <a href="javascript:void(0)" id={{  $rows->id }}  onclick="myfun({{ $rows->id }},'{{ $process_name }}')"   class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Delete" style="font-size: 10px;"> <i class="fa fa-trash" ></i>  </a> </th>
                        <th scope="row">{{ $rows->emp_id }} </th>
                        <th scope="row">{{ $rows->name }} </th>
                        <th scope="row">{{ $rows->email }} </th>
                        <th scope="row">{{ $rows->emp_type }} </th>
                        <th scope="row">{{ $process_name }} </th>
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


<script type="text/javascript">
  $(document).ready(function() {


    // $('#userDel').on('click',function(e){
    //   alert("Are You Sure want to delete?");
    // });
    var row_count = $("#row_count").val();
    // DataTable
    var table = $('#empTable').DataTable({
      "dom": 'Blfrtip',
      buttons: [{
        extend: 'excel',
        text: '<button class="btn btn-sm"><i class="fa fa-file-excel" style="color: green;"></i>  Excel</button>',
        titleAttr: 'Excel',
        columns: [1],
        action: newexportaction,
        className: 'exportExcel',
        filename: 'User Master',

      }, ],
      processing: true,
      //pageLength: 25,
      serverSide: true,
      ajax: "{{route('users.getEmployees')}}",
      columns: [{
          data: 'id'
        },
        {
          data: 'actionButton'
        },
        {
          data: 'emp_id'
        },
        {
          data: 'name'
        },
        {
          data: 'email'
        },
        {
          data: 'emp_type'
        },
        {
          data: 'crm_name'
        },

      ],

      scrollX: 300,
      responsive: true,

    });

    function newexportaction(e, dt, button, config) {
      var self = this;
      var oldStart = dt.settings()[0]._iDisplayStart;
      dt.one('preXhr', function(e, s, data) {
        // Just this once, load all data from the server...
        data.start = 0;
        data.length = 2147483647;
        dt.one('preDraw', function(e, settings) {
          // Call the original action function
          if (button[0].className.indexOf('buttons-copy') >= 0) {
            $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
          } else if (button[0].className.indexOf('buttons-excel') >= 0) {
            $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
              $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
              $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
          } else if (button[0].className.indexOf('buttons-csv') >= 0) {
            $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
              $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
              $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
          } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
            $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
              $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
              $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
          } else if (button[0].className.indexOf('buttons-print') >= 0) {
            $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
          }
          dt.one('preXhr', function(e, s, data) {
            // DataTables thinks the first item displayed is index 0, but we're not drawing that.
            // Set the property to what it was before exporting.
            settings._iDisplayStart = oldStart;
            data.start = oldStart;
          });
          // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
          setTimeout(dt.ajax.reload, 0);
          // Prevent rendering of the full data to the DOM
          return false;
        });
      });
      // Requery the server with the new one-time export settings
      dt.ajax.reload();
    }
  });



  $(document).on('click', '.usercrm', function() {
    var userId = $(this).attr('userId');
    //alert(userId);
    $.ajax({
      url: "{{route('getUserCrm')}}",
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
<button type="button" style="display:none" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modalCrm" id="ModelId">Small modal</button>

<div class="modal fade bs-example-modalCrm" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" align="center" style="width:60%;margin-left: 23%;">
      <form role="form" id="quickForm" action="{{route('UserCrmUpdate')}}" method="POST" name="Submitusercrm">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
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
    function myfun(kbid,db) {
        var r = confirm("Do you really want to Delete?")
        if (r == true) {
            var appUrl = "{{env('APP_URL')}}";
            window.location.href = `${appUrl}/users/delete/${kbid}/${db}`;
        } else {
            //nothing to do here
        }
    }
</script>

@endsection
