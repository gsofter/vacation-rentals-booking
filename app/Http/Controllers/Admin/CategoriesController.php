<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

use App\Models\admin\Category;

class CategoriesController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }



    /**
     * @des: Manage  Category 
     * @param: 
     * @return: view-> admin/slider/index.blade.php
     * @dev: Artemova
     * @date:2019/10/14 
    */
    public function index()
    {           
        $data = Category::get();        
        return view('admin/category/index', compact('data'));
        
    }

    /**
     * @des: add  Category 
     * @param: Category Add Form Data
     * @return: view-> admin/category/add.blade.php  ///////  view-> admin/category/index.blade.php
     * @dev: Artemova
     * @date:2019/10/14 
    */
    public function add(Request $request)
	{
        if(!$_POST){

            return view('admin/category/add');
            
		}else{
           
            $category                   = new Category;
            
            $category->name             = $request->name;
            $lowerName                  = strtolower($request->name);
            $slug                       = str_replace(' ', '_', $lowerName);
            $category->slug             = $slug;   

            $category->save();           
            
            return redirect()->route('admin.categories')
                    ->with('success','New  category Added!');
			
		}
    }
        

    /**
     * @des: update  Category 
     * @param: Category Edit Form Data
     * @return: view-> admin/category/edit.blade.php  ///////   view-> admin/category/index.blade.php
     * @dev: Artemova
     * @date:2019/10/14 
    */
    public function update(Request $request)
	{
		if(!$_POST){

			$category     = Category::find($request->id);	
            return view('admin/category/edit', compact('category'));
            
		}else{		           
           
            $category                     = Category::find($request->id);

            $category->name             = $request->name;
            $lowerName                  = strtolower($request->name);
            $slug                       = str_replace(' ', '_', $lowerName);
            $category->slug             = $slug; 

            $category->save();  

            return redirect()->route('admin.categories')
                    ->with('success','category Updated!');
			
		}
		
    }

    /**
     * @des: delete  Category 
     * @param: delete
     * @return: view-> admin/category/index.blade.php
     * @dev: Artemova
     * @date:2019/10/14 
    */
    public function delete(Request $request){

        Category::find($request->did)->delete();
        return redirect()->route('admin.categories')
                ->with('success','category Deleted!');
    }
    



}