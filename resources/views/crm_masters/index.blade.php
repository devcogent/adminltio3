@extends('frount.index')
@section('content')
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
           <div class="card card-info">
            <div class="card-header">
                <h5>CRM List <a href="{{route('crmmaster.add')}}" class="btn  btn-success btn-sm float-right"> <i class="fa fa-plus"></i> Add CRM</a></h5>
             </div>
             <div class="card-body">
           <table id="example1" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>Action</th>
									<th>CRM Name</th>
									<th>CRM Type</th>
									<th>Created by</th>
									<th>Created at </th>
									<th>Updated by</th>
									<th>Updated at </th>

								</tr>
							</thead>
							<tbody>
								@if(!empty($crm_masters) && $crm_masters->count())
								@php $i=1; @endphp
								@foreach ( $crm_masters as $cat )
								<tr>
									<td>
										 {{--  <a href="{{ url('/crm-masters/edit',$cat->id)}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit" style="font-size: 10px;"> <i class="fa fa-edit"></i> </a>  --}}
										<a href="{{ url('/manage-columns',$cat->id)}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit" style="font-size: 10px;"> <i class="fa fa-edit"></i> </a>
										<a href="{{ url('/crm-masters/delete',$cat->id)}}" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Delete" style="font-size: 10px;"> <i class="fa fa-trash"></i> </a>
										<a href="{{ url('/manage-fields',$cat->id)}}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Create Form and Fields" style="font-size: 10px;"> <i class="fa fa-eye"></i> </a>
										<a href="{{ url('/manage-options',$cat->id)}}" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Manage Options" style="font-size: 10px;"> <i class="fa fa-list"></i> </a>
                                        <a href="{{ url('/crm-branding',$cat->crm_name)}}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Crm Branding" style="font-size: 10px;"> <i class="fa fa-home" ></i> </a>


                                        {{--  <a href="{{ url('/crm-branding',$cat->crm_name)}}_crm" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Crm Branding" style="font-size: 10px;"> <i class="fa fa-bank" ></i> </a>  --}}
                                        <?php
                                            Config::set('database.connections.mysql.database', 'cgcrm_'.$cat->crm_name);
                                            DB::purge('mysql');
                                            $crmform_ext  = App\Models\CrmForm::where('crm_id', $cat->id)->where('form_type', '1')->get();
                                        ?>
                                        @if ($cat->crm_type == 1 && !empty($crmform_ext[0]))
                                            {{-- <a href="{{ url('/download-csv',$cat->crm_name)}}_client_data" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Download Format" style="font-size: 10px;"> <i class="fa fa-download"></i> </a> --}}
                                            <a href="{{ url('/upload',$cat->crm_name)}}_client_data" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Upload Data" style="font-size: 10px;"> <i class="fa fa-upload"></i> </a>

                                            <a href="{{ url('/clear-chunk',$cat->crm_name)}}_client_data" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Clear chunk" style="font-size: 10px;"> <i class="fa fa-spinner" aria-hidden="true"></i> </a>

                                            <a href="{{ url('/api-code',$cat->crm_name)}}_client_data" class="btn btn-dark btn-sm" data-toggle="tooltip" data-placement="top" title="Api Documentation" style="font-size: 10px;"> <i class="fa fa-code" ></i> </a>
                                           <a href="{{ url('/get-cti-link',$cat->crm_name)}}_client_data" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Cti Page" style="font-size: 10px;"> <i class="fa fa-link" ></i> </a>


                                           {{-- <a href="{{ url('/manage-filed-dependencies')}}" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Filed Dependencies" style="font-size: 10px;"> <i class="fa fa-plug" ></i> </a> --}}

                                        @endif

									</td>
									<td>{{$cat->crm_name}}</td>
                                    <?php $get_crm_type = '';?>
                                    @if($cat->crm_type == 1)
                                      <?php $get_crm_type = 'Client Data'?>
                                    @else
                                      <?php $get_crm_type = 'Agent Input'?>
                                    @endif
                                    <td>{{$get_crm_type}}</td>
									<td>{{$cat->created_by}}</td>
									<td>{{date('d-M-Y',strtotime($cat->created_at))}}</td>
									<td>{{$cat->updated_by}}</td>
									<td>{{date('d-M-Y',strtotime($cat->updated_at))}}</td>


								</tr>
								@endforeach

								@endif

							</tbody>

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
</section>

@endsection

