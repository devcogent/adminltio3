



<table id="datatable" class="table table-striped table-bordered">

	<thead>
		<tr>
			<th>Action</th>
			<th>Field Type</th>
			<th>Field Name</th>
			<th>Label Name </th>

		</tr>
	</thead>
	<tbody>
		@if(!empty($crm_fields) && $crm_fields->count())
		@php $i=1; @endphp
		@foreach ( $crm_fields as $cat )
        {{-- <p>hello</p> --}}
		<tr>
			<td>
		<a href="javascript:void(0)" class="btn btn-primary btn-sm selectoptions" data-toggle="tooltip" data-placement="top" title="Add Options" style="font-size: 10px"    crmfield_id="{{$cat->id}}" field_name = "{{ $cat->field_name }}" field_depend = "{{ $cat->field_depend  }}"> <i class="fa fa-edit"></i> </a>

			</td>
			<td>{{$cat->field_type}}</td>
			<td>{{$cat->field_name}}</td>
			<td>{{$cat->label_name}}</td>


		</tr>
		@endforeach
		@else
		<tr>
			<td colspan="10">There are no data.</td>
		</tr>
		@endif

	</tbody>
	</tbody>
</table>
<hr>
<div id="optionsDiv">
	<form role="form" name="quickForm" action="{{route('crmmaster.saveOptions')}}" method="POST">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" name="crm_filed_id">
        <input type="hidden" name="crm_name" value="{{ $crm_name }}">


			{{--  <div class="row">
				<div class="col-md-3 col-sm-12 col-xs-12 form-group">
					<label>Options</label>
				</div>

                <div class="col-md-3 col-sm-12 col-xs-12 form-group">
					<label> Depend</label>
				</div>
				<div class="col-md-3 col-sm-12 col-xs-12 form-group">
					<label> Actions</label>
				</div>

			</div>  --}}
			<div id="lastoptions"></div>

		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">
				<button type="submit" class="btn btn-success " counter=0>Save </button>
			</div>
		</div>
	</form>
</div>


</div>
<script>
	$("#optionsDiv").hide();
	$(document).ready(function() {
		$(document).on('click', '.removeOptions', function() {
			$(this).parent().parent().remove();
		});
	});

	$(".selectoptions").click(function() {
		var crmfield_id = $(this).attr("crmfield_id");
		var field_name = $(this).attr("field_name");
		var field_depend = $(this).attr("field_depend");
		//alert(crmfield_id);
		$("#optionsDiv").show();
		$("form[name='quickForm']").find("input[name='crm_filed_id']:first").val(crmfield_id);
		$.ajax({
			url: "{{route('getcrmFormoptions')}}",
			type: 'POST',
			data: {
				"crm_filed_id": crmfield_id,
                "field_name" : field_name,
                "field_depend" : field_depend,
                "crm_name" : "{{ $crm_name }}",
				"_token": "{{ csrf_token() }}",
			},
			success: function(response) {
				if (response.status == 'success') {
					$('#lastoptions').html(response.html);
				}
			},
			error: function(response) {
				window.console.log(response);
			}
		});
	});
	// $(".addoption").click(function() {
	// 	$("#moreRow").append('<div class="col-md-12"><div class="col-md-3 col-sm-12 col-xs-12 form-group"><input type="text" placeholder="Enter Option" class="form-control" name="option[]"></div> <div class="col-md-3 col-sm-12 col-xs-12 form-group"><a href="javascript:void(0)" class="btn btn-danger removeOptions" attrid="11"><i class="fa fa-minus"> </i></a></div></div>')
	// });
</script>
