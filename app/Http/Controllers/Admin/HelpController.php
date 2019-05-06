<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

use App\Models\admin\HelpCategory;
use App\Models\admin\HelpSubCategory;
use App\Models\admin\Help;

class HelpController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }



    /**
     * @des: Manage  Help 
     * @param: 
     * @return: view-> admin/help/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function index()
    {           
        $data = Help::get();        
        return view('admin/help/index', compact('data'));
        
    }

    /**
     * @des: add  Help 
     * @param: Help Add Form Data
     * @return: view-> admin/help/add.blade.php  ///////  view-> admin/help/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function add(Request $request)
	{
        if(!$_POST){
            
            $categories     = HelpCategory::where('status', 'Active')->get();
            $subcategories  = HelpSubCategory::where('status', 'Active')->get();
            return view('admin/help/add', compact('categories', 'subcategories'));
            
		}else{
           
            $help                           = new Help;
            
            $help->question                 = $request->question;
            $help->category_id              = $request->category_id;              
            if($request->subcategory_id)              
                $help->subcategory_id       = $request->subcategory_id; 
            else             
                $help->subcategory_id       = 0;                
            $help->status                   = $request->status;     
            $help->answer                   = $request->answer;    
            $help->suggested                = $request->suggested;    
                  
            $help->save();           
            
            return redirect()->route('admin.help')
                    ->with('success','New  Help  Added!');
			
		}
    }
        

    /**
     * @des: update  Help 
     * @param: Help Edit Form Data
     * @return: view-> admin/help/edit.blade.php  ///////   view-> admin/help/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function update(Request $request)
	{
		if(!$_POST){

            $categories             = HelpCategory::where('status', 'Active')->get();
            $subcategories          = HelpSubCategory::where('status', 'Active')->get();
			$help                   = Help::find($request->id);	
            return view('admin/help/edit', compact('help', 'categories', 'subcategories'));
            
		}else{		           
           
            $help                           = Help::find($request->id);
            
            $help->question                 = $request->question;
            $help->category_id              = $request->category_id;
            if($request->subcategory_id)              
                $help->subcategory_id       = $request->subcategory_id; 
            else             
                $help->subcategory_id       = 0;              
            $help->status                   = $request->status;     
            $help->answer                   = $request->answer;    
            $help->suggested                = $request->suggested;

            $help->save();  

            return redirect()->route('admin.help')
                    ->with('success','Help  Updated!');
			
		}
		
    }

    /**
     * @des: delete  Help 
     * @param: delete
     * @return: view-> admin/help/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function delete(Request $request){

        Help::find($request->did)->delete();
        return redirect()->route('admin.help')
                ->with('success','Help  Deleted!');
    }
    
    /**
     * @des: get subcategories data by category id 
     * @param: category id
     * @return: view-> admin/help/add.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function ajax_help_subcategory(Request $request)
    {
        $result = HelpSubCategory::where('category_id', $request->id)->get();
        $data['status'] = 1;
		$data['msg']    			 = "success";
		$data['data']    			 = $result;			 
		return response()->json($data, 200); 
    }


}