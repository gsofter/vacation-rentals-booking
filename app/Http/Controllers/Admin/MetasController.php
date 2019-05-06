<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

use App\Models\admin\Page;
use App\Models\admin\Post;
use App\Models\admin\Rooms;
use App\Models\admin\Metas;

class MetasController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }



    /**
     * @des: Manage  Metas 
     * @param: 
     * @return: view-> admin/metas/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function index()
    {           
        $data = Metas::get();        
        return view('admin/metas/index', compact('data'));
        
    }

    /**
     * @des: add  Property Type 
     * @param: Metas Add Form Data
     * @return: view-> admin/metas/add.blade.php  ///////  view-> admin/metas/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function add(Request $request)
	{
        if(!$_POST){
            $pages = Page::get();
            $rooms = Rooms::get();
            return view('admin/metas/add', compact('pages', 'rooms'));
            
		}else{
           
            $meta                     = new Metas;
            
            $meta->url               = $request->url;           
            $meta->title             = $request->title;     
            $meta->meta_h1           = $request->meta_h1;     
            $meta->description       = $request->description;     
            $meta->keywords          = $request->keywords;          
            $meta->page_id           = 0;          
            
            $meta->save();           
            
            return redirect()->route('admin.metas')
                    ->with('success','New  Metas Added!');
			
		}
    }
        

    /**
     * @des: update  Metas 
     * @param: Metas Edit Form Data
     * @return: view-> admin/metas/edit.blade.php  ///////   view-> admin/metas/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function update(Request $request)
	{
		if(!$_POST){

            $pages      = Page::get();
            $rooms      = Rooms::get();
			$meta       = Metas::find($request->id);	
            return view('admin/metas/edit', compact('pages', 'rooms', 'meta'));
            
		}else{		           
           
            $meta                     = Metas::find($request->id);
            
            $meta->url               = $request->url;           
            $meta->title             = $request->title;     
            $meta->meta_h1           = $request->meta_h1;     
            $meta->description       = $request->description;     
            $meta->keywords          = $request->keywords;     
            $meta->page_id           = 0; 
            
            $meta->save();               

            return redirect()->route('admin.metas')
                    ->with('success','Metas Updated!');
			
		}
		
    }

    /**
     * @des: delete  Metas 
     * @param: delete
     * @return: view-> admin/metas/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function delete(Request $request){

        Metas::find($request->did)->delete();
        return redirect()->route('admin.metas')
                ->with('success','Metas Deleted!');
    }
    



}