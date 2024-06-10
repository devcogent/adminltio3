 <!-- Begin Footer Area -->

 <div class="modal fade bs-example-modal" id="changepassword" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-lg">
     <div class="modal-content" align="center" style="width:60%;margin-left: 23%;">
       <div class="modal-header">
         <h4 class="modal-title">Change Password</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>
       <form method="POST" id="chnageForm" name="chnageForm" action="{{route('updatePassword')}}">
         <input type="hidden" name="_token" value="{{ csrf_token() }}">
         <input type="hidden" name="emp_id" value="{{ Auth::user()->emp_id }}">
         <div class="form-group row">

           </br>
           <div class="form-group" align="center">
             <label for="new_password" class="col-md-4 col-form-label">{{ __('New password') }}</label>
             <input id="new_password" name="new_password" type="password" class="form-control changepassword" required autofocus style="width: 50%;">
             @if ($errors->has('new_password'))
             <span class="help-block error invalid-feedback">
               <strong>{{ $errors->first('new_password') }}</strong>
             </span>
             @endif
           </div>
         </div>
         <div class="form-group row">


           <div class="form-group" align="center">
             <label for="password_confirm" class="col-md-4 col-form-label">{{ __('Confirm password') }}</label>

             <input id="password_confirm" name="password_confirm" type="password" class="form-control changepassword" required autofocus style="width: 50%;">
             @if ($errors->has('password_confirm'))
             <span class="help-block error invalid-feedback">
               <strong>{{ $errors->first('password_confirm') }}</strong>
             </span>
             @endif
           </div>
         </div>
         </hr>
         <div class="form-group login-row row mb-0" align="center">
           <div class="col-md-12">

             <input type="submit" name="submit" value="Submit" class="btn btn-primary" style="margin-bottom:20px" />
           </div><br>
         </div>
       </form>
     </div>
     <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
 </div>
 <div class="footer-area" data-bg-image="{{ asset('public/assets/images/footer/bg/1-1920x465.jpg')}}">
    <?php

    if(!empty(Session::get('footer_text'))) {
        $footer_text = Session::get('footer_text');
    }else {
        $footer_text = 'Copyright <a href="https://cogenteservices.com">Cogent E-Services</a>| All Rights Reserved';
    }
    ?>
   <!-- footer content -->
   <footer>
     <div class="pull-right">
       {!! $footer_text !!}
     </div>
     <div class="clearfix"></div>
   </footer>
   <!-- /footer content -->
 </div>
 </div>


 <!-- jQuery -->

 <!-- Bootstrap -->
 <script src="{{ asset('public/vendors/bootstrap/dist/js/bootstrap.min.js')}}"></script>
 <!-- FastClick -->
 <script src="{{ asset('public/vendors/fastclick/lib/fastclick.js')}}"></script>
 <!-- NProgress -->
 <script src="{{ asset('public/vendors/nprogress/nprogress.js')}}"></script>
 <!-- Chart.js -->

 <!-- bootstrap-progressbar -->
 <script src="{{ asset('public/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js')}}"></script>
 <!-- iCheck -->
 <script src="{{ asset('public/vendors/iCheck/icheck.min.js')}}"></script>
 <!-- Skycons -->
 <script src="{{ asset('public/vendors/skycons/skycons.js')}}"></script>
 <!-- Flot -->
 <script src="{{ asset('public/vendors/Flot/jquery.flot.js')}}"></script>
 <script src="{{ asset('public/vendors/Flot/jquery.flot.pie.js')}}"></script>
 <script src="{{ asset('public/vendors/Flot/jquery.flot.time.js')}}"></script>
 <script src="{{ asset('public/vendors/Flot/jquery.flot.stack.js')}}"></script>
 <script src="{{ asset('public/vendors/Flot/jquery.flot.resize.js')}}"></script>
 <!-- Flot plugins -->

 <!-- DateJS -->
 <script src="{{ asset('public/vendors/DateJS/build/date.js')}}"></script>

 <!-- bootstrap-daterangepicker -->
 <script src="{{ asset('public/vendors/moment/min/moment.min.js')}}"></script>

 <!-- Custom Theme Scripts -->
 <script src="{{ asset('public/build/js/custom.min.js')}}"></script>
 @if ($message = Session::get('success'))
 <script>
   toastr.success('{{ $message }}')
 </script>
 @endif
 @if ($message = Session::get('error'))
 <script>
   toastr.error('{{ $message }}')
 </script>
 @endif

<script>
$('#datatable1').dataTable({
    dom: 'Bfrtip',
    buttons: [
      'excelHtml5',
    ],
    "scrollX": true
    //scrollX: 300,
    //responsive: true,

  });
</Script>
 </body>

 </html>
