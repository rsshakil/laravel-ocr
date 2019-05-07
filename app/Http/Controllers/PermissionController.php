<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use DB;

class PermissionController extends Controller
{
   
    public function permission(){
      $title = "Manage Permissions";
      $active = 'permission';
    	$permissions = DB::table('permissions')->get();
    	return view('backend.pages.permission',compact('permissions', 'title','active'));
    }


     public function permissionInsert(Request $request){
      $validation = Validator::make($request->all(), [
                    'permission' => 'required'
        ]);
      if ($validation->passes()) {
        $permission_name= $request->permission;
        $permission_description= $request->permission_description;

       $permissions = DB::table('permissions')
       ->where('name', $permission_name)
       ->get();
       $permissions = json_decode($permissions);
       if (empty($permissions)){
        Permission::create(['name' => $permission_name,'permission_description'=>$permission_description,'is_system'=>0]);
         return redirect('/permission')->with(['message'=>'Permission Setup Completed','class_name' => 'alert-success']);
       }else{
        return redirect('/permission')->with(['message'=>'Permission name duplicated','class_name' => 'alert-danger']);
       }
      }else{
            return redirect('/permission')->with(['message'=>'Permission name can not be blunk','class_name' => 'alert-danger']);
       }
       
       

    }
    public function permissionDelete(Request $request){
      $permission_id= $request->permission_id;
      //Permission::where('id',$permission_id)->delete();
      $is_delete = Permission::where([['id','=',$permission_id],['is_system','=',0]])->delete();
      if($is_delete){
        return redirect('/permission')->with(['delete_message'=>'Permission has been deleted','class_name' => 'alert-success']);
      }else{
        return redirect('/permission')->with(['delete_message'=>'Permission is not deleted. May be it is not deletable','class_name' => 'alert-danger']);
      }

    }
}
