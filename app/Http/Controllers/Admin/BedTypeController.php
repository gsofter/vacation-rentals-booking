<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

use App\Models\admin\BedType;
use App\Models\admin\BedTypeLang;
use App\Models\admin\Rooms;
use App\Models\admin\language;

class BedTypeController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }



    /**
     * @des: Manage  BedType 
     * @param: 
     * @return: view-> admin/bed_type/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function index()
    {           
        $data = BedType::get();        
        return view('admin/bed_type/index', compact('data'));
        
    }

    /**
     * @des: add  Property Type 
     * @param: BedType Add Form Data
     * @return: view-> admin/bed_type/add.blade.php  ///////  view-> admin/bed_type/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function add(Request $request)
	{
        if(!$_POST){
            $languages = Language::where('status', 'Active')->get();
            return view('admin/bed_type/add', compact('languages'));
            
		}else{
           
            $bedtype                     = new BedType;
            
            $bedtype->name               = $request->name;           
            $bedtype->status             = $request->status;     
                  
            $bedtype->save();           
            
            return redirect()->route('admin.bed_type')
                    ->with('success','New  Bed Type Added!');
			
		}
    }
        

    /**
     * @des: update  BedType 
     * @param: BedType Edit Form Data
     * @return: view-> admin/bed_type/edit.blade.php  ///////   view-> admin/bed_type/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function update(Request $request)
	{
		if(!$_POST){

            $languages      = Language::where('status', 'Active')->get();
			$bedtype       = BedType::find($request->id);	
            return view('admin/bed_type/edit', compact('languages', 'bedtype'));
            
		}else{		           
           
            $bedtype                     = BedType::find($request->id);
            
            $bedtype->name               = $request->name;           
            $bedtype->status             = $request->status;     
                  
            $bedtype->save();          

            return redirect()->route('admin.bed_type')
                    ->with('success','Bed Type Updated!');
			
		}
		
    }

    /**
     * @des: delete  BedType 
     * @param: delete
     * @return: view-> admin/bed_type/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function delete(Request $request){

        BedType::find($request->did)->delete();
        return redirect()->route('admin.bed_type')
                ->with('success','Bed Type Deleted!');
    }
    



}