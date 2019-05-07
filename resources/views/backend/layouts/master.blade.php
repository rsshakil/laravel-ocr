<!doctype html>
<html  lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Laravel Access Role Permission - User Management System</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="A high-quality &amp; free Bootstrap admin dashboard template pack that comes with lots of templates and components.">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
    <link href="<?php echo(\Config::get('app.url').'/public/dashboard/styles/shards-dashboards.1.1.0.min.css');?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo(\Config::get('app.url').'/public/dashboard/styles/extras.1.1.0.min.css');?>">
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </head>
<body>
    <div class="container-fluid">
        <div class="row">
             <!-- Sidebar -->
            @include('backend.pages.sidebar')
            @include('backend.pages.header')
            @yield('content')
                
            @include('backend.pages.footer')
            
    </div>
</div>
<!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script> -->
    <script src="https://unpkg.com/shards-ui@latest/dist/js/shards.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sharrre/2.0.1/jquery.sharrre.min.js"></script>
    <script src="<?php echo(\Config::get('app.url').'/public/dashboard/scripts/extras.1.1.0.min.js')?>"></script>
    <!-- <script src="<?php echo(\Config::get('app.url').'/public/dashboard/scripts/shards-dashboards.1.1.0.min.js')?>"></script> -->
    <!-- <script src="<?php echo(\Config::get('app.url').'/public/dashboard/scripts/app/app-blog-overview.1.1.0.js')?>"></script> -->
<script type="text/javascript">
    $(document).ready(function() {
        
        $('#role_click').on('click', function(event) {
            event.preventDefault();
            var role_id = $("#role_id").val();
            if (role_id==0) {
                alert("Please select a Role");
                return false;
            }
            var permission = [];
             $('#permission:checked').each(function() {
               permission.push($(this).val());
             });
            console.log(permission);
            // return false;
            $.ajax({
                 headers: {
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 },
                url: 'assign_permission_role',
                type: 'POST',
                dataType: 'JSON',
                data: {role_id: role_id,permission: permission},
                success: function(response){
                  alert(response.message);
                }
            })  
    }) 
        $('#user_click').on('click', function(event) {
            event.preventDefault();
            var user_id = $("#user_id_for_role").val();
            // alert(user_id);
            // return 0;
            if (user_id==0) {
                alert("Please select an User");
                return false;
            }
            var roles = [];
             $('#role:checked').each(function() {
               roles.push($(this).val());
             });
            // console.log(roles);
            // return false;
            $.ajax({
                 headers: {
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 },
                url: 'assign_model_role',
                type: 'POST',
                dataType: 'JSON',
                data: {user_id: user_id,roles: roles},
                success: function(response){
                  alert(response.message);
                }
            })  
    })
// Assign permission to Model/User
$('#save_permission').on('click', function(event) {
    event.preventDefault();
    
    var user_id = $("#user_id_for_permission").val();
    if (user_id==0) {
        alert("Please select an User");
        return false;
    }
    var permission = [];
      $('#permission:checked').each(function() {
        permission.push($(this).val());
      });
    console.log(user_id);
    console.log(permission);
    // return false;
    $.ajax({
          headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
        url: 'assign_permission_model',
        type: 'POST',
        dataType: 'JSON',
        data: {user_id: user_id,permission: permission},
        success: function(response){
          alert(response.message);
        }
    })  
}) 
//User Create
$('#new_user_save').on('click', function(event) {
    event.preventDefault();
    // alert("Hi");
    // return false;
    var name = $("#name").val();
    var email = $("#email").val();
    var password = $("#password").val();
    var password_confirm = $("#password-confirm").val();
    if (name=="" || email=="" || password=="" || password_confirm=="") {
        $('#user_message').html('<h3 class="text-danger">' + 'All fields are require' + '</h3>');
        return false;
    }
    if(password!=password_confirm){
        $('#user_message').html('<h3 class="text-danger">' + 'Password does not match' + '</h3>');
        return false;
    }
    
    $.ajax({
          headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
        url: 'user_create',
        type: 'POST',
        dataType: 'JSON',
        data: {name: name,email: email,password:password},
        success: function(response){
            console.log(response.message);
          if(response.message=='success'){
            $('#user_message').html('<h3 class="text-success">' + 'User Created' + '</h3>');
            $("#div").load(" #div > *");
          }else if(response.message=='invalid'){
            $('#user_message').html('<h3 class="text-danger">' + 'Email has already in database' + '</h3>');
          }else if(response.message=='required'){
            $('#user_message').html('<h3 class="text-danger">' + 'Password length should be more than 6 charracter' + '</h3>');
          }
        }
    })  
}) 
//User Create End


// Add new User
$(document).on('click', '#create_new', function () {
    $('#user_message').html('');
    $("#user_create")[0].reset();
    $('#new_user_modal').modal('show');
    });

    // Add new user end

    //User Delete

    function delete_user_data(user_id)
    {
        
        $.ajax({
            url: "user_delete/" + user_id,
            method: "GET",
            success: function (data)
            {
                $('#user_main_message').html('<div class="alert alert-success alert-dismissible fade show mb-0" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><i class="fa fa-check mx-2"></i><strong>Message: </strong> User Deleted</div>'
            );
                $("#div").load(" #div > *");
            }
        });
    }

    $(document).on('click', '.user_delete', function () {
        var result = confirm("Want to delete?");
            if (result) {
                var user_id = $(this).attr("id");
                delete_user_data(user_id);
            }
        
    });

//User Delete End


// User Update

    $('#update_user').on('submit', function (event) {
        event.preventDefault();
        // alert("Hi");
        // return false;
        var fileInput = $("#image").val();
        
        if(fileInput!=""){
            var ext = checkFileExt(fileInput);
        if (ext == "jpg" || ext == "jpeg" || ext == "png") {

        } else {
            alert('Please select an image with extention JPG/JPEG/PNG');
            return false;
        }
        var file_size = $("#image")[0].files[0].size / 1024 / 1024;
        if (file_size >= 1) {
            alert("Image size must be less than 1MB");
            return false;
        }

        }
        // var APP_URL = {!! json_encode(url('/')) !!}
        var APP_URL="<?php echo(\Config::get('app.url').'/update_user')?>"
        $.ajax({
            method: 'POST',
            url: APP_URL,
            data: new FormData(this),
            dataType: 'JSON',
            processData: false,
            cache: false,
            contentType: false,
            success: function (response) {
              
                if (response.message == "success") {
                    alert("User Updated");
                    location.reload();
                   
                } else if(response.message == "exist"){
                    $('#user_update_message').html('<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><i class="fa fa-check mx-2"></i><strong>Message: </strong> This email already exist.</div>');
                }
                else if (response.message == "required") {
                    $('#user_update_message').html('<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><i class="fa fa-check mx-2"></i><strong>Message: </strong> Email is required</div>');
                } 
                else if (response.message == "no_permission") {
                    $('#user_update_message').html('<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><i class="fa fa-check mx-2"></i><strong>Message: </strong> You have no permission to change this</div>');
                } 
                
            }
        }).fail(function () {
            $('#user_update_message').html('<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><i class="fa fa-check mx-2"></i><strong>Message: </strong> Please check your internet connection</div>');
        });
    });

// User Update end

// Extention check function
function checkFileExt(filename) {
        filename = filename.toLowerCase();
        return filename.split('.').pop();
    }
// Extention check function End

// Password Change
$(document).on('click', '.password_change', function () {
    var user_id = $(this).attr("id");
    // alert(user_id);
    // return false;
    $('#change_password_message').html('');
    $('#change_pass_user_id').val(user_id);
    $('#new_password').val('');
    $('#new_password_confirm').val('');
    
    $('#change_password_modal').modal('show');
    });


    $('#change_password_save').on('click', function(event) {
    event.preventDefault();
    
    var user_id = $("#change_pass_user_id").val();
    // alert(user_id);
    // return false;
    var password = $("#new_password").val();
    var password_confirm = $("#new_password_confirm").val();
    if (password=="" || password_confirm=="") {
        $('#change_password_message').html('<h3 class="text-danger">' + 'All fields are require' + '</h3>');
        return false;
    }
    if(password!=password_confirm){
        $('#change_password_message').html('<h3 class="text-danger">' + 'Password does not match' + '</h3>');
        return false;
    }
    
    $.ajax({
          headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
        url: 'change_password',
        type: 'POST',
        dataType: 'JSON',
        data: {user_id:user_id,password:password},
        success: function(response){
            // console.log(response.message);
            // return false;
          if(response.message=='success'){
            $('#change_password_message').html('<h3 class="text-success">' + 'Password changed' + '</h3>');
            $("#div").load(" #div > *");
          }else if(response.message=='invalid'){
            $('#change_password_message').html('<h3 class="text-danger">' + 'Password length can not less than 6 digit' + '</h3>');
          }
        }
    })  
}) 
// Password change End

// changed password by user
$(document).on('click', '.pc', function () {
    var user_id = $(this).attr("id");
    // alert(user_id);
    // return false;
    $('#user_change_password_message').html('');
    $('#user_id').val(user_id);
    $('#user_new_password').val('');
    $('#user_new_password_confirm').val('');
    
    $('#user_change_password_modal').modal('show');
    });



    $('#user_change_password_save').on('click', function(event) {
    event.preventDefault();
    
    var user_id = $("#user_id").val();
    // alert(user_id);
    // return false;
    var password = $("#user_new_password").val();
    var password_confirm = $("#user_new_password_confirm").val();
    // alert(password);
    // return false;
    if (password=="" || password_confirm=="") {
        $('#user_change_password_message').html('<h3 class="text-danger">' + 'All fields are require' + '</h3>');
        return false;
    }
    if(password!=password_confirm){
        $('#user_change_password_message').html('<h3 class="text-danger">' + 'Password does not match' + '</h3>');
        return false;
    }
    
    $.ajax({
          headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
        url: 'change_password',
        type: 'POST',
        dataType: 'JSON',
        data: {user_id:user_id,password:password},
        success: function(response){
            // console.log(response.message);
            // return false;
          if(response.message=='success'){
            $('#user_change_password_message').html('<h3 class="text-success">' + 'Password changed' + '</h3>');
            $("#div").load(" #div > *");
          }else if(response.message=='invalid'){
            $('#user_change_password_message').html('<h3 class="text-danger">' + 'Password length can not less than 6 digit' + '</h3>');
          }
        }
    })  
}) 
    
   // changed password by user end 

});

</script>
</body>
</html>