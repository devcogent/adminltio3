@extends('frount.index')

@section('content')
<?php $checkYes = 0; ?>
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
           <div class="card card-info">
            <div class="card-header">
                <h5>API DOCUMENTATION:- {{strtoupper($crmform->form_name)}}  <a href="{{route('crmmaster')}}" class="btn  btn-danger btn-sm float-right"> <i class="fa fa-arrow-circle-left" aria-hidden="true"></i> &nbsp;Go Back</a></h5>
             </div>
             <div class="card-body">
                         <?php  $db = explode('_client_data',$crmform->form_name)[0]; ?>
                        <div class="jumbotron">
                        <h4 class="display-4">1. Genrate Token APi</h4>
                        <span class="lead"> <span style="color:rgb(163, 48, 48)"> Url: </span> {{ url($db.'/login-api')  }}</span><br><br>
                        <span class="lead"><span style="color:rgb(163, 48, 48)">Method: </span> GET</span><br><br>
                        <span class="lead"><span style="color:rgb(163, 48, 48)">Parameters: </span> emp_id, password</span><br><br>
                        <span class="lead"><span style="color:rgb(163, 48, 48)">Request:</span> curl --location --request GET {{ url($db.'/login-api')}} \<br>
                            --header 'Content-Type: application/json' \
                            <br>
                            --data-raw '{
                                "emp_id": {{ Auth::user()->emp_id; }},
                                "password": ********
                        }'</span>
                        <br><br>
                        <span class="lead"><span style="color:rgb(163, 48, 48)">Response:
                        </span><br>
                        {<br>
                            "success": true,<br>
                            "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.<br>eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3RcL2NvZ2VudC1mb3<br>JtXC9sb2dpbi1hcGkiLCJpYXQiOjE2Nj<br>gyMzYzNTIsImV4cCI6MTY2ODIzNjQxMiwibmJmIjoxNjY4Mj<br>Uyek5wS3V3Iiwic3ViIjoyMDUsInBydiI6IjIzYmQ<br>1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3M<br>mRiN2E1OTc2ZjcifQ.xNvNBUGnZaFL_SaDtQnRwe5LCn0-f"<br>
                        }
                       </span><br><br><br>
                       <span style="color:rgb(163, 48, 48)">Note:- Token will be expire genrate after 1 hour.</span>
                        <hr>

                        <h4 class="display-4">2. Upload Cleint Data APi</h4>
                        <span class="lead"><span style="color:rgb(163, 48, 48)">Url:</span> {{ url($db.'/SubmitAgentApi',$crmform->form_name)  }}</span><br><br>
                        <span class="lead"><span style="color:rgb(163, 48, 48)">Method:</span>  POST </span><br><br>
                        <span class="lead"><span style="color:rgb(163, 48, 48)">Parameters:</span>
                         <?php $para ='';
                        foreach ($crm_fields as $parameters ) {
                                $para .= $parameters->field_name.', ';
                               }
                          ?>
                        {{ $para }}
                        </span><br><br>
                        <span class="lead"><span style="color:rgb(163, 48, 48)">Request:</span> curl --location --request POST '{{ url($db.'/SubmitAgentApi',$crmform->form_name)  }}' \<br>
                        --header 'Accept: application/json' \<br>
                        --header 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlw<br>vXC9sb2NhbGhvc3RcL2NvZ2VudC1mb3JtXC9sb2dpbi1h<br>cGkiLCJpYXQiOjE2NjgyMzYzNTIsImV4cCI6MTY2ODIzNjQxM<br>iwibmJmIjoxNjY4MjM2MzUyLCJqdGkiOiJ2SEpwRHVqdUUyek5wS3V3Iiwic3' \<br>

                        @foreach ($crm_fields as $parameters )
                          --form '{{ $parameters->field_name }}="Test Data"'  \<br>
                        @endforeach
                       </span>
                        <br><br>

                        <span class="lead"><span style="color:rgb(163, 48, 48)">Success Response:
                        </span><br>
                        {<br>
                           &nbsp;&nbsp;&nbsp;&nbsp; "status": "success",<br>
                           &nbsp;&nbsp;&nbsp;&nbsp; "msg": "Data Insert Successfully"<br>
                        }
                       </span>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</div>
<!-- /page content -->
<?php if ($checkYes == 1) { ?>
    <script type="text/javascript">
        $('#quickForm').on('submit', function() {
            checked = $("input[type=checkbox]:checked").length;
            if (!checked) {

                alert("You must check at least one checkbox.");
                return false;
            }


        });
    </script>
<?php } ?>


@endsection
