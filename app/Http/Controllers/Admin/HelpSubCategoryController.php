<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

use App\Models\admin\HelpCategory;
use App\Models\admin\HelpSubCategory;
use App\Models\admin\Help;

class HelpSubCategoryController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }



    /**
     * @des: Manage  HelpSubCategory 
     * @param: 
     * @return: view-> admin/help_subcategory/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function index()
    {           
        $data = HelpSubCategory::get();        
        return view('admin/help_subcategory/index', compact('data'));
        
    }

    /**
     * @des: add  HelpSubCategory 
     * @param: HelpSubCategory Add Form Data
     * @return: view-> admin/help_subcategory/add.blade.php  ///////  view-> admin/help_subcategory/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function add(Request $request)
	{
        if(!$_POST){
            
            $categories = HelpCategory::where('status', 'Active')->get();
            return view('admin/help_subcategory/add', compact('categories'));
            
		}else{
           
            $helpsubcategory                     = new HelpSubCategory;
            
            $helpsubcategory->name               = $request->name;           
            $helpsubcategory->category_id        = $request->category_id;           
            $helpsubcategory->status             = $request->status;            
            $helpsubcategory->description        = $request->description;  
                  
            $helpsubcategory->save();           
            
            return redirect()->route('admin.help_subcategory')
                    ->with('success','New  Help Category Added!');
			
		}
    }
        

    /**
     * @des: update  HelpSubCategory 
     * @param: HelpSubCategory Edit Form Data
     * @return: view-> admin/help_subcategory/edit.blade.php  ///////   view-> admin/help_subcategory/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function update(Request $request)
	{
		if(!$_POST){

            $categories             = HelpCategory::where('status', 'Active')->get();
			$helpsubcategory        = HelpSubCategory::find($request->id);	
            return view('admin/help_subcategory/edit', compact('helpsubcategory', 'categories'));
            
		}else{		           
           
            $helpsubcategory                     = HelpSubCategory::find($request->id);
            
            $helpsubcategory->name               = $request->name;
            $helpsubcategory->category_id        = $request->category_id;              
            $helpsubcategory->status             = $request->status;     
            $helpsubcategory->description        = $request->description;    
           

            $helpsubcategory->save();  

            return redirect()->route('admin.help_subcategory')
                    ->with('success','Help Category Updated!');
			
		}
		
    }

    /**
     * @des: delete  HelpSubCategory 
     * @param: delete
     * @return: view-> admin/help_subcategory/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function delete(Request $request){

        HelpSubCategory::find($request->did)->delete();
        return redirect()->route('admin.help_subcategory')
                ->with('success','Help Category Deleted!');
    }
    



}