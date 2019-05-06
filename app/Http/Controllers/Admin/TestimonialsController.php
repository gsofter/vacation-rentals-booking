<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;


use App\Models\admin\Testimonials;
use App\Models\admin\Post;
use App\Models\admin\Admin;
use App\Models\admin\Tag;

class TestimonialsController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }



    /**
     * @des: Manage  Testimonials 
     * @param: 
     * @return: view-> admin/testimonials/index.blade.php
     * @dev: Artemova
     * @date:2019/10/14 
    */
    public function index()
    {           
        $data = Testimonials::get();        
        return view('admin/testimonials/index', compact('data'));
        
    }

    /**
     * @des: add  Testimonials 
     * @param: Testimonials Add Form Data
     * @return: view-> admin/testimonials/add.blade.php  ///////  view-> admin/testimonials/index.blade.php
     * @dev: Artemova
     * @date:2019/10/14 
    */
    public function add(Request $request)
	{
        if(!$_POST){
            $authores       = $referrals = $referrers = User::get();           
            return view('admin/testimonials/add', compact('authores'));
            
		}else{
             
            $testimonial                     = new Testimonials;
            
            $testimonial->title              = $request->title;
            $testimonial->excerpt            = $request->excerpt;
            $testimonial->content            = $request->content;
            $testimonial->status             = $request->status;
            $testimonial->author_id          = $request->author_id;           
            $testimonial->publish_date       = $request->publish_date;

            if($request->featured == "1")
                $testimonial->featured       = 1;
            else
                $testimonial->featured       = 0;
            
            $testimonial->save(); 

           
            return redirect()->route('admin.testimonials')
                    ->with('success','New  testimonial Added!');
			
		}
    }
        

    /**
     * @des: update  Testimonials 
     * @param: Testimonials Edit Form Data
     * @return: view-> admin/testimonials/edit.blade.php  ///////   view-> admin/testimonials/index.blade.php
     * @dev: Artemova
     * @date:2019/10/14 
    */
    public function update(Request $request)
	{
		if(!$_POST){
            $testimonial    = Testimonials::find($request->id);            
            $authores       = $referrals = $referrers = User::get();
                   
			
            return view('admin/testimonials/edit', compact('testimonial', 'authores'));
            
		}else{		           
           
            $testimonial                     = Testimonials::find($request->id);

            $testimonial->title              = $request->title;
            $testimonial->excerpt            = $request->excerpt;
            $testimonial->content            = $request->content;
            $testimonial->status             = $request->status;
            $testimonial->author_id          = $request->author_id;           
            $testimonial->publish_date       = $request->publish_date;

            if($request->featured == "1")
                $testimonial->featured      = 1;
            else
                $testimonial->featured      = 0;

            $testimonial->save();             

            return redirect()->route('admin.testimonials')
                    ->with('success','testimonial Updated!');
			
		}
		
    }

    /**
     * @des: delete  Testimonials 
     * @param: delete
     * @return: view-> admin/testimonials/index.blade.php
     * @dev: Artemova
     * @date:2019/10/14 
    */
    public function delete(Request $request){
       
        Testimonials::find($request->did)->delete();
        return redirect()->route('admin.testimonials')
                ->with('success','testimonial Deleted!');
    }
    



}