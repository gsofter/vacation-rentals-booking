<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use Session;

use App\Models\admin\Reservation;
use App\Models\admin\ProfilePicture;
use App\Models\admin\PaymentGateway;
use App\Models\admin\Payouts;
use App\Models\admin\Messages;

class ReservationsController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }



    /**
     * @des: Manage  Reservation 
     * @param: 
     * @return: view-> admin/reservations/index.blade.php
     * @dev: Artemova
     * @date:2019/10/12 
    */
    public function index()
    {           
        $data = Reservation::get();        
        return view('admin/reservations/index', compact('data'));
        
    }

    /**
     * @des: Detail Reservation
     * @param:  Reservation id
     * @return: view-> admin/reservations/detail.blade.php
     * @dev: Artemova
     * @date:2019/10/12 
    */
   public function detail($id){
        $reservation       = Reservation::find($id);	
        return view('admin/reservations/detail', compact('reservation'));
   }

    /**
     * @des: Conversation Reservation
     * @param:  Reservation id
     * @return: view-> admin/reservations/detail.blade.php
     * @dev: Artemova
     * @date:2019/10/12 
    */
   public function conversation($id){
        $reservation        = Reservation::find($id);
        $message            = Messages::where('reservation_id','=',$id)->orderBy('id','DESC')->get();
       
        return view('admin/reservations/conversation', compact('reservation', 'message'));
   }


}