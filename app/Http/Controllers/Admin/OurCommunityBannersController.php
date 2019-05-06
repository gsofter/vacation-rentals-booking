<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

use App\Models\admin\OurCommunityBanners;
use App\Models\admin\Language;

class OurCommunityBannersController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }



    /**
     * @des: Manage  OurCommunityBanners 
     * @param: 
     * @return: view-> admin/our_community_banners/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function index()
    {           
        $data = OurCommunityBanners::get();        
        return view('admin/our_community_banners/index', compact('data'));
        
    }

    /**
     * @des: add  OurCommunityBanners 
     * @param: OurCommunityBanners Add Form Data
     * @return: view-> admin/our_community_banners/add.blade.php  ///////  view-> admin/our_community_banners/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function add(Request $request)
	{
        if(!$_POST){

            $languages = Language::where('status', '=', 'Active')->get();
            return view('admin/our_community_banners/add', compact('languages'));
            
		}else{
           
            $cbanner                    = new OurCommunityBanners;
            
            $cbanner->title             = $request->title;
            $cbanner->description       = $request->description;
            $cbanner->link              = $request->link;
            
            
            if( $uploadimage			= $request -> file('image')) {			
                $file_name 				= time() .'_our_community_banners_.' . $uploadimage->getClientOriginalExtension();
               
                $uploadimage->move(public_path('images/our_community_banners'), $file_name);
                $cbanner->image 		= $file_name;
            }

            $cbanner->save();           
            
            return redirect()->route('admin.our_community_banners')
                    ->with('success','New  Our Community Banners Added!');
			
		}
    }
        

    /**
     * @des: update  OurCommunityBanners 
     * @param: OurCommunityBanners Edit Form Data
     * @return: view-> admin/our_community_banners/edit.blade.php  ///////   view-> admin/our_community_banners/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function update(Request $request)
	{
		if(!$_POST){

			$cbanner     = OurCommunityBanners::find($request->id);	
            return view('admin/our_community_banners/edit', compact('cbanner'));
            
		}else{		           
           
            $cbanner                         = OurCommunityBanners::find($request->id);
            
            $cbanner->title             = $request->title;
            $cbanner->description       = $request->description;
            $cbanner->link              = $request->link;
            
            
            if( $uploadimage			= $request -> file('image')) {			
                $file_name 				= time() .'_our_community_banners_.' . $uploadimage->getClientOriginalExtension();
               
                $uploadimage->move(public_path('images/our_community_banners'), $file_name);
                $cbanner->image 		= $file_name;
            }

            $cbanner->save();     
            return redirect()->route('admin.our_community_banners')
                    ->with('success','Our Community Banners Updated!');
			
		}
		
    }

    /**
     * @des: delete  OurCommunityBanners 
     * @param: delete
     * @return: view-> admin/our_community_banners/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function delete(Request $request){

        OurCommunityBanners::find($request->did)->delete();
        return redirect()->route('admin.our_community_banners')
                ->with('success','Our Community Banners Deleted!');
    }
    



}