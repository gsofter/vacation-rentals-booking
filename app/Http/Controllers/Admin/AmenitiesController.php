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

class AmenitiesController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }



    /**
     * @des: Manage  Amenities 
     * @param: 
     * @return: view-> admin/amenities/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function index()
    {           
        $data = Amenities::get();        
        return view('admin/amenities/index', compact('data'));
        
    }

    /**
     * @des: add  Amenities 
     * @param: Amenities Add Form Data
     * @return: view-> admin/amenities/add.blade.php  ///////  view-> admin/amenities/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function add(Request $request)
	{
        if(!$_POST){
            $languages = Language::where('status', 'Active')->get();
            $types     = AmenitiesType::where('status', 'Active')->get();
            return view('admin/amenities/add', compact('languages', 'types'));
            
		}else{
           
            $amenity                     = new Amenities;
            
            $amenity->type_id            = $request->type_id;           
            $amenity->name               = $request->name;           
            $amenity->status             = $request->status;
            if($request->description)            
                $amenity->description        = $request->description;
            else
                $amenity->description        = "";
            if( $uploadimage			= $request -> file('image')) {			
                $file_name 				= time() .'_amenities_.' . $uploadimage->getClientOriginalExtension();
               
                $uploadimage->move(public_path('images/amenities'), $file_name);
                $amenity->icon 		= $file_name;
            } 
                  
            $amenity->save();           
            
            return redirect()->route('admin.amenities')
                    ->with('success','New  Amenities Added!');
			
		}
    }
        

    /**
     * @des: update  Amenities 
     * @param: Amenities Edit Form Data
     * @return: view-> admin/amenities/edit.blade.php  ///////   view-> admin/amenities/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function update(Request $request)
	{
		if(!$_POST){
            $types              = AmenitiesType::where('status', 'Active')->get();
            $languages          = Language::where('status', 'Active')->get();
			$amenity            = Amenities::find($request->id);	
            return view('admin/amenities/edit', compact('types', 'languages', 'amenity'));
            
		}else{		           
           
            $amenity                      = Amenities::find($request->id);
            
            $amenity->type_id             = $request->type_id;           
            $amenity->name                = $request->name;           
            $amenity->status              = $request->status;            
            if($request->description)            
                $amenity->description     = $request->description;
            else
                $amenity->description     = "";

            $amenity->icon 		          = $request->orginalimage;
            if( $uploadimage			  = $request->file('image')) {			
                $file_name 				  = time() .'_amenities.' . $uploadimage->getClientOriginalExtension();               
                $uploadimage->move(public_path('images/amenities'), $file_name);
                $amenity->icon 		      = $file_name;
            }
  
                  
            $amenity->save();                

            return redirect()->route('admin.amenities')
                    ->with('success','Amenities Updated!');
			
		}
		
    }

    /**
     * @des: delete  Amenities 
     * @param: delete
     * @return: view-> admin/amenities/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function delete(Request $request){

        Amenities::find($request->did)->delete();
        return redirect()->route('admin.amenities')
                ->with('success','Amenities Deleted!');
    }
    



}