<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use DB;
use App\Models\admin\Rooms;
use App\Models\admin\HostExperiences;
use App\Models\admin\Reservation;


class ReportsController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }



    /**
     * @des: Manage  reports 
     * @param: 
     * @return: view-> admin/reports/index.blade.php
     * @dev: Artemova
     * @date:2019/10/17 
    */
    public function index()
    {                       
        return view('admin/reports/index');
        
    }

    /**
     * @des: get Report Data
     * @param: from date and to date and category(user/room/reservation)
     * @return: view-> admin/help/add.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function export($from, $to, $category)
    {

        if($category == 'User') {
            $result = User::where('created_at', '>=', $from)->where('created_at', '<=', $to)->get();
        }else if($category == 'Rooms') {            
            $result = DB::table('rooms')
                ->join('users', 'rooms.user_id', '=', 'users.id')
                ->join('room_type', 'rooms.room_type', '=', 'room_type.id')
                ->join('property_type', 'rooms.property_type', '=', 'property_type.id')                                 
                ->select('rooms.*', 'users.first_name', 'users.last_name', 'room_type.name as rname', 'property_type.name as pname')
                ->where('rooms.created_at', '>=', $from)
                ->where('rooms.created_at', '<=', $to)                  
                ->get();	
            
        }else{
           
            $result = DB::table('reservation')
                        ->join('users as u1', 'reservation.host_id', '=', 'u1.id')
                        ->join('users as u2', 'reservation.user_id', '=', 'u2.id')
                        ->join('rooms', 'reservation.room_id', '=', 'rooms.id')                        
                        ->select(['reservation.*', 'u1.first_name as host_name', 'u2.first_name as guest_name', 'rooms.name as room_name'])
                        ->where('reservation.created_at', '>=', $from)
                        ->where('reservation.created_at', '<=', $to) 
                        ->get();
        }

        $data['status']             = 1;
		$data['category']    		= $category;
		$data['data']    			= $result;			 
		return response()->json($data, 200); 
    }

}