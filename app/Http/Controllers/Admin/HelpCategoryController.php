<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

use App\Models\admin\HelpCategory;
use App\Models\admin\HelpSubCategory;
use App\Models\admin\Help;

class HelpCategoryController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }



    /**
     * @des: Manage  HelpCategory 
     * @param: 
     * @return: view-> admin/help_category/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function index()
    {           
        $data = HelpCategory::get();        
        return view('admin/help_category/index', compact('data'));
        
    }

    /**
     * @des: add  HelpCategory 
     * @param: HelpCategory Add Form Data
     * @return: view-> admin/help_category/add.blade.php  ///////  view-> admin/help_category/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function add(Request $request)
	{
        if(!$_POST){

            return view('admin/help_category/add');
            
		}else{
           
            $helpcategory                     = new HelpCategory;
            
            $helpcategory->name               = $request->name;           
            $helpcategory->status             = $request->status;            
            $helpcategory->description        = $request->description;  
                  
            $helpcategory->save();           
            
            return redirect()->route('admin.help_category')
                    ->with('success','New  Help Category Added!');
			
		}
    }
        

    /**
     * @des: update  HelpCategory 
     * @param: HelpCategory Edit Form Data
     * @return: view-> admin/help_category/edit.blade.php  ///////   view-> admin/help_category/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function update(Request $request)
	{
		if(!$_POST){

			$helpcategory     = HelpCategory::find($request->id);	
            return view('admin/help_category/edit', compact('helpcategory'));
            
		}else{		           
           
            $helpcategory                     = HelpCategory::find($request->id);
            
            $helpcategory->name               = $request->name;           
            $helpcategory->status             = $request->status;     
            $helpcategory->description        = $request->description;    
           

            $helpcategory->save();  

            return redirect()->route('admin.help_category')
                    ->with('success','Help Category Updated!');
			
		}
		
    }

    /**
     * @des: delete  HelpCategory 
     * @param: delete
     * @return: view-> admin/help_category/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function delete(Request $request){

        HelpCategory::find($request->did)->delete();
        return redirect()->route('admin.help_category')
                ->with('success','Help Category Deleted!');
    }
    



}