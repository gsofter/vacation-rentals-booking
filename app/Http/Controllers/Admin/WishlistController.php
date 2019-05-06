<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

use App\Models\admin\Wishlists;

class WishlistController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    /**
     * @des: Manage  wishlists 
     * @param: 
     * @return: view-> admin/wishlists/wishlists.blade.php
     * @dev: Artemova
     * @date:2019/10/13 
    */
    public function wishlists()
    {           
        $data = Wishlists::get(); 
                 
        return view('admin/wishlists/index', compact('data'));
        
    }
   
    /**
     * @des: pick  wishlists 
     * @param: 
     * @return: view-> admin/wishlists/wishlists.blade.php  
     * @dev: Artemova
     * @date:2019/10/13 
    */
    public function pick($id)
	{
		$prev               = Wishlists::find($id)->pick;
        $privacy            = Wishlists::find($id)->privacy;

        if($prev == 'Yes'){
            Wishlists::where('id',$id)->update(['pick'=>'No']);
            return redirect()->route('admin.wishlists')
                    ->with('success','Update Successfully!');    
        }
        else{
            if($privacy=="1")
            {                
                return redirect()->route('admin.wishlists')
                    ->with('warning','Selected wishlist is private. So can\'t change picks!');
            }
            else
            {
                Wishlists::where('id',$id)->update(['pick'=>'Yes']);
                return redirect()->route('admin.wishlists')
                    ->with('success','Update Successfully!');    
            }
            
        }

    }    
       

}