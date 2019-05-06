<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

use App\Models\admin\Slider;

class SliderController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }



    /**
     * @des: Manage  slider 
     * @param: 
     * @return: view-> admin/slider/index.blade.php
     * @dev: Artemova
     * @date:2019/10/14 
    */
    public function index()
    {           
        $data = Slider::get();        
        return view('admin/slider/index', compact('data'));
        
    }

    /**
     * @des: add  slider 
     * @param: slider Add Form Data
     * @return: view-> admin/slider/add.blade.php  ///////  view-> admin/slider/index.blade.php
     * @dev: Artemova
     * @date:2019/10/14 
    */
    public function add(Request $request)
	{
        if(!$_POST){

            return view('admin/slider/add');
            
		}else{
           
            $slider                     = new Slider;
            
            $slider->order              = $request->order;
            $slider->status             = $request->status;
            
            if( $uploadimage			= $request -> file('image')) {			
                $file_name 				= time() .'_slider_image.' . $uploadimage->getClientOriginalExtension();
               
                $uploadimage->move(public_path('images/slider'), $file_name);
                $slider->image 		= $file_name;
            }

            $slider->save();           
            
            return redirect()->route('admin.slider')
                    ->with('success','New  slider Added!');
			
		}
    }
        

    /**
     * @des: update  slider 
     * @param: slider Edit Form Data
     * @return: view-> admin/slider/edit.blade.php  ///////   view-> admin/slider/index.blade.php
     * @dev: Artemova
     * @date:2019/10/14 
    */
    public function update(Request $request)
	{
		if(!$_POST){

			$slider     = Slider::find($request->id);	
            return view('admin/slider/edit', compact('slider'));
            
		}else{		           
           
            $slider                         = Slider::find($request->id);
            $slider->order                  = $request->order;
            $slider->status                 = $request->status;                    
            $slider->image 		        = $request->orginalimage;
            if( $uploadimage			    = $request->file('image')) {			
                $file_name 				    = time() .'_slider_image.' . $uploadimage->getClientOriginalExtension();               
                $uploadimage->move(public_path('images/slider'), $file_name);
                $slider->image 		    = $file_name;
            }
            $slider->save();  

            return redirect()->route('admin.slider')
                    ->with('success','slider Updated!');
			
		}
		
    }

    /**
     * @des: delete  slider 
     * @param: delete
     * @return: view-> admin/slider/index.blade.php
     * @dev: Artemova
     * @date:2019/10/14 
    */
    public function delete(Request $request){

        Slider::find($request->did)->delete();
        return redirect()->route('admin.slider')
                ->with('success','Slider Deleted!');
    }
    



}