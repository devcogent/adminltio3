@extends('frount.index')
@section('content')
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
           <div class="card card-info">
            <div class="card-header">
                <h5>Manage Branding  <a href="{{route('crmmaster')}}" class="btn  btn-danger btn-sm float-right"> <i class="fa fa-arrow-circle-left" aria-hidden="true"></i>&nbsp;Go Back</a></h5>
             </div>
             <div class="card-body">
                <form role="form" id="quickForm" name="createForm" action="{{url('saveBranding')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="x_panel">
                            &nbsp <b>Agent Login:- </b> <a href="{{url($dbname.'/login-user')}}" target="_blank">{{url($dbname.'/login-user')}}</a><hr>

                            {{--  <a href="{{url(explode('_crm',$dbname)[0].'/login-user')}}" target="_blank">{{url(explode('_crm',$dbname)[0].'/login-user')}}</a>  --}}


                        <div class="x_content">
                            <div class="row">
                            </div>
                            <div id="mainRow">
                                <div class="row" id="FieldRow">

                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                          <label for="pwd">Crm Title</label>
                                          <input type="text" name="crm_title" class="form-control" id="crm_title" value="{{ isset($brand_data->crm_title) ? $brand_data->crm_title: '' }}" >
                                          <input type="hidden" name="crm_id" class="form-control" value="@isset($dbname){{$dbname}}@endisset">
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                        <label for="email">Footer Text</label>
                                        <input type="text" name="footer_text" class="form-control" id="footer_text" value="{{ isset($brand_data->footer_text) ? $brand_data->footer_text: '' }}" required>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-2">
                                        <label for="email">Height</label>
                                        <input type="number" name="height_img" class="form-control"  value="{{ isset($brand_data->height_img) ? $brand_data->height_img: '' }}" required>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-2">
                                        <label for="email">Width</label>
                                        <input type="number" name="width_img" class="form-control"  value="{{ isset($brand_data->width_img) ? $brand_data->width_img: '' }}" required>
                                    </div>
                                    </div><br>
                                    <?php
                                   if(isset($brand_data->logo_url)){

                                        $logo_url = $brand_data->logo_url;

                                   }else {

                                    $logo_url = 'dummy.jpg';

                                   }
                                    ?>
                                    <img src="{{ asset('public/images/'.$logo_url) }}"  width="100" height="100">
                                    <div class="form-group">
                                        <label for="exampleFormControlFile1">Chose your logo barnd</label>
                                        <input  type="hidden" name="old_logo" value="{{ $logo_url }}">
                                        <input type="file" name="logo_url" class="form-control-file" value="{{ url('public/images/'.$logo_url)}}">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row" align="center">
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                    <button type="submit" id="btnSubmit" class="btn btn-success " counter=0>Save </button>
                                </div>
                            </div>
                        </div>
                    </div>
                  <div>
                </div>
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

</div>
</div>
</section>
</div>
</div>
@endsection
