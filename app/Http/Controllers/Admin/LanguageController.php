<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

use App\Models\admin\Language;
use App\Models\admin\HostExperiences;

class LanguageController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }



    /**
     * @des: Manage  Language 
     * @param: 
     * @return: view-> admin/language/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function index()
    {           
        $data = Language::get();        
        return view('admin/language/index', compact('data'));
        
    }

    /**
     * @des: add  Property Type 
     * @param: Language Add Form Data
     * @return: view-> admin/language/add.blade.php  ///////  view-> admin/language/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function add(Request $request)
	{
        if(!$_POST){
            
            return view('admin/language/add');
            
		}else{
           
            $language                     = new Language;
            
            $language->name               = $request->name;           
            $language->value              = $request->value;     
            $language->default_language   = "0";     
            $language->status             = $request->status;     
               
            
            $language->save();           
            
            return redirect()->route('admin.language')
                    ->with('success','New  Language Added!');
			
		}
    }
        

    /**
     * @des: update  Language 
     * @param: Language Edit Form Data
     * @return: view-> admin/language/edit.blade.php  ///////   view-> admin/language/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function update(Request $request)
	{
		if(!$_POST){

			$language       = Language::find($request->id);	
            return view('admin/language/edit', compact('language'));
            
		}else{		           
           
            $language                     = Language::find($request->id);
            
            $language->name               = $request->name;           
            $language->value              = $request->value;     
            $language->default_language   = "0";     
            $language->status             = $request->status;     
               
            
            $language->save();           
            

            return redirect()->route('admin.language')
                    ->with('success','Language Updated!');
			
		}
		
    }

    /**
     * @des: delete  Language 
     * @param: delete
     * @return: view-> admin/language/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function delete(Request $request){

        Language::find($request->did)->delete();
        return redirect()->route('admin.language')
                ->with('success','Language Deleted!');
    }
    



}