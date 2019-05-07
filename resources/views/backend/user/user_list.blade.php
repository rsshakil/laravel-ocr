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
@can('retrieve_users')
<div id="user_main_message"></div>
<div class="main-content-container container-fluid px-4">
	<!-- Page Header -->
	<div class="page-header row no-gutters py-4">
		<div class="col-12 col-sm-4 text-center text-sm-left mb-0">
		<!-- <span class="text-uppercase page-subtitle">Overview</span> -->
		<h3 class="page-title">{{$title}}</h3>
		</div>
	</div>
	<!-- End Page Header -->
	<!-- Default Light Table -->
	<div class="row" id="div">
		<div class="col">
		<div class="card card-small mb-4">
			<div class="card-header border-bottom">
				<h6 class="m-0">{{$title}}</h6>
			</div>
			<div class="card-body p-0 pb-3 text-center">
				<table class="table mb-0" >
					<thead class="bg-light">
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Email</th>                            
                            <th>
                                    <!-- <a href="" class="btn btn-primary float-right"><i class="mdi mdi-all-inclusive"></i><span class="hide-menu"> Create New </span></a> -->
                                    @can('create_users')
                                    <button type="button" name='view' class="btn btn-primary float-righ" id="create_new"><i class="fas fa-plus-square"></i><span class="hide-menu"> Create New </span></button>
                                    @endcan
                            </th>
                        </tr>
						
					</head>
					<?php
					$i = 1;
					?>
					<tbody>
					@foreach($users as $user)
                     <tr>
                        <td><?= $i; ?></td>
                       <td>{{$user->name}}</td>
                       <td>{{$user->email}}</td>
                       <td>
                       @can('retrieve_users')
                            <a href="<?php echo(\Config::get('app.url').'/user_update/'.$user->id)?>" class="btn btn-info"><i class="fas fa-eye"></i> View</a>
                            @endcan
                            @can('update_users')
                            <button type="button" class="btn btn-warning password_change" id="{{$user->id}}"><i class="fas fa-edit"></i> Change Password</button>
                            @endcan
                            @can('delete_users')
                            <button type="button" class="btn btn-danger user_delete" id="{{$user->id}}"><i class="fas fa-trash-alt"></i> Delete</button>
                            @endcan
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
@endcan

<!-- Add new user Modal -->
<div class="modal fade" id="new_user_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
               
                <div class="modal-body">
                <div id="user_message"></div>
                    <form method="POST" id="user_create" class="">
                       @csrf
                    
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label">{{ __('Name') }}</label>

                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control" name="name" required autofocus placeholder="Name">
                                 
                                
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control" name="email" placeholder="Email" required>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label">{{ __('Password') }}</label>

                            <div class="col-md-8">
                                <input id="password" type="password" class="form-control" name="password" placeholder="Password" autocomplete="Password" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label">{{ __('Confirm Password') }}</label>

                            <div class="col-md-8">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" autocomplete="Confirm Password" required>
                            </div>
                        </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="new_user_save">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Add new user Modal End -->

<!-- Password change Modal -->
<div class="modal fade" id="change_password_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Change Pasword</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
               
                <div class="modal-body">
                <div id="change_password_message"></div>
                    <form method="POST" id="change_password" class="">
                       @csrf
                    
                        <input type="hidden" name="user_id" id="change_pass_user_id">
                        <div class="form-group row">
                            <label for="new_password" class="col-md-4 col-form-label">{{ __('New Password') }}</label>

                            <div class="col-md-8">
                                <input id="new_password" type="password" class="form-control" name="new_password" placeholder="New Password" autocomplete="New Password" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="new_password_confirm" class="col-md-4 col-form-label">{{ __('Confirm Password') }}</label>

                            <div class="col-md-8">
                                <input id="new_password_confirm" type="password" class="form-control" name="new_password_confirm" placeholder="Confirm Password" autocomplete="Confirm Password" required>
                            </div>
                        </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="change_password_save">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Password change Modal End -->

@endsection


