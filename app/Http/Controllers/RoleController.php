<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DB;
use App\User;


class RoleController extends Controller
{
     public function role(){
      $title = "Manage Role";
      $active = 'role';
      $roles = DB::table('roles')->get();
      $role_permissions = array();
      foreach($roles as $role):
        $role_info['role_id'] = $role->id;
        $role_info['role_name'] = $role->name;
        $role_info['guard_name'] = $role->guard_name;
        $role_info['is_system'] = $role->is_system;
        $role_info['role_permissions'] = $this->get_role_permission_by_role_id($role->id);
        $role_permissions[] =$role_info;
      endforeach;
      // echo "<pre>"; print_r($role_permissions);
      // exit;
    	return view('backend.pages.role',compact('role_permissions', 'title', 'active'));
    } 


    public function roleInsert(Request $request){
       $validation = Validator::make($request->all(), [
                    'role' => 'required'
        ]);
       if ($validation->passes()) {
        $role_name= $request->role;
        $role_description= $request->role_description;

         $roles = DB::table('roles')
         ->where('name', $role_name)
         ->get();
         $roles = json_decode($roles);
         if (empty($roles)){
          Role::create(['name' => $role_name,'role_description'=>$role_description,'is_system'=>0]);
          return redirect('/role')->with(['message'=>'Role Setup Completed','class_name' => 'alert-success']);
         }else{
          return redirect('/role')->with(['message'=>'Role Duplicated','class_name' => 'alert-danger']);
         }
       }else{
            return redirect('/role')->with(['message'=>'Role name can not be blunk','class_name' => 'alert-danger']);
       }
      
    }

    public function create_role($var = null)
    {
      $title = "Create New Role";
      $roles = DB::table('roles')->get();
      $role_permissions = array();
      foreach($roles as $role):
        $role_info['role_id'] = $role->id;
        $role_info['role_name'] = $role->name;
        $role_info['guard_name'] = $role->guard_name;
        $role_info['is_system'] = $role->is_system;
        $role_info['role_permissions'] = $this->get_role_permission_by_role_id($role->id);
        $role_permissions[] =$role_info;
      endforeach;
      return view('backend.pages.new_role',compact('title', 'role_permissions'));
    }

    public function assignPermissionRole(){
      $title = "Assign Permission to a role";
      $active = 'assign_permission_role';

      $roles = DB::table('roles')->get();
      $permissions = DB::table('permissions')->get();

      return view('backend.pages.assign_permission_role',compact('roles','permissions','title','active'));
    } 
    public function assignPermissionToModel(){
      $title = "Assign Permission to User";
      $active = 'assign_permission_model';
    	$users = DB::table('users')->get();
    	$permissions = DB::table('permissions')->get();

    	return view('backend.pages.assign_permission_model',compact('users','permissions', 'title','active'));
    }

    public function getPermission(Request $request){

       $role_id=$request->role_id;
       if ($role_id==0) {
         return"Not selected";
       }

       $permissions = DB::table('permissions')->get();
       $role_has_permissions = DB::table('role_has_permissions')
       ->where('role_id', $role_id)
       ->get();

       $datas = array();
        foreach ($role_has_permissions as $key => $role_has_permission) {
            $datas[] = $role_has_permission->permission_id;
        }
      return view('backend.pages.get_permission',compact('role_has_permissions','permissions','datas'));
       

    }
    public function getPermissionModel(Request $request){

    	 $user_id=$request->user_id;
       if ($user_id==0) {
         return"Not selected";
       }
       $user = User::find($user_id);
       $permissions_exists = $user->permissions;
       
   $permission_names = DB::select("select * from model_has_roles as mhr inner join role_has_permissions as rhp on mhr.role_id=rhp.role_id inner join permissions as p on p.id=rhp.permission_id where mhr.model_id='$user_id'");

       $permissions = DB::table('permissions')->get();

    	 $permissions_exist_id=array();
       foreach ($permissions_exists as $key => $permissions_exist) {
          $permissions_exist_id[]=$permissions_exist->id;
       }
       $datas = array();
        foreach ($permission_names as $key => $permission_name) {
            $datas[] = $permission_name->name;
        }
        $match=array(); 

        $not_matches=array();  

      foreach ($permissions as $key => $permission) {
        if (in_array($permission->name, $datas)) {
             
             $match[]=$permission;
        }else{
          $not_matches[]=$permission;
        }
      }
    
      return view('backend.pages.get_permission_model',compact('permissions_exist_id','permissions','not_matches'));
       

    }
    public function assignPermissionToModelStore(Request $request){
      $user_id=$request->user_id;
      $permission_id=$request->permission;
      $user = User::find($user_id);
      $permission=Permission::all();
      $user->revokePermissionTo($permission);
      $user->syncPermissions($permission_id);
      return $result = response()->json(['message' => 'Success']);
    }
    public function assignPermissionToRole(Request $request){
      $role_id=$request->role_id;
      $permission_id=$request->permission;
      $role = Role::find($role_id);
      $permission=Permission::all();
      $role->revokePermissionTo($permission);

      $role->givePermissionTo($permission_id);

      return $result = response()->json(['message' => 'Success']);
    }


    public function assignRoleModel(){
      $title = "Assign role to a user";
      $active = 'assign_role_model';
      $users = DB::table('users')->get();
      return view('backend.pages.assign_role_model',compact('users','title','active'));
    }

     public function getRole(Request $request){
       $user_id=$request->user_id;
       if ($user_id==0) {
         return"Not selected";
       }

       $roles = DB::table('roles')->get();
       $model_has_roles = DB::table('model_has_roles')
       ->where('model_id', $user_id)
       ->get();

       $datas = array();
        foreach ($model_has_roles as $key => $model_has_role) {
            $datas[] = $model_has_role->role_id;
        }

      return view('backend.pages.get_role',compact('model_has_roles','roles','datas'));
       

    }

    public function assignModelRole(Request $request){
      $user_id=$request->user_id;
      $roles=$request->roles;

      // $roles_exist = DB::table('model_has_roles')->where('role_id',1)->get();
      // $roles_count= count($roles_exist);
      // if($roles_count<=1){
      //   return $result = response()->json(['message' => 'Super Admin cannot be changed. Because you have to at least one Super admin']);
      // }

      $role = Role::find($roles);
      $user = User::findOrFail($user_id);
      $user->syncRoles();
      $user->assignRole($role);
      return $result = response()->json(['message' => 'Success']);
    }
    public function roleDelete(Request $request){
      $role_id= $request->role_id;
      $is_delete = Role::where([['id','=',$role_id],['is_system','=',0]])->delete();
      if($is_delete){
        return redirect('/role')->with(['message'=>'Role has been deleted','class_name' => 'alert-success']);
      }else{
        return redirect('/role')->with(['message'=>'Role is not deleted. May be it is not deletable','class_name' => 'alert-danger']);
      }
      

    }

    public function get_role_permission_by_role_id($role_id = null)
    {
      if (!empty($role_id)) {
        $permissions = DB::table('permissions')
            ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->select('permissions.*')
            ->where('role_has_permissions.role_id', $role_id)
            ->get();
            return $permissions;
      } else {
        $permissions = DB::table('permissions')->get();
      }
    }
}
