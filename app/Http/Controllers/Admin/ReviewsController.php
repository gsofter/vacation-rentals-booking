<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Models\admin\Reviews;

class ReviewsController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * @des: Manage  Reviews 
     * @param: 
     * @return: view-> admin/reviews/index.blade.php
     * @dev: Artemova
     * @date:2019/10/12 
    */
    public function reviews()
    {           
        $data = Reviews::get();        
        return view('admin/reviews/index', compact('data'));
        
    }
   

    /**
     * @des: update  reviews 
     * @param: User Edit Form Data
     * @return: view-> admin/reviews/edit.blade.php  ///////   view-> admin/reviews/index.blade.php
     * @dev: Artemova
     * @date:2019/10/12 
    */
    public function update(Request $request)
	{
		if(!$_POST){		

            $review  = Reviews::find($request->id);		
            return view('admin/reviews/edit', compact('review'));
            
		}else{		
           
            $review                = Reviews::find($request->id);
           
            $review->comments     = $request->comments;       
            $review->status       = $request->status;      

            $review->save();
         
            return redirect()->route('admin.reviews')
                    ->with('success','reviews Updated!');
			
		}
		
    }


}