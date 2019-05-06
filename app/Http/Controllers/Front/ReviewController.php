<?php
namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use App\Http\Requests\Reviews\StoreReviewRequest;
use App\Models\Front\Reservation;
use App\Models\Front\Reviews;
use App\Models\Front\User;
use Auth;
use Illuminate\Http\Request;
use App\Http\Start\Helpers;
use Log;

/**
 * Class ReviewController
 *
 * @package App\Http\Controllers
 */
class ReviewController extends Controller
{
	protected $review;
	protected $helper;

	/**
	 * ReviewController constructor.
	 *
	 * @param \App\Models\Reviews     $review
	 * @param \App\Http\Start\Helpers $helper
	 */
	public function __construct(Reviews $review, Helpers $helper) {
		$this->review = $review;
		$this->helper = $helper;
	}

	/**
	 * Store review
	 *
	 * @param \App\Models\User                              $user
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(Request $request, User $user) {

		//create record with validated fields;
		$this->review->create($request->toArray());
        return array(
            'status' => 'success',
            'message' => 'Thanks for submitting your review!'
        );
		//Return success notification
		$this->helper->flash_message('success', 'Thanks for submitting your review!'); // Call flash message function

		//redirect to previous page;
		// return redirect()->back();
	}

	/**
	 * Load Reviews for both Guest and Host with Previous reviews
	 *
	 * @return view User Reviews file
	 */
	public function reviews()
	{
		$data['reviews_about_you'] = Reviews::whereStatus('Active')->where('user_to', Auth::user()->id)->orderBy('id', 'desc')->get();
		$data['reviews_by_you'] = Reviews::whereStatus('Active')->where('user_from', Auth::user()->id)->orderBy('id', 'desc')->get();

		$data['reviews_to_write'] = Reservation::with(['reviews'])->whereRaw('DATEDIFF(now(),checkout) <= 14')->whereRaw('DATEDIFF(now(),checkout) >= 1')->where(['status'=>'Accepted'])->where(function($query) {
			return $query->where('user_id', Auth::user()->id)->orWhere('host_id', Auth::user()->id);
		})->get();

		$data['expired_reviews'] = Reservation::with(['reviews'])->whereRaw('DATEDIFF(now(),checkout) > 14')->where(function($query) {
			return $query->where('user_id', Auth::user()->id)->orWhere('host_id', Auth::user()->id);
		})->get();

		$data['reviews_to_write_count'] = 0;

		for($i=0; $i<$data['reviews_to_write']->count(); $i++) {
			if($data['reviews_to_write'][$i]->review_days > 0 && $data['reviews_to_write'][$i]->reviews->count() < 2) {
				if($data['reviews_to_write'][$i]->reviews->count() == 0) {
					$data['reviews_to_write_count'] += 1;
				}
				for($j=0; $j<$data['reviews_to_write'][$i]->reviews->count(); $j++) {
					if(@$data['reviews_to_write'][$i]->reviews[$j]->user_from != Auth::user()->id) {
						$data['reviews_to_write_count'] += 1;
					}
				}
			}
		}

		$data['expired_reviews_count'] = 0;

		for($i=0; $i<$data['expired_reviews']->count(); $i++) {
			if($data['expired_reviews'][$i]->review_days <= 0 && $data['expired_reviews'][$i]->reviews->count() < 2) {
				if($data['expired_reviews'][$i]->reviews->count() == 0) {
					$data['expired_reviews_count'] += 1;
				}
				for($j=0; $j<$data['expired_reviews'][$i]->reviews->count(); $j++) {
					if(@$data['expired_reviews'][$i]->reviews->user_from != Auth::user()->id) {
						$data['expired_reviews_count'] += 1;
					}
				}
			}
		}

		return view('users.reviews', $data);
	}

	/**
	 * Edit Reviews for both Guest and Host
	 *
	 * @param \Illuminate\Http\Request              $request
	 * @param \App\Http\Controllers\EmailController $email_controller
	 *
	 * @return json success and review_id
	 * @throws \Symfony\Component\HttpKernel\Exception\HttpException
	 * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
	 */
	public function reviews_edit(Request $request, EmailController $email_controller)
	{
		$data['result'] = $reservation_details = Reservation::find($request->id);
		//if check reservation details
		if(empty($reservation_details) ) {
			abort('404');
		}
		else {
			if(Auth::user()->id == $reservation_details->user_id) {
				$reviews_check = Reviews::whereStatus('Active')->where(['reservation_id'=>$request->id, 'review_by'=>'guest'])->get();
				$data['review_id'] = $reviews_check->count() ? $reviews_check[0]->id : '';
			}
			else {
				$reviews_check = Reviews::whereStatus('Active')->where(['reservation_id'=>$request->id, 'review_by'=>'host'])->get();
				$data['review_id'] = $reviews_check->count() ? $reviews_check[0]->id : '';
			}
			if( $request->data ) {
				$data  = $request;
				$data  = json_decode($data['data']);

				if($data->review_id == '') {
					$reviews = new Reviews;
				}
				else {
					$reviews = Reviews::find( $data->review_id );
				}

				$reviews->reservation_id = $reservation_details->id;
				$reviews->room_id = $reservation_details->room_id;

				if($reservation_details->user_id == Auth::user()->id) {
					$reviews->user_from = $reservation_details->user_id;
					$reviews->user_to = $reservation_details->host_id;
					$reviews->review_by = 'guest';
				}
				else if($reservation_details->host_id == Auth::user()->id) {
					$reviews->user_from = $reservation_details->host_id;
					$reviews->user_to = $reservation_details->user_id;
					$reviews->review_by = 'host';
				}

				foreach($data as $key=>$value) {
					if($key != 'section' && $key != 'review_id') {
						$reviews->$key = $value;
					}
				}
				$reviews->save();

				$check = Reviews::whereStatus('Active')->whereReservationId($request->id)->get();

				if($check->count() == 1) {
					if($data->section == 'guest' || $data->section == 'host_details'){
						$type = ($check[0]->review_by == 'guest') ? 'host' : 'guest';
						$email_controller->wrote_review($check[0]->id, $type);
					}
				}
				else if( $data->section == 'guest' || $data->section == 'host_details'){
					$type = ($check[1]->review_by == 'guest') ? 'host' : 'guest';
					$email_controller->read_review($check[0]->id, 1);
					$email_controller->read_review($check[1]->id, 2);
				}

				return json_encode(['success'=>true, 'review_id'=>$reviews->id]);
			}

			if($reservation_details->user_id == Auth::user()->id) {
				return view( 'users.reviews_edit_guest', $data );
			}

			if( $reservation_details->host_id == Auth::user()->id) {
				return view( 'users.reviews_edit_host', $data );
			}

			abort( '404' );
		}
	}


	/**
	 * Edit Reviews for both Guest and Host
	 * @deprecated
	 * @param \Illuminate\Http\Request              $request Input values
	 * @param \App\Http\Controllers\EmailController $email_controller
	 * @return json success and review_id
	 * @throws \Symfony\Component\HttpKernel\Exception\HttpException
	 * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
	 */
	public function host_experience_reviews_edit(Request $request, EmailController $email_controller)
	{


		$data['result'] = $reservation_details = Reservation::find($request->id);
		//if check reservation details
		if( empty($reservation_details) ) {
			abort('404');
		}
		else {
			if(Auth::user()->id == $reservation_details->user_id) {
				$reviews_check = Reviews::where(['reservation_id'=>$request->id, 'review_by'=>'guest'])->get();
				$data['review_id'] = $reviews_check->count() ? $reviews_check[0]->id : '';
			}
			else {
				$reviews_check = Reviews::where(['reservation_id'=>$request->id, 'review_by'=>'host'])->get();
				$data['review_id'] = $reviews_check->count() ? $reviews_check[0]->id : '';
			}

			if( $request->data ) {

				$data  = $request;
				$data  = json_decode($data['data']);
				if($data->review_id == '') {
					$reviews = new Reviews;
				}
				else {
					$reviews = Reviews::find( $data->review_id );
				}

				$reviews->reservation_id = $reservation_details->id;
				$reviews->room_id = $reservation_details->room_id;
				$reviews->list_type = $reservation_details->list_type;

				if($reservation_details->user_id == Auth::user()->id) {
					$reviews->user_from = $reservation_details->user_id;
					$reviews->user_to = $reservation_details->host_id;
					$reviews->review_by = 'guest';
					$reviews->comments = $data->improve_comments;
					$reviews->rating = $data->rating;
				}
				else if($reservation_details->host_id == Auth::user()->id) {
					$reviews->user_from = $reservation_details->host_id;
					$reviews->user_to = $reservation_details->user_id;
					$reviews->review_by = 'host';
					$reviews->comments = $data->private_feedback;
					$reviews->rating = $data->cleanliness;
				}




				$reviews->save();

				$check = Reviews::whereReservationId($request->id)->get();

				if($check->count() == 1) {
					if($data->section == 'guest' || $data->section == 'host_details'){
						$type = ($check[0]->review_by == 'guest') ? 'host' : 'guest';
						$email_controller->wrote_review($check[0]->id, $type);
					}
				}
				else {
					$email_controller->read_review($check[0]->id, 1);
					if($data->section == 'guest' || $data->section == 'host_details'){
						$type = ($check[1]->review_by == 'guest') ? 'host' : 'guest';

						$email_controller->read_review($check[0]->id, 1);
						$email_controller->read_review($check[1]->id, 2);
					}
				}

				return json_encode(['success'=>true, 'review_id'=>$reviews->id]);
			}

			if($reservation_details->user_id == Auth::user()->id) {
				return view( 'users.exp_reviews_edit_guest', $data );
			}

			if( $reservation_details->host_id == Auth::user()->id) {
				return view( 'users.exp_reviews_edit_host', $data );
			}
			abort( '404' );
		}
	}

}
