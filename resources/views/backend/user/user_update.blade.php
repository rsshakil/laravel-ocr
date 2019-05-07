@extends('backend.layouts.master')
@section('content')


<div id="user_update_message"></div>
<div class="main-content-container container-fluid px-4" >
    <!-- Page Header -->
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">Overview</span>
            <h3 class="page-title">User Profile</h3>
        </div>
    </div>
    <!-- End Page Header -->

    <!-- Default Light Table -->
    @foreach($users as $user)
    <div class="row" id="div" >
        <div class="col-lg-4">
            <div class="card card-small mb-4 pt-3">
                <div class="card-header border-bottom text-center">
                    <div class="mb-3 mx-auto" id="image_id">
                        <img class="rounded-circle"
                            src="<?php echo(\Config::get('app.url').'/public/backend/images/users/'.$user->image)?>"
                            alt="No Image set" width="110"> 
                        </div>
                    <h4 class="mb-0" id="name_id">{{$user->name}}</h4>
                    <span class="text-muted d-block mb-2" id="email_id">{{$user->email}}</span>
                    <!-- <button type="button" class="mb-2 btn btn-sm btn-pill btn-outline-primary mr-2">
                        <i class="material-icons mr-1">person_add</i>Follow</button> -->
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item px-4">
                        <div class="progress-wrapper">
                            <!-- <strong class="text-muted d-block mb-2">Workload</strong> -->
                            <div class="px-4">
                                <!-- <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="74"
                                    aria-valuemin="0" aria-valuemax="100" style="width: 74%;">
                                    <span class="progress-value">100%</span>
                                </div> -->
                            </div>
                        </div>
                    </li>
                    <!-- <li class="list-group-item p-4">
                        <strong class="text-muted d-block mb-2">Description</strong>
                        <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio eaque, quidem, commodi
                            soluta qui quae minima obcaecati quod dolorum sint alias, possimus illum assumenda eligendi
                            cumque?</span>
                    </li> -->
                </ul>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card card-small mb-4">
                <div class="card-header border-bottom">
                    <h6 class="m-0">Profile Details</h6>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item p-3">
                        <div class="row" id="div">
                            <div class="col">
                                <form method="POST" id="update_user" class="" enctype="multipart/form-data">
                                    @csrf

                                    <input type="hidden" name="id" value="{{ $user_false_id }}">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="f_name">First Name</label>
                                            <input id="f_name" type="text" class="form-control" name="f_name"
                                                autofocus placeholder="First Name" value="{{ $user->first_name }}">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="l_name">Last Name</label>
                                            <input id="l_name" type="text" class="form-control" name="l_name"
                                                placeholder="Last Name" value="{{ $user->last_name }}">
                                            <!-- <input type="text" class="form-control" id="feLastName" placeholder="Last Name" value="Brooks"> -->
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="full_name">Full Name</label>
                                            <input id="full_name" type="text" class="form-control" name="full_name"
                                                 placeholder="Full Name" value="{{ $user->name }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="email">Email</label>
                                            <input id="email" type="text" class="form-control" name="email"
                                                placeholder="Email" value="{{ $user->email }}">
                                            <!-- <input type="email" class="form-control" id="feEmailAddress" placeholder="Email" value="sierra@example.com">  -->
                                        </div>

                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="phone">Phone Number</label>
                                            <input id="phone" type="number" class="form-control" name="phone"
                                                placeholder="Phone Number" value="{{ $user->phone }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="dob">Date of Birth</label>
                                            <input id="dob" type="date" class="form-control" name="dob"
                                                value="{{ $user->date_of_birth }}">

                                            <!-- <input type="email" class="form-control" id="feEmailAddress" placeholder="Email" value="sierra@example.com">  -->
                                        </div>

                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="image">Profile Picture</label>
                                            <input id="image" type="file" class="form-control" name="image">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="gender">Gender</label>
                                            <select name="gender" id="gender" class="form-control">
                                                <option value="">Choose...</option>
                                                <option value="m" <?php if($user->gender=="m"){echo "selected";} ?>>Male
                                                </option>
                                                <option value="f" <?php if($user->gender=="f"){echo "selected";} ?>>
                                                    Female</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="postal_code">Zip</label>
                                            <input id="postal_code" type="text" class="form-control" name="postal_code"
                                             placeholder="Postal Code" value="{{ $user->postal_code }}">
                                        </div>
                                    </div>
                                    <!-- <div class="form-row">
                              <div class="form-group col-md-12">
                                <label for="feDescription">Description</label>
                                <textarea class="form-control" name="feDescription" rows="5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio eaque, quidem, commodi soluta qui quae minima obcaecati quod dolorum sint alias, possimus illum assumenda eligendi cumque?</textarea>
                              </div>
                            </div> -->
                                    <input id="update" type="submit" class="btn btn-accent" value="Save changes">
                                    
                                    <!-- <button type="submit" class="btn btn-accent">Update Account</button> -->

                                </form>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    @endforeach
    <!-- End Default Light Table -->

</div>



@endsection