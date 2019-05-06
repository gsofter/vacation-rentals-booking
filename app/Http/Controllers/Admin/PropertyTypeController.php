<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

use App\Models\admin\PropertyType;
use App\Models\admin\PropertyTypeLang;
use App\Models\admin\Rooms;
use App\Models\admin\language;

class PropertyTypeController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }



    /**
     * @des: Manage  PropertyType 
     * @param: 
     * @return: view-> admin/property_type/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function index()
    {           
        $data = PropertyType::get();        
        return view('admin/property_type/index', compact('data'));
        
    }

    /**
     * @des: add  Property Type 
     * @param: PropertyType Add Form Data
     * @return: view-> admin/property_type/add.blade.php  ///////  view-> admin/property_type/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function add(Request $request)
	{
        if(!$_POST){
            $languages = Language::where('status', 'Active')->get();
            return view('admin/property_type/add', compact('languages'));
            
		}else{
           
            $propertytype                     = new PropertyType;
            
            $propertytype->name               = $request->name;           
            $propertytype->status             = $request->status;            
            $propertytype->description        = $request->description;  
                  
            $propertytype->save();           
            
            return redirect()->route('admin.property_type')
                    ->with('success','New  Property Type Added!');
			
		}
    }
        

    /**
     * @des: update  PropertyType 
     * @param: PropertyType Edit Form Data
     * @return: view-> admin/property_type/edit.blade.php  ///////   view-> admin/property_type/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function update(Request $request)
	{
		if(!$_POST){

            $languages          = Language::where('status', 'Active')->get();
			$propertytype       = PropertyType::find($request->id);	
            return view('admin/property_type/edit', compact('languages', 'propertytype'));
            
		}else{		           
           
            $propertytype                     = PropertyType::find($request->id);
            
            $propertytype->name               = $request->name;           
            $propertytype->status             = $request->status;            
            $propertytype->description        = $request->description;  
                  
            $propertytype->save();           

            return redirect()->route('admin.property_type')
                    ->with('success','Property Type Updated!');
			
		}
		
    }

    /**
     * @des: delete  PropertyType 
     * @param: delete
     * @return: view-> admin/property_type/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function delete(Request $request){

        PropertyType::find($request->did)->delete();
        return redirect()->route('admin.property_type')
                ->with('success','Property Type Deleted!');
    }
    



}