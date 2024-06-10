@extends('frount.index')

@section('content')
<!-- Main content -->



<section class="content">
	<div class="container-fluid">
		<div class="row">
			<!-- left column -->
			<div class="col-md-12">

				<div class="card">
					<div class="card-header">
						<h3 class="card-title">User List</h3>
					</div>
					<!-- /.card-header -->
					<div class="card-body">
						<div class="row">
							<div class="form-group col-md-8 ">
								<a href="{{route('users.add')}}" class="btn  btn-success btn-sm "> <i class="fas fa-plus"></i> Add User</a>
							</div>
						</div>





						<table id="clients" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Action</th>
									<th>Employe ID</th>
									<th>Name</th>
									<th>Email</th>
									<th>Password</th>
									<th>Type</th>
									<th>Zone</th>
									<th>Service Technician ID </th>
									<th>SP Emp ID</th>
									<th>BPID </th>
									<th>TSE Name </th>
									<th>TSE Emp ID</th>
									<th>Branch Code</th>
									<th>SP Name </th>
									<th>Branch Name</th>
									<th>remember_token </th>
									<th>created_at </th>
									<th>updated_at </th>
									<th>Created by</th>
									<th>Updated by</th>

								</tr>
							</thead>
							<tbody>
								@if(!empty($users) && $users->count())
								@php $i=1; @endphp
								@foreach ( $users as $user )
								<tr>
									<td>
										<a href="{{ url('users/edit',$user->id)}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit" style="font-size: 10px;"> <i class="fa fa-edit"></i> </a>
										<a href="{{ url('users/delete',$user->id)}}" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Delete" style="font-size: 10px;"> <i class="fa fa-trash"></i> </a>
									</td>
									<td>{{$user->emp_id}}</td>
									<td>{{$user->name}}</td>
									<td>{{$user->email}}</td>
									<td>{{$user->password}}</td>
									<td>{{$user->emp_type}}</td>
									<td>{{$user->zone}}</td>
									<td>{{$user->ServiceTechnicianID }}</td>
									<td>{{$user->SPEmpID}}</td>
									<td>{{$user->BPID }}</td>
									<td>{{$user->TSEName }}</td>
									<td>{{$user->TSEEmpID}}</td>
									<td>{{$user->BranchCode}}</td>
									<td>{{$user->SPName }}</td>
									<td>{{$user->BranchName}}</td>
									<td>{{$user->remember_token }}</td>
									<td>{{$user->created_at }}</td>
									<td>{{$user->updated_at }}</td>
									<td>{{$user->Created_byName}}</td>
									<td>{{$user->updated_by}}</td>


									<!--<td>{{$user->Updated_byName}}</td>-->


								</tr>
								@endforeach
								@else
								<tr>
									<td colspan="10">There are no data.</td>
								</tr>
								@endif

							</tbody>

						</table>

					</div>
					<!-- /.card-body -->
				</div>
			</div>
			<!--/.col (left) -->
			<!-- right column -->
			<div class="col-md-6">

			</div>
			<!--/.col (right) -->
		</div>
		<!-- /.row -->
	</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- jquery-validation -->

<script>
	$(document).ready(function() {
		$('#clients').DataTable({
			dom: 'Bfrtip',
			buttons: [{
				extend: 'excelHtml5',
				exportOptions: {
					columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19]
				}
			}, ],

			"columnDefs": [{
				"targets": [4, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 19],
				"visible": false
			}]
		});




	});
</script>

@endsection
