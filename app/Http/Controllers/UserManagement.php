<?php

namespace App\Http\Controllers;

use App\User;
use App\users_details;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;

class UserManagement extends Controller
{
    public function userCreate(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'password' => 'required|min:6',
        ]);
        if ($validation->passes()) {
            $name = $request->name;
            $email = $request->email;
            $password = $request->password;
            $hash_password = Hash::make($password);
            $user_exist = User::where('email', $email)->first();
            if ($user_exist) {
                return $result = response()->json(['message' => 'invalid']);
            } else {
                $user = new User;
                $user->name = $name;
                $user->email = $email;
                $user->password = $hash_password;
                $user->save();
                $last_user_id= $user->id;
                $user_details= new users_details;
                $user_details->users_id = $last_user_id;
                $user_details->save();
                return $result = response()->json(['message' => 'success']);
            }
        }else{
            return $result = response()->json(['message' => 'required']);
        }
        
    }

    public function userDelete($user_id)
    {
        $detail_exist = users_details::where('users_id', $user_id)->first();
        if ($detail_exist) {
            User::where('id', $user_id)->delete();
            
            $image_exists= $detail_exist->image;
            $filename = public_path().'/backend/images/users/'.$image_exists;
            if (file_exists($filename)) {
                   @unlink($filename);
            }
            users_details::where('users_id', $user_id)->delete();
            return $result = response()->json(['message' => 'Success']);
        } else {
            User::where('id', $user_id)->delete();
            return $result = response()->json(['message' => 'Success']);
        }
    }
    public function userList()
    {
        $title = "Manage Users";
        $active = 'user_list';
        $users = User::get();
        return view('backend.user.user_list', compact('users','active','title'));
    }
    public function userDetails(Request $request)
    {
        $user_id=$request->user_id;
        if($user_id=="553456382u6hsdgh"){
            $user_false_id = $user_id;
            $user_id = Auth::user()->id;
        }
        else{
            $user_false_id = $user_id;
        }
        
        $users = DB::select("select * from users as u left join users_details as ud on u.id=ud.users_id where u.id='$user_id'");
        return view('backend.user.user_update', compact('users', 'user_false_id'));
    }

    public function userUpdate(Request $request)
    {
        if($request->id=="553456382u6hsdgh"){
            $user_id = Auth::user()->id;
        } else {
            if(Auth::user()->can('update_users')){
                $user_id=$request->id;
            }else{
                return $result = response()->json(['message' => 'no_permission']);
            }

            }
        $validation = Validator::make($request->all(), [
            'email' => 'required',
        ]);
        if ($validation->passes()) {
           
            $email =$request->email;

            $user =  User::find($user_id);
            // $users_details =  users_details::find($user_id);
            // $users_details = new users_details();

            $user_all_data = User::where('id', '=', $user_id)->first();
            $user_details_data = users_details::where('users_id', '=', $user_id)->first();
            
            $user_email_exist= $user_all_data->email;
            if( $user_email_exist!=$email ) {
                if (User::where('email', '=', $email)->exists()) {
                    return $result = response()->json(['message' => 'exist']);
                 }
            }
            $name=$request->full_name;
            $user->id = $user_id; 
            $user->name =$name;
            $user->email = $email;
            
            $user->save();
            $image_full_path="";

            if ($user_details_data) {
                $file_name = $user_details_data->image;
                if($request->hasFile('image')){
                    if($user_details_data->image != ""){
                        $image_exists= $user_details_data->image;
                        $filename = public_path().'/backend/images/users/'.$image_exists;
                        if (file_exists($filename)) {
                            @unlink($filename);
                        }
                    }
                    $file = $request->file('image');
                    $file_name = time().$file->getClientOriginalName();
                    $destinationPath = public_path('/backend/images/users/');
                    $image_full_path = \Config::get('app.url') . "/public/backend/images/users/" . $file_name;
                    $file->move($destinationPath, $file_name);
                }
                
                $update_array = array(
                    'first_name' => $request->f_name,
                    'last_name' => $request->l_name,
                    'phone' => $request->phone,
                    'date_of_birth' => $request->dob,
                    'gender' => $request->gender,
                    'postal_code' => $request->postal_code,
                    'image' => $file_name,
                );
                
            }else{
                $file_name = NULL;
                if($request->hasFile('image')){
                    
                    $file = $request->file('image');
                    $file_name = time().$file->getClientOriginalName();
                    $destinationPath = public_path('/backend/images/users/');
                    $image_full_path = \Config::get('app.url') . "/public/backend/images/users/" . $file_name;
                    $file->move($destinationPath, $file_name);
                }
                $update_array = array(
                    'users_id' => $user_id,
                    'first_name' => $request->f_name,
                    'last_name' => $request->l_name,
                    'phone' => $request->phone,
                    'date_of_birth' => $request->dob,
                    'gender' => $request->gender,
                    'postal_code' => $request->postal_code,
                    'image' => $file_name,
                );                
            }
            // return $update_array;
            if($user_details_data){
                $update = users_details::where('users_id', $user_id)
                ->update($update_array);
            } else {
                $update = users_details::insert($update_array);
            }
            return $result = response()->json(['message' => 'success']);
        } else {
            return $result = response()->json(['message' => 'required']);
        }
    }

    public function changePassword(Request $request){
        $user_id=$request->user_id;
        $password=$request->password;
        $validation = Validator::make($request->all(), [
            'password' => 'required|min:6',
        ]);
        if ($validation->passes()) {
            $user_id=$request->user_id;
            $password=$request->password;
            $hashed_password = Hash::make($password);
            $user =  User::find($user_id);
            $user->password = $hashed_password;
            $user->save();
            return $result = response()->json(['message' => 'success']);
        }else{
            return $result = response()->json(['message' => 'invalid']);
        }
    }
   
}
