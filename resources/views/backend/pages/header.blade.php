<main class="main-content col-lg-10 col-md-9 col-sm-12 p-0 offset-lg-2 offset-md-3">
    <div class="main-navbar sticky-top bg-white">
        <!-- Main Navbar -->
        <nav class="navbar align-items-stretch navbar-light flex-md-nowrap p-0">
        <form action="#" class="main-navbar__search w-100 d-none d-md-flex d-lg-flex">
            <div class="input-group input-group-seamless ml-3">
            <div class="input-group-prepend">
                <div class="input-group-text">
                <i class="fas fa-search"></i>
                </div>
            </div>
            <input class="navbar-search form-control" type="text" placeholder="Search for something..." aria-label="Search"> </div>
        </form>
        <ul class="navbar-nav border-left flex-row ">
            <li class="nav-item border-right dropdown notifications">
            <a class="nav-link nav-link-icon text-center" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="nav-link-icon__wrapper">
                <i class="material-icons">&#xE7F4;</i>
                <span class="badge badge-pill badge-danger">2</span>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-small" aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item" href="#">
                <div class="notification__icon-wrapper">
                    <div class="notification__icon">
                    <i class="material-icons">&#xE6E1;</i>
                    </div>
                </div>
                <div class="notification__content">
                    <span class="notification__category">Analytics</span>
                    <p>Your website’s active users count increased by
                    <span class="text-success text-semibold">28%</span> in the last week. Great job!</p>
                </div>
                </a>
                <a class="dropdown-item" href="#">
                <div class="notification__icon-wrapper">
                    <div class="notification__icon">
                    <i class="material-icons">&#xE8D1;</i>
                    </div>
                </div>
                <div class="notification__content">
                    <span class="notification__category">Sales</span>
                    <p>Last week your store’s sales count decreased by
                    <span class="text-danger text-semibold">5.52%</span>. It could have been worse!</p>
                </div>
                </a>
                <a class="dropdown-item notification__all text-center" href="#"> View all Notifications </a>
            </div>
            </li>
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-nowrap px-3" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                @if(Auth::user()->image)
                <img class="user-avatar rounded-circle mr-2" src="<?php echo(\Config::get('app.url').'public/backend/images/users/'.Auth::user()->image)?>" alt="User Avatar">
                @endif
                <span class="d-none d-md-inline-block">{{ Auth::user()->name }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-small">
                <a class="dropdown-item" href="<?php echo(\Config::get('app.url').'/user_update/553456382u6hsdgh')?>">
                    <i class="material-icons">&#xE7FD;</i> Profile
                </a>
                <button class="dropdown-item pc" id="{{Auth::user()->id}}">
                    <i class="material-icons">vertical_split</i> Password change
                </button>
                <!-- <a class="dropdown-item" href="add-new-post.html">
                    <i class="material-icons">note_add</i> Add New Post
                </a> -->
                <div class="dropdown-divider"></div>
                <!-- <a class="dropdown-item text-danger" href="#">
                <i class="material-icons text-danger">&#xE879;</i> Logout </a> -->
                <a class="dropdown-item text-danger" href="<?php echo(\Config::get('app.url').'logout');?>"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                            <i class="material-icons text-danger">&#xE879;</i>
                            {{ __('Logout') }}
                        </a>
                <form id="logout-form" action="<?php echo(\Config::get('app.url').'logout');?>" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
            </li>
        </ul>
        <nav class="nav">
            <a href="#" class="nav-link nav-link-icon toggle-sidebar d-md-inline d-lg-none text-center border-left" data-toggle="collapse" data-target=".header-navbar" aria-expanded="false" aria-controls="header-navbar">
            <i class="material-icons">&#xE5D2;</i>
            </a>
        </nav>
        </nav>
    </div>
    <!-- / .main-navbar -->
    

    <!-- Password change Modal -->
<div class="modal fade" id="user_change_password_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Change Pasword</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
               
                <div class="modal-body">
                <div id="user_change_password_message"></div>
                    <form method="POST" id="user_change_password" class="">
                       @csrf
                    
                        <input type="hidden" name="user_id" id="user_id">
                        <div class="form-group row">
                            <label for="user_new_password" class="col-md-4 col-form-label">{{ __('New Password') }}</label>

                            <div class="col-md-8">
                                <input id="user_new_password" type="password" class="form-control" name="user_new_password" placeholder="New Password" autocomplete="New Password" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="user_new_password_confirm" class="col-md-4 col-form-label">{{ __('Confirm Password') }}</label>

                            <div class="col-md-8">
                                <input id="user_new_password_confirm" type="password" class="form-control" name="user_new_password_confirm" placeholder="Confirm Password" autocomplete="Confirm Password" required>
                            </div>
                        </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="user_change_password_save">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Password change Modal End -->
