<?php

/**
 * Helpers
 *
 * @package     Makent
 * @subpackage  Start
 * @category    Helper
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Http\Start;

use App\Models\Country;
use View;
use Session;
use App\Models\Metas;
use App\Models\SubscribeList;
use Image;
use File;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Writers\LaravelExcelWriter;
use App\Http\Helper\StripeHelper;

/**
 * Class Helpers
 *
 * @package App\Http\Start
 */
class Helpers {

	/**
	 * Get current controller method name
	 *
	 * @param $route
	 */
	public function current_action( $route ) {
		$current = explode( '@', $route ); // Example $route value: App\Http\Controllers\HomeController@login
		View::share( 'current_action', $current[1] ); // Share current action to all view pages
	}


	/**
	 * Set Flash Message function
	 *
	 * @param $class
	 * @param $message
	 */
	public function flash_message( $class, $message ) {
		Session::flash( 'alert-class', 'alert-' . $class );
		Session::flash( 'message', $message );
	}


	/**
	 * @param $country
	 *
	 * @return mixed
	 */
	public static function country_phone_code( $country ) {
		$country_code       = Country::where( 'short_name', $country )->first();
		$country_phone_code = $country_code->phone_code;

		return $country_phone_code;
	}

	/**
	 * Get timezone by ip address
	 *
	 * @param $user_ip
	 *
	 * @return string
	 */
	public function getUserTimeZone( $user_ip ) {
		//get timezone from ip address
		$ip = $user_ip;

		try {
			$ip_info = file_get_contents( 'https://ip-api.com/json/' . $ip );
		} catch ( \Exception $e ) {
			$ip_info = null;
		}

		$ip_info = json_decode( $ip_info );
		//check if ip is set & if timezone is defined
		if ( $ip_info !== null && $ip_info->timezone != '' ) {
			//set timezone
			$timezone = $ip_info->timezone;

			return $timezone;
		}
		//fallback to UTC timezone
		$timezone = 'UTC';

		return $timezone;
	}

	/**
	 * @param $image
	 * @param $file_prefix
	 * @param $file_directory
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function uploadImage( $image, $file_prefix, $file_directory ) {
		if ( UPLOAD_DRIVER == 'cloudinary' ) {
			$c = $this->cloud_upload( $image );
			if ( $c['status'] != "error" ) {
				$filename = $c['message']['public_id'];
			} else {
				$this->flash_message( 'danger', $c['message'] ); // Call flash message function

				return back();
			}
		} else {
			$extension = $image->getClientOriginalExtension();
			$filename  = $image->getClientOriginalName();
			$success   = $image->move( 'images/' . $file_directory, $filename );
			$this->compress_image( 'images/' . $file_directory . '/' . $filename, 'images/' . $file_directory . '/' . $filename, 60 );

			if ( ! $success ) {
				return back()->withError( 'Could not upload Image' );
			}
		}
	}

	/**
	 * @param     $source_url
	 * @param     $destination_url
	 * @param     $quality
	 * @param int $width
	 * @param int $height
	 *
	 * @return bool
	 */
	public function compress_image( $source_url, $destination_url, $quality, $width = 225, $height = 225 ) {
		// $exif = exif_read_data($source_url);

		$info = getimagesize( $source_url );
		if ( ! $info ) {
			return false;
		}
		if ( $info['mime'] == 'image/jpeg' ) {
			$image = imagecreatefromjpeg( $source_url );
		} elseif ( $info['mime'] == 'image/gif' ) {
			$image = imagecreatefromgif( $source_url );
		} elseif ( $info['mime'] == 'image/png' ) {
			$image = imagecreatefrompng( $source_url );
		}


		// if (!empty($exif['Orientation'])) {

		//        $imageResource = imagecreatefromjpeg($source_url); // provided that the image is jpeg. Use relevant function otherwise
		//        switch ($exif['Orientation']) {
		//            case 3:
		//            $image = imagerotate($imageResource, 180, 0);
		//            break;
		//            case 6:
		//            $image = imagerotate($imageResource, -90, 0);
		//            break;
		//            case 8:
		//            $image = imagerotate($imageResource, 90, 0);
		//            break;
		//            default:
		//            $image = $imageResource;
		//        }
		//    }

		imagejpeg( $image, $destination_url, $quality );

		$this->crop_image( $source_url, $width, $height );

		return $destination_url;

	}

	/**
	 * @param string $source_url
	 * @param int    $crop_width
	 * @param int    $crop_height
	 * @param string $destination_url
	 *
	 * @return string
	 * @throws \Intervention\Image\Exception\NotWritableException
	 */
	public function crop_image( $source_url = '', $crop_width = 225, $crop_height = 225, $destination_url = '' ) {
		$image        = Image::make( $source_url );
		$image_width  = $image->width();
		$image_height = $image->height();

		if ( $image_width < $crop_width && $crop_width < $crop_height ) {
			$image = $image->fit( $crop_width, $image_height );
		}
		if ( $image_height < $crop_height && $crop_width > $crop_height ) {
			$image = $image->fit( $crop_width, $crop_height );
		}

		// if($image_width > $image_height){
		// 	$primary_crop_width = $image_height;
		// 	$primary_crop_height = $image_height;

		// 	$primary_x = round(($image_width - $image_height)/2);
		// 	$primary_y = 0;

		// }if($image_width <= $image_height){
		// 	$primary_crop_width = $image_width;
		// 	$primary_crop_height = $image_width;

		// 	$primary_x = 0;
		// 	$primary_y = $image_width < $image_height ? round(($image_height - $image_width)/2) : 0;

		// }

		// $primary_cropped_image = $image->crop($primary_crop_width, $primary_crop_height, $primary_x, $primary_y);
		$primary_cropped_image = $image;

		$croped_image = $primary_cropped_image->fit( $crop_width, $crop_height );

		if ( $destination_url == '' ) {
			$source_url_details = pathinfo( $source_url );
			$destination_url    = @$source_url_details['dirname'] . '/' . @$source_url_details['filename'] . '_' . $crop_width . 'x' . $crop_height . '.' . @$source_url_details['extension'];
		}
		$croped_image->save( $destination_url );

		return $destination_url;
	}

	/**
	 * Replace phone or email in user input strings
	 *
	 * @param $message
	 *
	 * @return null|string|string[]
	 */
	public function phone_email_remove( $message ) {
		$replacement = "[removed]";

		$dots = ".*\..*\..*";

		$email_pattern = "/[^@\s]*@[^@\s]*\.[^@\s]*/";
		$url_pattern   = "/[a-zA-Z]*[:\/\/]*[A-Za-z0-9\-_]+[\.][^\.\s]+[A-Za-z0-9\?\/%&=\?\-_]+/i";
		$phone_pattern = "/\+?[0-9][0-9()\s+]{4,20}[0-9]/";

		$find    = array( $email_pattern, $phone_pattern );
		$replace = array( $replacement, $replacement );

		$message = preg_replace( $find, $replace, $message );
		if ( $message == $dots ) {

			$message = preg_replace( $url_pattern, $replacement, $message );
		} else {
			$message = preg_replace( $find, $replace, $message );
		}


		return $message;
	}


	/**
	 * Remove urls from user input fields
	 *
	 * @param $message
	 *
	 * @return null|string|string[]
	 */
	public function url_remove( $message ) {
		$replacement = "";
		$dots        = ".*\..*\..*";

		$url_blacklist = array(
			'vrbo',
			'airbnb',
			'flipkey',
			'homeescape',
			'houfy',
			'vacationsoup',
			'vacationrentals',
			'homeaway'
		);

		$url_pattern = "/[a-zA-Z]*[:\/\/]*[A-Za-z0-9\-_]+[\.][^\.\s]+[A-Za-z0-9\?\/%&=\?\-_]+/i";

		if ( $message == $dots ) {
			$message = preg_replace( $url_pattern, $replacement, $message );
		}

		return $message;
	}



	/**
	 * @param       $filename
	 * @param       $data
	 * @param array $width
	 *
	 * @return \Maatwebsite\Excel\Writers\LaravelExcelWriter
	 */
	public static function buildExcelFile( $filename, $data, $width = array() ) {
		/** @var \Maatwebsite\Excel\Excel $excel */
		$excel = app( 'excel' );

		$excel->getDefaultStyle()
		      ->getAlignment()
		      ->setHorizontal( 'left' );
		foreach ( $data as $key => $array ) {
			foreach ( $array as $k => $v ) {
				if ( ! $v ) {
					$data[ $key ][ $k ] = '--';
				}
			}
		}

		// dd($filename, $data, $width);
		return $excel->create( $filename, function ( LaravelExcelWriter $excel ) use ( $data, $width ) {
			$excel->sheet( 'exported-data', function ( LaravelExcelWorksheet $sheet ) use ( $data, $width ) {
				$sheet->fromArray( $data )->setWidth( $width );
				$sheet->setAllBorders( 'thin' );
			} );
		} );
	}


	/**
	 * @param        $file
	 * @param string $last_src
	 * @param string $resouce_type
	 *
	 * @return mixed
	 */
	public function cloud_upload( $file, $last_src = "", $resouce_type = "image" ) {
		try {

			$options = [
				'folder' => SITE_NAME . '/',
			];
			if ( $resouce_type == "video" ) {
				\Cloudder::uploadVideo( $file, null, $options );
			} else {
				\Cloudder::upload( $file, null, $options );
			}
			$c = \Cloudder::getResult();
			// if($last_src!="") \Cloudder::destroy($last_src);
			$data['status']  = "success";
			$data['message'] = $c;
		} catch ( \Exception $e ) {
			$data['status']  = "error";
			$data['message'] = $e->getMessage();
		}

		return $data;
	}


	/**
	 * @param        $date
	 * @param string $prev_format
	 *
	 * @return false|int|string
	 */
	public function custom_strtotime( $date, $prev_format = '' ) {
	 
		if ( $prev_format == '' ) {
			if ( env('PHP_DATE_FORMAT') == "d/m/Y" || env('PHP_DATE_FORMAT') == "m-d-Y" ) {
				$seperator    = ( env('PHP_DATE_FORMAT') == "d/m/Y" ) ? "/" : "-";
				$explode_date = explode( $seperator, $date );
				if ( count( $explode_date ) == "1" ) {
					return strtotime( $date );
				} else {
					$original_date = $explode_date[2] . $seperator . $explode_date[0] . $seperator . $explode_date[1];

					return strtotime( $original_date );
				}
			} else {
				$seperator    = ( env('PHP_DATE_FORMAT') == "d/m/Y" ) ? "/" : "-";
				$explode_date = explode( $seperator, $date );
				if ( count( $explode_date ) == "1" ) {
					return strtotime( $date );
				} else {
					if($seperator == '-'){
						$original_date = $explode_date[0] . $seperator . $explode_date[1] . $seperator . $explode_date[2];	
					}
					else{
						$original_date = $explode_date[2] . $seperator . $explode_date[0] . $seperator . $explode_date[1];
					}
					
					// var_dump($original_date);exit;
					return strtotime( $original_date );
				}

				// return '11111';
				return strtotime( $date );
			}
		} else {
			$date_time = \DateTime::createFromFormat( $prev_format, $date );

			return @$date_time->format( 'U' );
		}
	}



	/**
	 * @param        $SourceFile
	 * @param        $WaterMarkText
	 * @param        $DestinationFile
	 * @param string $Ext
	 */
	public function watermarkImage( $SourceFile, $WaterMarkText, $DestinationFile, $Ext = 'png' ) {
		list( $width, $height ) = getimagesize( $SourceFile );
		$image_p = imagecreatetruecolor( $width, $height );

		if ( $Ext == "jpg" || $Ext == "jpeg" ) {
			$image = imagecreatefromjpeg( $SourceFile );
		} else if ( $Ext == "png" ) {
			$image = imagecreatefrompng( $SourceFile );
		} else if ( $Ext == "gif" ) {
			$image = imagecreatefromgif( $SourceFile );
		} else {
			$image = imagecreatefrombmp( $SourceFile );
		}


		imagecopyresampled( $image_p, $image, 0, 0, 0, 0, $width, $height, $width, $height );
		$black     = imagecolorallocate( $image_p, 0, 0, 0 );
		$font      = "fonts/arial.ttf";
		$font_size = 20;
		imagettftext( $image_p, $font_size, 20, 200, 200, $black, $font, $WaterMarkText );
		if ( $DestinationFile <> '' ) {

			if ( $Ext == "jpg" || $Ext == "jpeg" ) {
				imagejpeg( $image_p, $DestinationFile, 100 );
			} else if ( $Ext == "png" ) {
				imagepng( $image_p, $DestinationFile, 9 );
			} else if ( $Ext == "gif" ) {
				imagegif( $image_p, $DestinationFile, 100 );
			} else {
				imagejpeg( $image_p, $DestinationFile, 100 );
			}

		} else {
			if ( $Ext == "jpg" || $Ext == "jpeg" ) {
				header( 'Content-Type: image/jpeg' );

				imagejpeg( $image_p, null, 100 );
			} else if ( $Ext == "png" ) {
				header( 'Content-Type: image/png' );

				imagepng( $image_p, null, 9 );
			} else if ( $Ext == "gif" ) {
				header( 'Content-Type: image/gif' );

				imagegif( $image_p, null, 100 );
			} else {
				header( 'Content-Type: image/jpeg' );

				imagejpeg( $image_p, null, 100 );
			}
		};
		imagedestroy( $image );
		imagedestroy( $image_p );
	}

	/**
	 * Truncate string and preserve words
	 *
	 * @param     $string
	 * @param int $length
	 *
	 * @return null|string|string[]
	 */
	public static function truncate( $string, $length = 150 ) {
		//cast the length value to an integer
		$limit = abs( (int) $length );

		//Strip any html first
		$string = strip_tags( $string );

		//now we have to trim the whitespace
		$string = str_replace( array( "\n", "\t" ), ' ', $string );

		//remove nbsp using the unicode values
		$string = preg_replace( '/\xc2\xa0/', '', $string );

		//check if the last chacters end in a space (full word), if not truncate
		if ( \strlen( $string ) > $limit ) {
			$string = preg_replace( "/^(.{1,$limit})(\s.*|$)/s", '\1...', $string );
		}

		return $string;
	}

	/**
	 * Removes non alpha characters while preserving spaces and cleans up any extra white space characters
	 *
	 * @param $string
	 *
	 * @return string
	 */
	public static function sanitizeString( $string ) {
		//first let's make sure to strip all html tags
		$string = strip_tags( $string );

		//strip non alpha characters and replace with a space
		$string = self::stripNonAlphaNumericSpaces( $string );

		//cleanup extra whitespace
		$string = self::stripExcessWhitespace( $string );

		return $string;
	}

	/**
	 * Remove html tags except allowed
	 *
	 * @param $string "Allowed types:<p>,<a>,<ol>,<ul>,<li>"
	 *
	 * @return string
	 */
	public static function stripNonAllowedTags( $string ) {
		return strip_tags( $string, '<p>,<a>,<ol>,<ul>,<li>,<strong>,<span>,<em>' );
	}

	/**
	 * Remove all characters except letters, numbers, and spaces.
	 *
	 * @param string $string
	 *
	 * @return string
	 */
	public static function stripNonAlphaNumericSpaces( $string ) {
		return preg_replace( "/[^a-z0-9 ]/i", " ", $string );
	}

	/**
	 * Transform two or more spaces into just one space.
	 *
	 * @param string $string
	 *
	 * @return string
	 */
	public static function stripExcessWhitespace( $string ) {
		//trim two or more space into just one space
		preg_replace( '/  +/', ' ', $string );

		//trim beginning and ending whitespace in case they were added in the by preg_replace
		$string = trim( $string );

		return $string;
	}

	/**
	 * Transform two or more linebreaks into one
	 *
	 * @param $string
	 *
	 * @return null|string|string[]
	 */
	public static function stripExcessLineBreaks( $string ) {
		return preg_replace( '/(?:(?:\r\n|\r|\n)\s*){2}/s', "\n\n", $string );
	}

	/**
     *  coupon code available check.
     *
     *  @return bool
     */

	public function get_coupon_available(){
        $paymentSubscriptions = SubscribeList::getUserSubscriptionRooms();

	    $currentDate = date("Y-m-d");

        if(count($paymentSubscriptions) >0) {
            foreach ($paymentSubscriptions as $key => $paymentSubscription) {
                if($paymentSubscription->stripe_id != ''){
                	\Stripe\Stripe::setApiKey(config('services.stripe.secret'));
                    $subscription = \Stripe\Subscription::retrieve($paymentSubscription->stripe_id);
                    $timestamp = $subscription->current_period_end;
                    if($timestamp > strtotime($currentDate)){
                        return true;
                        exit;
                    }
                }else {
                    $subscription = \Braintree_Subscription::find($paymentSubscription->braintree_id);
                    $timestamp= strtotime($subscription->billingPeriodEndDate->format('Y-m-d'));
                    if($timestamp > strtotime($currentDate)){
                        return true;
                        exit;
                    }
                }

            }
            return false;
        }else {
            return false;
        }
    }

}
