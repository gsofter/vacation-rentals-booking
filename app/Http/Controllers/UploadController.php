<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\Front\RoomsPhotos;
use Cloudder;
use File;
class UploadController extends Controller
{
    //
    public function ImageFix(Request $request){
       $photo = RoomsPhotos::find($request->id);
       
         $path_parts = pathinfo($photo->original_name);
    //    if( $path_parts['extension'] == 'jpeg'){
    //     // return $ext = explode('.', $photo->original_name)[1] ;
    //     $file_name =   $path_parts['filename'].'.jpg';
    //     // $photo->original_name =  $path_parts['filename'].'.jpg';
    //     }
    //     else{
    //         $file_name = $path_parts['filename'].'.'.$path_parts['extension'];
    //     }
        $new_file_name = explode(' ', $path_parts['filename'])[1].'.'.$path_parts['extension'];
        // $file_url = public_path('') ."/images/rooms/$photo->room_id/$file_name";
        $photo->name = $new_file_name;
        $photo->storage = 'local';
        $photo->save();
        return $photo;
        if(File::exists($file_url)) {
            //return "FIle";
            $old_path= $file_url;
            $new_file_name = uniqid().'.'.$path_parts['extension'];
            $new_path = public_path('') ."/images/rooms/$photo->room_id/$new_file_name";
             $move = File::move($old_path, $new_path);
             if($move){
                 $photo->name = $new_file_name;
                 $photo->storage = 'local';
                 $photo->save();
                 
             }
        }
        return $photo;
    }
    public function allimageupload(Request $request){
        // Cloudder::upload($filename, $publicId, array $options, array $tags);
        // return $request->id;
        // return env('CLOUD_BASE_URL');
       
          $photo = RoomsPhotos::find($request->id);
       
          $path_parts = pathinfo($photo->original_name);
        $option1 = array(
            "folder" => "/images/rooms/$photo->room_id",
            "public_id" => $path_parts['filename'],
            "quality"=>"auto:low",
            "flags"=>"lossy",
            "resource_type"=>"image"
        );
        // $option2 = array(
        //     "folder" => env('CLOUD_BASE_URL')."/images/rooms/$photo->room_id",
        //     "public_id" => explode('.', $photo->original_name)[0].'1440x960',
        //     "quality"=>"auto:low",
        //     "flags"=>"lossy",
        //     "resource_type"=>"image",
        //     "width" => 1440,
        //     "height" => 960,
        //     "crop" => "scale",
        // );
        // $option3 = array(
        //     "folder" => env('CLOUD_BASE_URL')."/images/rooms/$photo->room_id",
        //     "public_id" => explode('.', $photo->original_name)[0].'100x100',
        //     "quality"=>"auto:low",
        //     "flags"=>"lossy",
        //     "resource_type"=>"image",
        //     "width" => 100,
        //     "height" => 100,
        //     "crop" => "scale",
        // );
        // $option4 = array(
        //     "folder" => env('CLOUD_BASE_URL')."/images/rooms/$photo->room_id",
        //     "public_id" => explode('.', $photo->original_name)[0].'200x200',
        //     "quality"=>"auto:low",
        //     "flags"=>"lossy",
        //     "resource_type"=>"image",
        //     "width" => 200,
        //     "height" => 200,
        //     "crop" => "scale",
        // );
        // $option5 = array(
        //     "folder" => env('CLOUD_BASE_URL')."/images/rooms/$photo->room_id",
        //     "public_id" => explode('.', $photo->original_name)[0].'450x250',
        //     "quality"=>"auto:low",
        //     "flags"=>"lossy",
        //     "resource_type"=>"image",
        //     "width" => 450,
        //     "height" => 250,
        //     "crop" => "scale",
        // );
        
        // $option1 = array(
        //     "folder" => env('CLOUD_BASE_URL')."/images/rooms/$photo->room_id",
        //     "public_id" => explode('.', $photo->original_name)[0],
        //     "width" => 1440,
        //     "height" => 960,
        //     "crop" => "fill",
        //     "gravity" => "auto",
        // );
        //1440 x 960
        // return $photo;
        $ext = explode('.', $photo->original_name)[1] ;

        
         
//   $path_parts['filename'];


        // $photo_details = pathinfo($this->attributes['name']); 
        if( $path_parts['extension'] == 'jpeg' || $path_parts['extension'] == 'png'){
            // return $ext = explode('.', $photo->original_name)[1] ;
            if(!File::exists(public_path('')."/images/rooms/$photo->room_id/$photo->original_name")) {
                $file_name =   $path_parts['filename'].'.jpg';
            }
            else{
                $file_name = $photo->original_name;
            }
            // $photo->original_name =  $path_parts['filename'].'.jpg';
        }
        else{
            $file_name = $photo->original_name;
        }
        return
        $resposne =  Cloudder::upload(public_path('')."/images/rooms/$photo->room_id/$file_name", null, $option1);
        return 1;
        // $resposne =  Cloudder::upload(public_path('')."/images/rooms/$photo->room_id/$file_name", null, $option2);
        // $resposne =  Cloudder::upload(public_path('')."/images/rooms/$photo->room_id/$file_name", null, $option3);
        // $resposne =  Cloudder::upload(public_path('')."/images/rooms/$photo->room_id/$file_name", null, $option4);
        // $resposne =  Cloudder::upload(public_path('')."/images/rooms/$photo->room_id/$file_name", null, $option5);
        
        // var_dump(Cloudder::getResult());exit;
        $photo->storage = 'cloud';
        $photo->save();
        return Cloudder::getResult();
        return 1;
        // return view('imageupload');
    }
}
