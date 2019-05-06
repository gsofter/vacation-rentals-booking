<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

use App\Models\admin\BottomSlider;

class BottomSliderController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }



    /**
     * @des: Manage  BottomSlider 
     * @param: bottomslider
     * @return: view-> admin/bottomslider/index.blade.php
     * @dev: Artemova
     * @date:2019/10/14 
    */
    public function index()
    {           
        $data = BottomSlider::get();        
        return view('admin/bottomslider/index', compact('data'));
        
    }

    /**
     * @des: add  BottomSlider 
     * @param: BottomSlider Add Form Data
     * @return: view-> admin/bottomslider/add.blade.php  ///////  view-> admin/bottomslider/index.blade.php
     * @dev: Artemova
     * @date:2019/10/14 
    */
    public function add(Request $request)
	{
        if(!$_POST){

            return view('admin/bottomslider/add');
            
		}else{
           
            $bottomslider                     = new BottomSlider;
            
            $bottomslider->title              = $request->title;
            $bottomslider->description        = $request->description;
            $bottomslider->order              = $request->order;
            $bottomslider->status             = $request->status;
            
            if( $uploadimage			      = $request -> file('image')) {			
                $file_name 				      = time() .'_bottom_slider_image.' . $uploadimage->getClientOriginalExtension();
               
                $uploadimage->move(public_path('images/bottom_slider'), $file_name);
                $bottomslider->image 		  = $file_name;
            }

            $bottomslider->save();           
            
            return redirect()->route('admin.bottom_slider')
                    ->with('success','New Bottom slider Added!');
			
		}
    }
        

    /**
     * @des: update  BottomSlider 
     * @param: BottomSlider Edit Form Data
     * @return: view-> admin/bottomslider/edit.blade.php  ///////   view-> admin/bottomslider/index.blade.php
     * @dev: Artemova
     * @date:2019/10/14 
    */
    public function update(Request $request)
	{
		if(!$_POST){

			$bottomslider     = BottomSlider::find($request->id);	
            return view('admin/bottomslider/edit', compact('bottomslider'));
            
		}else{		           
           
            $bottomslider                         = BottomSlider::find($request->id);
            $bottomslider->title                  = $request->title;
            $bottomslider->description            = $request->description;
            $bottomslider->order                  = $request->order;
            $bottomslider->status                 = $request->status;                    
            $bottomslider->image 		          = $request->orginalimage;
            if( $uploadimage			          = $request->file('image')) {			
                $file_name 				          = time() .'_bottom_slider_image.' . $uploadimage->getClientOriginalExtension();               
                $uploadimage->move(public_path('images/bottom_slider'), $file_name);
                $bottomslider->image 		      = $file_name;
            }
            $bottomslider->save();  

            return redirect()->route('admin.bottom_slider')
                    ->with('success','bottom slider Updated!');
			
		}
		
    }

    /**
     * @des: delete  BottomSlider 
     * @param: delete
     * @return: view-> admin/slider/index.blade.php
     * @dev: Artemova
     * @date:2019/10/14 
    */
    public function delete(Request $request){

        BottomSlider::find($request->did)->delete();
        return redirect()->route('admin.bottom_slider')
                ->with('success','bottom slider Deleted!');
    }
    



}