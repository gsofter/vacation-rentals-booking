<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use Session;

use App\Models\admin\RoomTag;

class RoomTagController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }



    /**
     * @des: Manage  Room Tag 
     * @param: 
     * @return: view-> admin/rooms_tags/index.blade.php
     * @dev: Artemova
     * @date:2019/10/12 
    */
    public function index()
    {           
        $data = RoomTag::get();        
        return view('admin/rooms_tags/index', compact('data'));
        
    }

    /**
     * @des: add   Room Tag
     * @param:  Room Tag Add Form Data
     * @return: view-> admin/rooms_tags/add.blade.php  ///////  view-> admin/rooms_tags/index.blade.php
     * @dev: Artemova
     * @date:2019/10/12 
    */
    public function add(Request $request)
	{
        if(!$_POST){
          
			return view('admin/rooms_tags/add');
		}else{
           
            $roomTag                     = new RoomTag;
            
            $roomTag->name               = $request->name;
            $roomTag->description        = $request->description;
            
            $roomTag->status             = $request->status;
           
            if( $uploadimage			 = $request -> file('image')) {			
                $file_name 				 = time() .'_'. $request->name.'_image.' . $uploadimage->getClientOriginalExtension();
               
                $uploadimage->move(public_path('images/rooms/tags'), $file_name);
                $roomTag->image 		 = $file_name;
            }

            $roomTag->save();           
            
            return redirect()->route('admin.rooms_tags')
                    ->with('success','New Room Tag Added!');
			
		}
    }
        

    /**
     * @des: update   Room Tag
     * @param:  Room Tag Edit Form Data
     * @return: view-> admin/rooms_tags/edit.blade.php  ///////   view-> admin/rooms_tags/index.blade.php
     * @dev: Artemova
     * @date:2019/10/12 
    */
    public function update(Request $request)
	{
		if(!$_POST){

			$roomTag     = RoomTag::find($request->id);          

            return view('admin/rooms_tags/edit', compact('roomTag'));
            
		}else{		           
           
            $roomTag                        = RoomTag::find($request->id);
            
            $roomTag->name                  = $request->name;
            $roomTag->description           = $request->description;
           
            $roomTag->status                = $request->status;
           
            $roomTag->image 		        = $request->orginalimage;
            if( $uploadimage			    = $request->file('image')) {			
                $file_name 				    = time() .'_'. $request->name.'_image.' . $uploadimage->getClientOriginalExtension();               
                $uploadimage->move(public_path('images/rooms/tags'), $file_name);
                $roomTag->image 		    = $file_name;
            }
            
            $roomTag->save();                       
           
            return redirect()->route('admin.rooms_tags')
                    ->with('success','Room Tag Updated!');
			
		}
		
    }

    /**
     * @des: delete  rooms tags 
     * @param: delete
     * @return: view-> admin/rooms_tags/index.blade.php
     * @dev: Artemova
     * @date:2019/10/12 
    */
    public function delete(Request $request){

        RoomTag::find($request->did)->delete();
        return redirect()->route('admin.rooms_tags')
                ->with('success','Room Tag Deleted!');
    }
    



}