<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

use App\Models\admin\Country;
use App\Models\admin\HomeCities;

class HomeCitiesController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }



    /**
     * @des: Manage  homecities 
     * @param: 
     * @return: view-> admin/home_cities/index.blade.php
     * @dev: Artemova
     * @date:2019/10/12 
    */
    public function index()
    {           
        $data = HomeCities::get();        
        return view('admin/home_cities/index', compact('data'));
        
    }

    /**
     * @des: add  home_cities 
     * @param: home_cities Add Form Data
     * @return: view-> admin/home_cities/add.blade.php  ///////  view-> admin/home_cities/index.blade.php
     * @dev: Artemova
     * @date:2019/10/12 
    */
    public function add(Request $request)
	{
        if(!$_POST){
            $countries = Country::get();
			return view('admin/home_cities/add', compact('countries'));
		}else{
           
            $homecities                     = new HomeCities;
            
            $homecities->name               = $request->name;
            $homecities->country            = $request->country;
            
            if( $uploadimage			    = $request -> file('image')) {			
                $file_name 				    = time() .'_'. $request->name.'_image.' . $uploadimage->getClientOriginalExtension();
               
                $uploadimage->move(public_path('images/home_cities'), $file_name);
                $homecities->image 		= $file_name;
            }

            $homecities->save();           
            
            return redirect()->route('admin.home_cities')
                    ->with('success','New home cities Added!');
			
		}
    }
        

    /**
     * @des: update  home_cities 
     * @param: home_cities Edit Form Data
     * @return: view-> admin/home_cities/edit.blade.php  ///////   view-> admin/home_cities/index.blade.php
     * @dev: Artemova
     * @date:2019/10/12 
    */
    public function update(Request $request)
	{
		if(!$_POST){

			$homecity     = HomeCities::find($request->id);		
            $countries      = Country::get();

            return view('admin/home_cities/edit', compact('homecity', 'countries'));
            
		}else{		           
           
            $homecity                       = HomeCities::find($request->id);
            
            $homecity->name                 = $request->name;
            $homecity->country              = $request->country;
            $homecity->image 		        = $request->orginalimage;
            if( $uploadimage			    = $request->file('image')) {			
                $file_name 				    = time() .'_'. $request->name.'_image.' . $uploadimage->getClientOriginalExtension();               
                $uploadimage->move(public_path('images/home_cities'), $file_name);
                $homecity->image 		    = $file_name;
            }
            
            $homecity->save();                       
           
            return redirect()->route('admin.home_cities')
                    ->with('success','home cities Updated!');
			
		}
		
    }

    /**
     * @des: delete  home_cities 
     * @param: delete
     * @return: view-> admin/home_cities/index.blade.php
     * @dev: Artemova
     * @date:2019/10/12 
    */
    public function delete(Request $request){

        HomeCities::find($request->did)->delete();
        return redirect()->route('admin.home_cities')
                ->with('success','home cities Deleted!');
    }
    



}