<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\admin\Admin;
use App\User;
use App\Models\admin\Reservation;
use App\Models\admin\Rooms;

class AdminController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * @des: Show admin Dashooard 
     * @param: 
     * @return: view-> admin/dashboard/dashboard.blade.php
     * @dev: Artemova
     * @date:2019/10/11 
    */
    public function index()
    {
        // dd('Hello');
        $data['users_count']                = User::get()->count();
       
        $data['reservations_count']         = Reservation::get()->count();
        $data['rooms_count']                = Rooms::get()->count();
        $data['today_users_count']          = User::whereDate('created_at', '=', date('Y-m-d'))->count();
        $data['today_reservations_count']   = Reservation::whereDate('created_at', '=', date('Y-m-d'))->count();
        $data['today_rooms_count']          = Rooms::whereDate('created_at', '=', date('Y-m-d'))->count();

        $chart                              = Reservation::whereYear('created_at', '<=', date('Y'))->whereYear('created_at', '>=', date('Y')-3)->where('status', 'Accepted')->get();

        $quarter1 = ['01', '02', '03'];
        $quarter2 = ['04', '05', '06'];
        $quarter3 = ['07', '08', '09'];
        $quarter4 = ['10', '11', '12'];

        $chart_array = [];

        foreach($chart as $row)
        {
            $month = date('m', strtotime($row->created_at));
            $year = date('Y', strtotime($row->created_at));

            if(in_array($month, $quarter1))
                $quarter = 1;
            if(in_array($month, $quarter2))
                $quarter = 2;
            if(in_array($month, $quarter3))
                $quarter = 3;
            if(in_array($month, $quarter4))
                $quarter = 4;

            $array['y'] = $year.' Q'.$quarter;
            $array['amount'] = $row->total;

            $chart_array[] = $array;
        }

        $data['line_chart_data'] = json_encode($chart_array);

        return view('admin/dashboard/dashboard', $data);
    }
}