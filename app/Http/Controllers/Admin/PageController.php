<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

use App\Models\admin\Page;
use App\Models\admin\Permalink;
use App\Models\admin\Template;
use App\Models\admin\Language;

class PageController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }



    /**
     * @des: Manage  Page 
     * @param: 
     * @return: view-> admin/pages/index.blade.php
     * @dev: Artemova
     * @date:2019/10/14 
    */
    public function index()
    {           
        $data = Page::get();        
        return view('admin/pages/index', compact('data'));
        
    }

    /**
     * @des: add  Page 
     * @param: Page Add Form Data
     * @return: view-> admin/pages/add.blade.php  ///////  view-> admin/pages/index.blade.php
     * @dev: Artemova
     * @date:2019/10/14 
    */
    public function add(Request $request)
	{
        if(!$_POST){
           
            $templates      = Template::whereType('page')->get();
            $parents        = Permalink::get();
            return view('admin/pages/add', compact('templates', 'parents'));
            
		}else{
                     
            $page                       = new Page;
            
            $page->name                 = $request->name;
            $page->excerpt              = $request->excerpt;
            $page->content              = $request->content;
            $page->status               = $request->status;
            $page->footer               = $request->footer;
            $page->under                = $request->under;
            $page->template_id          = $request->template_id;
            $page->status               = $request->status;
            
            if( $uploadimage			= $request -> file('image')) {			
                $file_name 				= time() .'_page_image.' . $uploadimage->getClientOriginalExtension();
               
                $uploadimage->move(public_path('images/pages'), $file_name);
                $page->image 		    = $file_name;
            }

            $page->save(); 

          
            return redirect()->route('admin.pages')
                    ->with('success','New  Page Added!');
			
		}
    }
        

    /**
     * @des: update  Post 
     * @param: Post Edit Form Data
     * @return: view-> admin/pages/edit.blade.php  ///////   view-> admin/pages/index.blade.php
     * @dev: Artemova
     * @date:2019/10/14 
    */
    public function update(Request $request)
	{
		if(!$_POST){

            $templates      = Template::whereType('page')->get();
            $parents        = Permalink::get();
            $page           = Page::find($request->id);			
            return view('admin/pages/edit', compact('templates', 'parents', 'page'));
            
		}else{		           
           
            $page                       = Page::find($request->id);
           
            $page->name                 = $request->name;
            $page->excerpt              = $request->excerpt;
            $page->content              = $request->content;
            $page->status               = $request->status;
            $page->footer               = $request->footer;
            $page->under                = $request->under;
            $page->template_id          = $request->template_id;
            $page->status               = $request->status;
            

            $page->image 		          = $request->orginalimage;
            if( $uploadimage			          = $request->file('image')) {			
                $file_name 				          = time() .'_page_image.' . $uploadimage->getClientOriginalExtension();               
                $uploadimage->move(public_path('images/pages'), $file_name);
                $page->image 		      = $file_name;
            }           
           
            $page->save(); 

            return redirect()->route('admin.pages')
                    ->with('success','Page Updated!');
			
		}
		
    }

    /**
     * @des: delete  page 
     * @param: delete
     * @return: view-> admin/pages/index.blade.php
     * @dev: Artemova
     * @date:2019/10/14 
    */
    public function delete(Request $request){
        
        Page::find($request->did)->delete();
        return redirect()->route('admin.pages')
                ->with('success','Page Deleted!');
    }
    



}