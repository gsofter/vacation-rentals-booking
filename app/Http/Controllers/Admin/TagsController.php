<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

use App\Models\admin\Tag;

class TagsController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }



    /**
     * @des: Manage  Tag 
     * @param: 
     * @return: view-> admin/tags/index.blade.php
     * @dev: Artemova
     * @date:2019/10/14 
    */
    public function index()
    {           
        $data = Tag::get();        
        return view('admin/tags/index', compact('data'));
        
    }

    /**
     * @des: add  Tag 
     * @param: Tag Add Form Data
     * @return: view-> admin/tags/add.blade.php  ///////  view-> admin/tags/index.blade.php
     * @dev: Artemova
     * @date:2019/10/14 
    */
    public function add(Request $request)
	{
        if(!$_POST){

            return view('admin/tags/add');
            
		}else{
           
            $tag                     = new Tag;
            
            $tag->name              = $request->name;
            $lowerName              = strtolower($request->name);
            $slug                   = str_replace(' ', '_', $lowerName);
            $tag->slug              = $slug;            
            
            $tag->save();           
            
            return redirect()->route('admin.tags')
                    ->with('success','New  tag Added!');
			
		}
    }
        

    /**
     * @des: update  Tag 
     * @param: Tag Edit Form Data
     * @return: view-> admin/tags/edit.blade.php  ///////   view-> admin/tags/index.blade.php
     * @dev: Artemova
     * @date:2019/10/14 
    */
    public function update(Request $request)
	{
		if(!$_POST){

			$tag     = Tag::find($request->id);	
            return view('admin/tags/edit', compact('tag'));
            
		}else{		           
           
            $tag                    = Tag::find($request->id);
            $tag->name              = $request->name;
            $lowerName              = strtolower($request->name);
            $slug                   = str_replace(' ', '_', $lowerName);
            $tag->slug              = $slug;   
            $tag->save();  

            return redirect()->route('admin.tags')
                    ->with('success','tag Updated!');
			
		}
		
    }

    /**
     * @des: delete  Tag 
     * @param: delete
     * @return: view-> admin/tags/index.blade.php
     * @dev: Artemova
     * @date:2019/10/14 
    */
    public function delete(Request $request){

        Tag::find($request->did)->delete();
        return redirect()->route('admin.tags')
                ->with('success','tag Deleted!');
    }
    



}