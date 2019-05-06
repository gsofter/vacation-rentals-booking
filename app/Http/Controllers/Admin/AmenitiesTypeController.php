<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

use App\Models\admin\AmenitiesType;
use App\Models\admin\AmenitiesTypeLang;
use App\Models\admin\Amenities;
use App\Models\admin\language;

class AmenitiesTypeController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }



    /**
     * @des: Manage  AmenitiesType 
     * @param: 
     * @return: view-> admin/amenities_type/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function index()
    {           
        $data = AmenitiesType::get();        
        return view('admin/amenities_type/index', compact('data'));
        
    }

    /**
     * @des: add  AmenitiesType 
     * @param: AmenitiesType Add Form Data
     * @return: view-> admin/amenities_type/add.blade.php  ///////  view-> admin/amenities_type/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function add(Request $request)
	{
        if(!$_POST){
            $languages = Language::where('status', 'Active')->get();
            return view('admin/amenities_type/add', compact('languages'));
            
		}else{
           
            $amenitiesType                     = new AmenitiesType;
            
            $amenitiesType->name               = $request->name;           
            $amenitiesType->status             = $request->status;            
            $amenitiesType->description        = $request->description;  
                  
            $amenitiesType->save();           
            
            return redirect()->route('admin.amenities_type')
                    ->with('success','New  Amenities Type Added!');
			
		}
    }
        

    /**
     * @des: update  AmenitiesType 
     * @param: AmenitiesType Edit Form Data
     * @return: view-> admin/amenities_type/edit.blade.php  ///////   view-> admin/amenities_type/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function update(Request $request)
	{
		if(!$_POST){

            $languages = Language::where('status', 'Active')->get();
			$amenitiesType     = AmenitiesType::find($request->id);	
            return view('admin/amenities_type/edit', compact('languages', 'amenitiesType'));
            
		}else{		           
           
            $amenitiesType                     = AmenitiesType::find($request->id);
            
            $amenitiesType->name               = $request->name;           
            $amenitiesType->status             = $request->status;     
            $amenitiesType->description        = $request->description;    
           

            $amenitiesType->save();  

            return redirect()->route('admin.amenities_type')
                    ->with('success','Amenities Type Updated!');
			
		}
		
    }

    /**
     * @des: delete  AmenitiesType 
     * @param: delete
     * @return: view-> admin/amenities_type/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function delete(Request $request){

        AmenitiesType::find($request->did)->delete();
        return redirect()->route('admin.amenities_type')
                ->with('success','Amenities Type Deleted!');
    }
    



}