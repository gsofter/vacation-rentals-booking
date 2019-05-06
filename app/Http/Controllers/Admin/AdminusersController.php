<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Models\admin\Admin;
use App\Models\admin\Role;
use App\Models\admin\Permission;
use App\Models\admin\Permissionrole;

class AdminusersController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

///////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////// Admin User ///////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////

    /**
     * @des: Manage Admin Users 
     * @param: AdminuserDatatable data
     * @return: view-> admin/admin_users/index.blade.php
     * @dev: Artemova
     * @date:2019/10/12 
    */
    public function users()
    {           
        $data = Admin::get();        
        return view('admin/admin_users/index', compact('data'));
        
    }

    /**
     * @des: add Admin Users 
     * @param: Admin Add Form Data
     * @return: view-> admin/admin_users/add.blade.php  ///////  view-> admin/admin_users/index.blade.php
     * @dev: Artemova
     * @date:2019/10/12 
    */
    public function add(Request $request)
	{
		if(!$_POST){
			// Get Roles for Dropdown
			$data = Role::all();            
			return view('admin/admin_users/add', compact('data'));
		}else{
           
            $admin                  = new Admin;

            $admin->first_name      = $request->first_name;
            $admin->last_name       = $request->last_name;
            $admin->username        = $request->username;
            $admin->email           = $request->email;
            $admin->bio             = $request->bio;           
            $admin->password        = bcrypt($request->password);
            $admin->support_contact = $request->support_contact;
            $admin->status          = $request->status;
            if($request->role)
                $admin->role            = $request->role;
            $admin->save();
            
            return redirect()->route('admin.admin.users')
                ->with('success','New Admin User Added!');
			
		}
	}

    /**
     * @des: update Admin Users 
     * @param: Admin Edit Form Data
     * @return: view-> admin/admin_users/edit.blade.php  ///////   view-> admin/admin_users/index.blade.php
     * @dev: Artemova
     * @date:2019/10/12 
    */
    public function update(Request $request)
	{
		if(!$_POST){
			$user  = Admin::find($request->id);

			$roles  = Role::all();

			return view('admin/admin_users/edit', compact('user', 'roles'));
		}else{
			
				$admin                  = Admin::find($request->id);

				$admin->first_name      = $request->first_name;
				$admin->last_name       = $request->last_name;
				$admin->username        = $request->username;
				$admin->bio             = $request->bio;
				$admin->email           = $request->email;				
				$admin->support_contact = $request->support_contact;
				$admin->status          = $request->status;

				if($request->password != '')
					$admin->password = bcrypt($request->password);
                if($request->role)
                    $admin->role            = $request->role;
				$admin->save();
				
				return redirect()->route('admin.admin.users')
                    ->with('success','Admin User Updated!');
			
		}
		
    }

    /**
     * @des: delete Admin Users 
     * @param: Admin Edit Form Data
     * @return: view-> admin/admin_users/index.blade.php
     * @dev: Artemova
     * @date:2019/10/12 
    */
    public function delete(Request $request){
        Admin::find($request->did)->delete();
        return redirect()->route('admin.admin.users')
            ->with('success','Admin User Deleted!');
    }
    

///////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////// Admin User Role //////////////////////////////
///////////////////////////////////////////////////////////////////////////////////

    /**
     * @des: Manage Admin Roles & Permissions 
     * @param: 
     * @return: view-> admin/admin_roles/index.blade.php
     * @dev: Artemova
     * @date:2019/10/12 
    */
    public function roles()
    {           
        $data = Role::get();        
        return view('admin/admin_roles/index', compact('data'));      
        
    }

    /**
     * @des: add Admin Users 
     * @param: Admin Add Form Data
     * @return: view-> admin/admin_roles/add.blade.php  ///////  view-> admin/admin_roles/index.blade.php
     * @dev: Artemova
     * @date:2019/10/12 
    */
    public function addRole(Request $request)
	{
		if(!$_POST){
			// Get Roles for Dropdown
			$permissions = Permission::all();            
			return view('admin/admin_roles/add', compact('permissions'));
		}else{
            $permission = [];
            $permission = $request->permission;
            if(in_array(3, $request->permission) || in_array(4, $request->permission) || in_array(5, $request->permission) )
            {
                $permission[] ='2';
            }

            if(in_array(19, $request->permission) || in_array(20, $request->permission) || in_array(21, $request->permission) )
            {
                $permission[] ='18';
            }                


            $role = new Role;

            $role->name = $request->name;
            $role->display_name = $request->display_name;
            $role->description = $request->description;

            $role->save();
            $rid = $role->id;
            
            $this -> addPermissionRole($permission, $rid);
            
            return redirect()->route('admin.admin.roles')
                ->with('success','New Admin User Added!');
			
		}
    }
    
     
    /**
     * @des: update Admin Users 
     * @param: Admin Edit Form Data
     * @return: view-> admin/admin_roles/edit.blade.php  ///////   view-> admin/admin_roles/index.blade.php
     * @dev: Artemova
     * @date:2019/10/12 
    */
    public function updateRole(Request $request)
	{
		if(!$_POST){
            
            $permissions        = Permission::all(); 
            $role               = Role::find($request->id);
            $rolepermissions    = Permissionrole::where('role_id', '=', $request->id)->get();
            
			return view('admin/admin_roles/edit', compact('role', 'permissions', 'rolepermissions'));
		}else{
                $permission = [];
                $permission = $request->permission;
                if(in_array(3, $request->permission) || in_array(4, $request->permission) || in_array(5, $request->permission) )
                {
                    $permission[] ='2';
                }

                if(in_array(19, $request->permission) || in_array(20, $request->permission) || in_array(21, $request->permission) )
                {
                    $permission[] ='18';
                }                
			
				$role                     = Role::find($request->id);

                $role->name               = $request->name;
                $role->display_name       = $request->display_name;
                $role->description        = $request->description;  

                $role->save();
                
                $this -> deletePermissionRole($request->id);

                $this -> addPermissionRole($permission, $request->id);
				
				return redirect()->route('admin.admin.roles')
                    ->with('success','Admin User Updated!');
			
		}
		
    }

    /**
     * @des: delete Admin Users 
     * @param: Admin Edit Form Data
     * @return: view-> admin/admin_roles/index.blade.php
     * @dev: Artemova
     * @date:2019/10/12 
    */
    public function deleteRole(Request $request){
        $this -> deletePermissionRole($request->did);
        Role::find($request->did)->delete();
        return redirect()->route('admin.admin.roles')
                ->with('success','Admin User Deleted!');
    }
    
///////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////// Permission Role //////////////////////////////
///////////////////////////////////////////////////////////////////////////////////

    /**
     * @des: Add Permission Role  
     * @param: Selected Permission Data
     * @return:
     * @dev: Artemova
     * @date:2019/10/12 
    */
    public function addPermissionRole($permission, $id){
        foreach($permission as $p){
            $prole = new Permissionrole;
            $prole->permission_id = $p;
            $prole->role_id = $id;
            $prole->save();
        }        
    }

    /**
     * @des: Delete Permission Role Data 
     * @param: role_id
     * @return:
     * @dev: Artemova
     * @date:2019/10/12 
    */
    public function deletePermissionRole($id){   

        Permissionrole::where('role_id', '=', $id)->delete(); 

    }


}