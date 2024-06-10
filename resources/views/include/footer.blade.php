

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                 <h6><b>Change Password</b></h6>
            </div>
            <div class="modal-body">
               
                <div class="form-group">
                    <label for="exampleInputEmail1">Old Password</label>
                    <input type="password" class="form-control" name="old_pass" id="old_pass"
                        aria-describedby="emailHelp" placeholder="Old Password">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">New Password</label>
                    <input type="password" class="form-control" name="new_pass" id="new_pass"
                        placeholder="New Password">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Confirm Password</label>
                    <input type="password" class="form-control" name="conf_pass" id="conf_pass"
                        placeholder="Confirm Password">
                </div>
                @if (Auth::user()->emp_type == 'admin' || Auth::user()->emp_type == 'super_admin')
                    <button type="submit" class="btn btn-primary" onclick="changePassword()">Submit</button>
                    <p id="send_error_message"></p>
                @else
                    <button type="submit" class="btn btn-primary" onclick="changePasswordCti()">Submit</button>
                    <p id="send_error_message"></p>
                @endif
              
            </div>
        </div>
    </div>
</div>


@php $crm_get_name = Request::segment(1); @endphp

<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 2.0
    </div>
    <strong>&copy; 2022-2023 <a href="javascript:void(0)">Cogent E Services</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
</div>
  <!-- /.control-sidebar -->
<!-- ./wrapper -->

<!-- jQuery -->

<!-- Ekko Lightbox -->
<script src="{{asset('public/plugins/ekko-lightbox/ekko-lightbox.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('public/dist/js/adminlte.min.js')}}"></script>
<!-- Filterizr-->
<script src="{{asset('public/plugins/filterizr/jquery.filterizr.min.js')}}"></script>
<script src="{{asset('public/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('public/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- DataTables  & Plugins -->
<script src="{{asset('public/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('public/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('public/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('public/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('public/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('public/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('public/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('public/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('public/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('public/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('public/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<script src="{{asset('public/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{asset('public/plugins/jquery-validation/additional-methods.min.js')}}"></script>
<script src="{{asset('public/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<script src="{{asset('public/plugins/dropzone/min/dropzone.min.js')}}"></script>
<!-- Toastr -->
<script src="{{asset('public/plugins/toastr/toastr.min.js')}}"></script>
<!-- Bootstrap 4 -->
<!-- Select2 -->
<script src="{{asset('public/plugins/select2/js/select2.full.min.js')}}"></script>

<!-- Bootstrap4 Duallistbox -->
<script src="{{asset('public/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js')}}"></script>
<!-- InputMask -->
<script src="{{asset('public/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('public/plugins/inputmask/jquery.inputmask.min.js')}}"></script>
<!-- date-range-picker -->
<script src="{{asset('public/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- bootstrap color picker -->
<script src="{{asset('public/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('public/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Bootstrap Switch -->
<script src="{{asset('public/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>
<!-- BS-Stepper -->
<script src="{{asset('public/plugins/bs-stepper/js/bs-stepper.min.js')}}"></script>
<!-- dropzonejs -->
<script src="{{asset('public/plugins/dropzone/min/dropzone.min.js')}}"></script>
<script src="{{asset('public/plugins/summernote/summernote-bs4.min.js')}}"></script>


<script>
    $(document).ready(function() {
        toastr.options.timeOut = 3000;
        @if (Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @elseif (Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @elseif (Session::has('info'))
            toastr.info("{{ Session::get('info') }}");
        @endif
    });





</script>
<script>
    @if(Session::has('message'))
        var type="{{Session::get('alert-type','info')}}";
        switch(type){
            case 'info':
                 toastr.info("{{ Session::get('message') }}");
                 break;
            case 'success':
                toastr.success("{{ Session::get('message') }}");
                break;
             case 'warning':
                toastr.warning("{{ Session::get('message') }}");
                break;
            case 'error':
                toastr.error("{{ Session::get('message') }}");
                break;
        }
    @endif
</script>


 <script type="text/javascript">
   $(function () {

    $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });

     $('#reservationdate1').datetimepicker({
        format: 'DD-MM-YYYY'
    });

     $('#reservationdate2').datetimepicker({
        format: 'DD-MM-YYYY'
    });


    $('#timepicker').datetimepicker({
        format: 'LT'
      })

     $("#example1").DataTable({
       "responsive": true, "lengthChange": false, "autoWidth": false,
       "buttons": ["csv", "excel"]
     }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

     $('#example2').DataTable({
       "paging": true,
       "lengthChange": false,
       "searching": false,
       "ordering": true,
       "info": true,
       "autoWidth": false,
       "responsive": true,
     });
    });
</script>

<script>
    function changePassword() {

        old_pass = $('#old_pass').val();
        new_pass = $('#new_pass').val();
        conf_pass = $('#conf_pass').val();

        if (old_pass == '' || new_pass == '' || conf_pass == '') {
            $('#send_error_message').text('* All Filed Are Required').css('color', 'red');
        } else {
            $.ajax({
                url: "{{ url('updatePassword') }}",
                type: 'POST',
                data: {
                    old_pass: old_pass,
                    new_pass: new_pass,
                    conf_pass: conf_pass,
                   _token: '{!! csrf_token() !!}',
                },
                success: function(result) {

                    if (result == 0) {
                            $('#send_error_message').text('Old password Not Match').css('color', 'red');
                            toastr.error("Old passsword Not Match !");
                        } else if (result == 1) {
                            $('#send_error_message').text('* Confirm password Not Match').css('color', 'red');
                            toastr.error("Confirm password Not Match !");
                        } else {
                            toastr.success("Password Updated Successfully !");
                            $('#exampleModal').modal('hide');
                            setTimeout(location.reload(), 1000);
                        }

                }
            });
            $('#send_error_message').text('Please Wait ..').css('color', 'blue');
        }

    }

    function changePasswordCti() {

        old_pass = $('#old_pass').val();
        new_pass = $('#new_pass').val();
        conf_pass = $('#conf_pass').val();

        if (old_pass == '' || new_pass == '' || conf_pass == '') {
            $('#send_error_message').text('* All Filed Are Required').css('color', 'red');
        } else {
            $.ajax({
                url: "{{ url($crm_get_name . '/' . 'updatePasswordCti') }}",
                type: 'POST',
                data: {
                    old_pass: old_pass,
                    new_pass: new_pass,
                    conf_pass: conf_pass,
                    _token: '{!! csrf_token() !!}',
                },
                success: function(result) {

                    if (result == 0) {
                            $('#send_error_message').text('Old password Not Match').css('color', 'red');
                            toastr.error("Old password Not Match !");
                    } else if (result == 1) {
                            $('#send_error_message').text('* Confirm password Not Match').css('color', 'red');
                            toastr.error("Confirm password Not Match !");
                    } else {
                            toastr.success("Password Updated Successfully !");
                            $('#exampleModal').modal('hide');
                            setTimeout(location.reload(), 1000);
                    }

                }
            });
            $('#send_error_message').text('Please Wait ..').css('color', 'blue');
        }

    }
</script>
</body>
</html>
