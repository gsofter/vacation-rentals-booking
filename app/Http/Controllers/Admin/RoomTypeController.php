<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

use App\Models\admin\RoomType;
use App\Models\admin\RoomTypeLang;
use App\Models\admin\Rooms;
use App\Models\admin\language;

class RoomTypeController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }



    /**
     * @des: Manage  RoomType 
     * @param: 
     * @return: view-> admin/room_type/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function index()
    {           
        $data = RoomType::get();        
        return view('admin/room_type/index', compact('data'));
        
    }

    /**
     * @des: add  Property Type 
     * @param: RoomType Add Form Data
     * @return: view-> admin/room_type/add.blade.php  ///////  view-> admin/room_type/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function add(Request $request)
	{
        if(!$_POST){
            $languages = Language::where('status', 'Active')->get();
            return view('admin/room_type/add', compact('languages'));
            
		}else{
           
            $roomtype                     = new RoomType;
            
            $roomtype->name               = $request->name;           
            $roomtype->status             = $request->status;            
            $roomtype->description        = $request->description;  
            $roomtype->is_shared          = $request->is_shared;  
                  
            $roomtype->save();           
            
            return redirect()->route('admin.room_type')
                    ->with('success','New  Property Type Added!');
			
		}
    }
        

    /**
     * @des: update  RoomType 
     * @param: RoomType Edit Form Data
     * @return: view-> admin/room_type/edit.blade.php  ///////   view-> admin/room_type/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function update(Request $request)
	{
		if(!$_POST){

            $languages      = Language::where('status', 'Active')->get();
			$roomtype       = RoomType::find($request->id);	
            return view('admin/room_type/edit', compact('languages', 'roomtype'));
            
		}else{		           
           
            $roomtype                     = RoomType::find($request->id);
            
            $roomtype->name               = $request->name;           
            $roomtype->status             = $request->status;            
            $roomtype->description        = $request->description;  
            $roomtype->is_shared          = $request->is_shared;  
                  
            $roomtype->save();            

            return redirect()->route('admin.room_type')
                    ->with('success','Property Type Updated!');
			
		}
		
    }

    /**
     * @des: delete  RoomType 
     * @param: delete
     * @return: view-> admin/room_type/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function delete(Request $request){

        RoomType::find($request->did)->delete();
        return redirect()->route('admin.room_type')
                ->with('success','Property Type Deleted!');
    }
    



}