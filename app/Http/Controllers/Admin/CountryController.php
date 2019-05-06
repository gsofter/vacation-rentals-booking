<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

use App\Models\admin\Country;
use App\Models\admin\RoomsAddress;

class CountryController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }



    /**
     * @des: Manage  Country 
     * @param: 
     * @return: view-> admin/country/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function index()
    {           
        $data = Country::get();        
        return view('admin/country/index', compact('data'));
        
    }

    /**
     * @des: add  Property Type 
     * @param: Country Add Form Data
     * @return: view-> admin/country/add.blade.php  ///////  view-> admin/country/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function add(Request $request)
	{
        if(!$_POST){
            
            return view('admin/Country/add');
            
		}else{
           
            $country                     = new Country;
            
            $country->short_name         = $request->short_name;           
            $country->long_name          = $request->long_name;     
            $country->iso3               = $request->iso3;     
            $country->num_code           = $request->num_code;     
            $country->phone_code         = $request->phone_code;    
            
            $country->save();           
            
            return redirect()->route('admin.country')
                    ->with('success','New  Country Added!');
			
		}
    }
        

    /**
     * @des: update  Country 
     * @param: Country Edit Form Data
     * @return: view-> admin/country/edit.blade.php  ///////   view-> admin/country/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function update(Request $request)
	{
		if(!$_POST){

			$country       = Country::find($request->id);	
            return view('admin/Country/edit', compact('country'));
            
		}else{		           
           
            $country                     = Country::find($request->id);

            $country->short_name         = $request->short_name;           
            $country->long_name          = $request->long_name;     
            $country->iso3               = $request->iso3;     
            $country->num_code           = $request->num_code;     
            $country->phone_code         = $request->phone_code;    
            
            $country->save();       

            return redirect()->route('admin.country')
                    ->with('success','Country Updated!');
			
		}
		
    }

    /**
     * @des: delete  Country 
     * @param: delete
     * @return: view-> admin/country/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function delete(Request $request){

        Country::find($request->did)->delete();
        return redirect()->route('admin.country')
                ->with('success','Country Deleted!');
    }
    



}