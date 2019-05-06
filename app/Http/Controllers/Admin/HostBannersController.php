<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

use App\Models\admin\HostBanners;
use App\Models\admin\Language;

class HostBannersController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }



    /**
     * @des: Manage  HostBanners 
     * @param: 
     * @return: view-> admin/host_banners/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function index()
    {           
        $data = HostBanners::get();        
        return view('admin/host_banners/index', compact('data'));
        
    }

    /**
     * @des: add  HostBanners 
     * @param: HostBanners Add Form Data
     * @return: view-> admin/host_banners/add.blade.php  ///////  view-> admin/host_banners/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function add(Request $request)
	{
        if(!$_POST){

            $languages = Language::where('status', '=', 'Active')->get();
            return view('admin/host_banners/add', compact('languages'));
            
		}else{
           
            $hostbanner                    = new HostBanners;
            
            $hostbanner->title             = $request->title;
            $hostbanner->description       = $request->description;
            $hostbanner->link_title        = $request->link_title;
            $hostbanner->link              = $request->link;
            
            
            if( $uploadimage			= $request -> file('image')) {			
                $file_name 				= time() .'_host_banners_.' . $uploadimage->getClientOriginalExtension();
               
                $uploadimage->move(public_path('images/host_banners'), $file_name);
                $hostbanner->image 		= $file_name;
            }

            $hostbanner->save();           
            
            return redirect()->route('admin.host_banners')
                    ->with('success','New  Host Banner Added!');
			
		}
    }
        

    /**
     * @des: update  HostBanners 
     * @param: HostBanners Edit Form Data
     * @return: view-> admin/host_banners/edit.blade.php  ///////   view-> admin/host_banners/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function update(Request $request)
	{
		if(!$_POST){

			$hostbanner     = HostBanners::find($request->id);	
            return view('admin/host_banners/edit', compact('hostbanner'));
            
		}else{		           
           
            $hostbanner                         = HostBanners::find($request->id);
            
            $hostbanner->title             = $request->title;
            $hostbanner->description       = $request->description;
            $hostbanner->link_title        = $request->link_title;
            $hostbanner->link              = $request->link;
            
            
            if( $uploadimage			= $request -> file('image')) {			
                $file_name 				= time() .'_host_banners_.' . $uploadimage->getClientOriginalExtension();
               
                $uploadimage->move(public_path('images/host_banners'), $file_name);
                $hostbanner->image 		= $file_name;
            }

            $hostbanner->save();     
            return redirect()->route('admin.host_banners')
                    ->with('success','Host Banners Updated!');
			
		}
		
    }

    /**
     * @des: delete  HostBanners 
     * @param: delete
     * @return: view-> admin/host_banners/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function delete(Request $request){

        HostBanners::find($request->did)->delete();
        return redirect()->route('admin.host_banners')
                ->with('success','Host Banners Deleted!');
    }
    



}