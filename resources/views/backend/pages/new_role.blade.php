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


	
	<!-- End Page Header -->
	<!-- Default Light Table -->
	<div class="row">
	<div class="col-lg-4">
				<div class="card card-small mb-4">
					<div class="card-header border-bottom">
						<h6 class="m-0">{{ $title }}</h6>
					</div>
					<ul class="list-group list-group-flush">
						<li class="list-group-item p-3">
							<div class="row">
								<div class="col">
							<form  action="role_insert" method="post">
								@csrf
										<div class="form-row">
											<div class="form-group col-md-12">
												<label for="feFirstName">Role Name</label>
												<input type="text" name="role" class="form-control" id="role" placeholder="Please enter role name" required>
											
										</div>
							</div>
										
										<div class="form-row">
											<div class="form-group col-md-12">
												<label for="feDescription">Description</label>
												<textarea class="form-control" name="feDescription" placeholder="Role Description" rows="5"></textarea>
											</div>
										</div>
										<button type="submit" class="btn btn-primary">Save</button>
									</form>
								</div>
							</div>
						</li>
					</ul>
				</div>
			</div>



			<div class="col">
				<div class="card card-small mb-8">
					<div class="card-header border-bottom">
						<h6 class="m-0">Role List</h6>
					</div>
					<div class="card-body p-0 pb-3">
						<table class="table mb-0" >
							<thead class="bg-light">
								<tr>
									<th>#</th>
									<th>Role Name</th>
									<th>Permissions</th>
									<th>Action</th>
								</tr>
							</head>
							<?php
							$i = 1;
							?>
							<tbody>
								
							@foreach($role_permissions as $role)
							<tr>
								<td><?= $i; ?></td>
								<td>{{ $role['role_name'] }}</td>
								<td>
									@foreach($role['role_permissions'] as $permission)
										<a href="#">{{ $permission->name }} |</a>
									@endforeach
								</td>
								<td>
									<a class="btn btn-info" href="<?php echo(\Config::get('app.url').'/role_edit/'.$role['role_id']);?>"><i class="fas fa-edit"></i> Update</a>
									<a class="btn btn-danger" href="<?php echo(\Config::get('app.url').'/role_delete/'.$role['role_id']);?>"><i class="fas fa-trash-alt"></i> Delete</a>
								</td>
							</tr>
							<?php $i++ ?>
							@endforeach
						
						</tbody>
					</table>
					
					</div>
				</div>
				</div>
	</div>
	<!-- End Default Light Table -->
	
	</div>


	
<!-- <div class="row">
	<div class="col-sm-12 table-light">
		<h1>Role Form</h1>
		<h3 class="{{Session::get('class_name')}}">{{Session::get('message')}}</h3>
		<form  action="role_insert" method="post">
			@csrf
			<div class="form-group row">
				<label for="inputEmail3" class="col-sm-2 col-form-label">Role Name</label>
				<div class="col-sm-4">
					<input type="text" name="role" class="form-control" id="role" placeholder="Please enter role name" required>
				</div>
			</div>
			<div class="form-group row">
				<label for="inputEmail3" class="col-sm-2 col-form-label"></label>
				<div class="col-sm-4">
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</div>
			
		</form>
		<h3 class="{{Session::get('class_name')}}">{{Session::get('delete_message')}}</h3>
		

	</div>
</div> -->
@endsection