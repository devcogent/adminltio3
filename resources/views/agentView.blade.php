@extends('frount.index')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h5>Agent CRM @if(!empty($crm_name) && $crm_name->count())<span class="badge badge-success btn float-right">Q 3 CRM</span>
                            @else
                            <span class="badge badge-danger btn float-right">No crm Mapped!</span>
                            @endif</h5>
                    </div>
                    <div class="card-body">
                        {{--  <div class="row">
                            @if(!empty($crm_name) && $crm_name->count())
                            @foreach ( $crm_name as $crm )
                            <div class="col-md-3"><a href="{{$crm->id}}" class="btn  btn-success"><i class="fa fa-link"></i> {{$crm->crm_name}}</a></div>
                            @endforeach
                            <span class="badge badge-success btn float-right">Q 3 CRM</span>
                            @else
                            <span class="badge badge-danger btn float-right">No crm Mapped!</span>
                            @endif
                        </div>  --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</div>
<!-- /page content -->
@endsection
