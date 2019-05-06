<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Front\Rooms;
use App\Models\Front\RoomTag;
use App\Models\Front\HomeCities;
use App\Models\Front\ThemeSettings;
use App\Models\Front\Slider;
use App\Models\Front\BottomSlider;
use App\Models\Front\HostBanners;
use App\Models\Front\OurCommunityBanners;
use App\Models\Front\Reservation;
use App\Models\Front\HostExperiences;
use App\Models\Front\SiteSettings;
use App\Models\Front\Language;
use Auth;
use App\Models\Front\User;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    

    // homepage

    public function indexpage(){
        $data['home_city']	   = HomeCities::all();
		$data['city_count']	   = HomeCities::all()->count();
        $data['result']        = ThemeSettings::get();
        
        $data['home_page_media'] = SiteSettings::where('name', 'home_page_header_media')->first()->value;
		$data['home_page_sliders'] = Slider::whereStatus('Active')->orderBy('order', 'asc')->get();
		$data['home_page_bottom_sliders'] = BottomSlider::whereStatus('Active')->orderBy('order', 'asc')->get();
		$data['host_banners'] = HostBanners::all();
		$data['bottom_sliders'] = BottomSlider::whereStatus('Active')->orderBy('order', 'asc')->get();
        $data['our_community_banners'] = OurCommunityBanners::limit(3)->get();
        $data['tags'] = RoomTag::active()->with('rooms')->get();
        // dd($data['tags'][0]);
        if($data['tags'][0]){
            $room = $data['tags'][0]->rooms()->first();
            
            $slide_array = array();
            foreach ($data['tags'][0]->rooms()->get() as $key => $room) {
                # code...
                $new_array1['featured_image'] = $room->getFeaturedImageSmallAttribute();
                $new_array1['sub_name'] = $room->sub_name;
                $new_array1['short_description'] = $room->short_description;
                $new_array1['name'] = $room->name;
                $new_array1['address_url'] = $room->address_url;
                $new_array1['room_id'] = $room->id;
                $slide_array[] = $new_array1;
            }
            $data['small_slide_data'] = $slide_array;
        }
        else{
            $data['small_slide_data'] = array();
        }
        foreach ($data['tags'] as $key => $tag) {
            # code...
           $room = $tag->rooms()->first();
            $new_array['featured_image'] = $room->featured_image;
            $new_array['sub_name'] = $room->sub_name;
            $new_array['short_description'] = $room->short_description;
            $new_array['name'] = $room->name;
            $new_array['address_url'] = $room->address_url;
            $new_array['room_id'] = $room->id;
            $data['tags'][$key]['first_room'] = $new_array;
           
        }

        $index_page_data = $data;
        return view('welcome', compact('index_page_data'));
    }
    public function index()
    {
        
        // $data['popular_rooms'] = Rooms::where('status','Listed')->get();
        $data['home_city']	   = HomeCities::all();
		$data['city_count']	   = HomeCities::all()->count();
        $data['result']        = ThemeSettings::get();
        
        $data['home_page_media'] = SiteSettings::where('name', 'home_page_header_media')->first()->value;
		$data['home_page_sliders'] = Slider::whereStatus('Active')->orderBy('order', 'asc')->get();
		$data['home_page_bottom_sliders'] = BottomSlider::whereStatus('Active')->orderBy('order', 'asc')->get();
		$data['host_banners'] = HostBanners::all();
		$data['bottom_sliders'] = BottomSlider::whereStatus('Active')->orderBy('order', 'asc')->get();
        $data['our_community_banners'] = OurCommunityBanners::limit(3)->get();
        $data['tags'] = RoomTag::active()->with('rooms')->get();
        // dd($data['tags'][0]);
        if($data['tags'][0]){
            $room = $data['tags'][0]->rooms()->first();
            
            $slide_array = array();
            foreach ($data['tags'][0]->rooms()->get() as $key => $room) {
                # code...
                $new_array1['featured_image'] = $room->getFeaturedImageSmallAttribute();
                $new_array1['sub_name'] = $room->sub_name;
                $new_array1['short_description'] = $room->short_description;
                $new_array1['name'] = $room->name;
                $new_array1['address_url'] = $room->address_url;
                $new_array1['room_id'] = $room->id;
                $slide_array[] = $new_array1;
            }
            $data['small_slide_data'] = $slide_array;
        }
        else{
            $data['small_slide_data'] = array();
        }
        foreach ($data['tags'] as $key => $tag) {
            # code...
           $room = $tag->rooms()->first();
            $new_array['featured_image'] = $room->featured_image;
            $new_array['sub_name'] = $room->sub_name;
            $new_array['short_description'] = $room->short_description;
            $new_array['name'] = $room->name;
            $new_array['address_url'] = $room->address_url;
            $new_array['room_id'] = $room->id;
            $data['tags'][$key]['first_room'] = $new_array;
           
        }
        return $data;
		$data['reservation'] = Reservation::where('list_type', 'Rooms')->whereHas('host_users',function($query){ $query->where('status','Active');})->orderBy('id', 'desc')->where('status','Accepted')->groupBy('room_id')->limit(10)->get();
		$data['view_count'] = Rooms::whereHas('users',function($query){ $query->where('status','Active');})->orderBy('views_count', 'desc')->where('status','Listed')->groupBy('id')->get();
		$data['recommented'] = Rooms::whereHas('users',function($query){ $query->where('status','Active');})->orderBy('id', 'desc')->where('recommended','Yes')->where('status','Listed')->groupBy('id')->get();

		$data['res_count'] = count($data['reservation']);
		$data['room_view_count'] = count($data['view_count']);
		$data['room_recommented_view'] = count($data['recommented']) ;

		$data['host_experiences'] = HostExperiences::approved()->listed()->where('is_featured','Yes')->get();
        return $data;
    }
    // update login status
    public function updateLoginStatus(){
        
        $user = User::find( Auth::user()->id);
        $user->last_login_time = date('Y-m-d H:i:s');
        $user->save();
        return array(
            'status' => 'success',
            'updated_time' => $user->last_login_time
        );
    }
    //contact us
    public function contact()
    {
        return view('home.contact');
    }

    //Help
    public function help(Request $request){

		return view('home.help');
	}

    
}
