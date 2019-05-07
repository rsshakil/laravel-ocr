@extends('backend.layouts.master')
@section('content')
@if(Session::get('message'))
<div class="alert {{Session::get('class_name')}} alert-dismissible fade show mb-0" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">×</span>
	</button>
	<i class="fa fa-check mx-2"></i>
	<strong>Message: </strong>{{ Session::get('message') }}            
</div>
@endif
<div class="main-content-container container-fluid px-4">
	<!-- Page Header -->
	<div class="page-header row no-gutters py-4">
		<div class="col-12 col-sm-4 text-center text-sm-left mb-0">
		<!-- <span class="text-uppercase page-subtitle">Overview</span> -->
		<h3 class="page-title">{{ $title }}</h3>
		</div>
	</div>
	@can('update_roles')
	<div class="row">
		<div class="col-sm-12">
			<div class="card card-small mb-4">
				<div class="card-header border-bottom">
					<h6 class="m-0">{{ $title }}</h6>
				</div>
				<ul class="list-group list-group-flush">
					<li class="list-group-item p-3">
						<div class="row">
							<div class="col">
								<form method="post">
									<div class="form-group row">
										<label for="inputEmail3" class="col-sm-2 col-form-label">User Name</label>
										<div class="col-sm-4">
										<select class="custom-select custom-select-lg mb-3" name="user_id" id="user_id_for_role" onchange="show_role(this.value)">
											<option value=0>Please Select an User</option>
											@foreach($users as $user)
											<option value="{{$user->id}}">{{$user->name}}</option>
											@endforeach
										</select>
										</div>
									</div>
									<div class="form-group row">
										<label for="inputEmail3" class="col-sm-2 col-form-label">Please select a role</label>
										<div class="col-sm-4" id="role">
											Not selected
										</div>
									</div>
									<div class="form-group row">
										<label for="inputEmail3" class="col-sm-2 col-form-label"></label>
										<div class="col-sm-4">
											<button type="submit" id="user_click" class="btn btn-primary"> <i class="fas fa-save"></i> Save</button>
										</div>
									</div>
									
								</form>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
	@endcan
</div>
<script type="text/javascript">
	function show_role(user_id){
$('#role').load('get_role/'+user_id);
}
</script>
@endsection














