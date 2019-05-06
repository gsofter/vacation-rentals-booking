<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

use App\Models\admin\Template;

class TemplateController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }



    /**
     * @des: Manage  Template 
     * @param: 
     * @return: view-> admin/templates/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function index()
    {           
        $data = Template::get();        
        return view('admin/templates/index', compact('data'));
        
    }

    /**
     * @des: add  Property Type 
     * @param: Template Add Form Data
     * @return: view-> admin/templates/add.blade.php  ///////  view-> admin/templates/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function add(Request $request)
	{
        if(!$_POST){

            return view('admin/templates/add', compact('languages'));
            
		}else{
           
            $template                     = new Template;
            
            $template->name               = $request->name;           
            $template->type               = $request->type;     
            $template->action             = $request->action;     
                  
            $template->save();           
            
            return redirect()->route('admin.templates')
                    ->with('success','New  Template Added!');
			
		}
    }
        

    /**
     * @des: update  Template 
     * @param: Template Edit Form Data
     * @return: view-> admin/templates/edit.blade.php  ///////   view-> admin/templates/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function update(Request $request)
	{
		if(!$_POST){

            
			$template       = Template::find($request->id);	
            return view('admin/templates/edit', compact( 'template'));
            
		}else{		           
           
            $template                     = Template::find($request->id);
            
            $template->name               = $request->name;           
            $template->type               = $request->type;     
            $template->action             = $request->action;     
                  
            $template->save();   
           
            return redirect()->route('admin.templates')
                    ->with('success','Template Updated!');
			
		}
		
    }

    /**
     * @des: delete  Template 
     * @param: delete
     * @return: view-> admin/templates/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function delete(Request $request){

        Template::find($request->did)->delete();
        return redirect()->route('admin.templates')
                ->with('success','Template Deleted!');
    }
    



}