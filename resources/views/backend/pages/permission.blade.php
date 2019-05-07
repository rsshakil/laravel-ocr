@extends('backend.layouts.master')
@section('content')
@if(Session::get('delete_message'))
<div class="alert {{Session::get('class_name')}} alert-dismissible fade show mb-0" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">×</span>
	</button>
	<i class="fa fa-check mx-2"></i>
	<strong>Message: </strong>{{ Session::get('delete_message') }}            
</div>
@endif
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
	<div class="row">
	@can('create_permissions')
	<div class="col-lg-4">
				<div class="card card-small mb-4">
					<div class="card-header border-bottom">
						<h6 class="m-0">{{ $title }}</h6>
					</div>
					<ul class="list-group list-group-flush">
						<li class="list-group-item p-3">
							<div class="row">
								<div class="col">
								<form  action="<?php echo(\Config::get('app.url').'/permission_insert')?>" method="post">
									@csrf
										<div class="form-row">
											<div class="form-group col-md-12">
												<label for="feFirstName">Permission Name</label>
												<input type="text" name="permission" class="form-control" id="role" placeholder="Please enter permission name">
											
										</div>
			</div>
										
										<div class="form-row">
											<div class="form-group col-md-12">
												<label for="feDescription">Permission Description</label>
												<textarea class="form-control" name="permission_description" placeholder="Permission Description" rows="5"></textarea>
											</div>
										</div>
										<button type="submit" class="btn btn-primary"> <i class="fas fa-save"></i> Save</button>
									</form>
								</div>
							</div>
						</li>
					</ul>
				</div>
			</div>
<!-- Create permission end -->
			@endcan

			@can('retrieve_permissions')
		<div class="col-sm-8">
			<div class="card card-small mb-4">
				<div class="card-header border-bottom">
					<h6 class="m-0">Permission List</h6>
				</div>
				<div class="card-body p-0 pb-3">
					<table class="table mb-0">
						<thead class="bg-light">
							<tr>
								<th>Permission Id</th>
								<th>Permission Name</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($permissions as $permission)
							<tr>
								<td>{{$permission->id}}</td>
								<td>{{$permission->name}}</td>
								<td>
								<!-- Delete permission -->
								@can('delete_permissions')
								@if($permission->is_system==0)
									<a class="btn btn-danger" href="<?php echo(\Config::get('app.url').'/permission_delete/'.$permission->id);?>"><i class="fas fa-trash-alt"></i> Delete</a>
								@endif
								@endcan
								</td>
							</tr>
							@endforeach
						</tbody>
						
					</table>
				</div>
				
			</div>
		</div>
		@endcan
	</div>

</div>
@endsection