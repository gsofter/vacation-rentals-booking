<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Front\Chats;
use App\Models\Front\ChatContact;
use App\Models\Front\User;
use App\Events\MessageSent;
// use App\Events\MessageRead;
use Twilio;
use DB;
use Pusher\Laravel\Facades\Pusher;
use Pusher\Laravel\PusherManager;

class ChatsController extends Controller
{
    //
    protected $pusher;
    public function __construct(PusherManager $pusher)
    {
        $this->pusher = $pusher;
    }

    public function getmessages(Request $request){

        $read_chats = Chats::where('user_id', $request->my_id)->where('sender_id', $request->chat_id)->where('is_read', 0);
        if($read_chats->get()->count()){
            $ids = $read_chats->pluck('id')->toArray();
            $read_chats->update(['is_read' => 1]);
        }
        $final_read_chat_id = Chats::where('sender_id', $request->my_id)->where('user_id', $request->chat_id)->where('is_read', 1)->max('id');
        
        

        $chats =  Chats::where('user_id', $request->chat_id)->where('sender_id', $request->my_id)->orWhere('user_id', $request->my_id)->where('sender_id', $request->chat_id)->get();
        foreach($chats as $key => $chat){
            if($chats[$key]->url) $chats[$key]->url = asset($chats[$key]->url) ;
            $chats[$key]->user_profile_picture = User::find($chat->user->id)->profile_picture->src;
            $chats[$key]->sender_profile_picture = User::find($chat->sender->id)->profile_picture->src;
            if($chat->id == $final_read_chat_id){
                $chats[$key]->final_read_chat = 1;
            }
            else{
                $chats[$key]->final_read_chat = 0;
            }
        }
        
        // 
        return $chats;
        
    }
    public function getContactId($hostid, $userid){
        $contact = ChatContact::where('user_id', $userid)->where('contact_user_id', $hostid)->first();
        if($contact){
            return $contact->id;
        }
        else{
            $contact = new ChatContact;
            $contact->contact_user_id = $hostid;
            $contact->user_id = $userid;
            $contact -> save();
            $contact2 = new ChatContact;
            $contact2->contact_user_id = $userid;
            $contact2->user_id = $hostid;
            $contact2 -> save();
            return $contact->id;
        }
    }
    public function updatecontactstatus(Request $request){
        $contactId = $request->contactId;
        $status = $request->status;
        $contact = ChatContact::find($contactId);
        $contact->status = $request->status;
        $contact->save();
        $contacts = ChatContact::where('user_id', $request->userId)->pluck('contact_user_id')->toArray();
        return $result =  User::select('users.*', 'chat_contacts.status', 'chat_contacts.id as contact_id')->with('profile_picture')->leftJoin('chat_contacts', 'users.id', '=', 'chat_contacts.contact_user_id')->whereIn('users.id', $contacts)->orderBy('chat_contacts.updated_at')->get();
    }
    public function getcontactlists(Request $request){
       
        $contacts = ChatContact::where('user_id', $request->userId)->pluck('contact_user_id')->toArray();
     
       
        return $result =  User::select('users.*', 'chat_contacts.status', 'chat_contacts.id as contact_id')
        ->with('profile_picture')
        ->leftJoin('chat_contacts', 'users.id', '=', 'chat_contacts.contact_user_id')
        ->whereIn('users.id', $contacts)->orderBy('chat_contacts.updated_at')->get()->unique()->all();
        dd($result);
    }
    public function readmessage(Request $request){
        // echo $request->message_id;
        $chat = Chats::find($request->message_id);
        $chat->is_read = 1;
        $chat->save();
        $ids = array();
        
        $this->pusher->trigger('chat_'.$chat->sender_id, 'message_read', ['message_id' => $request->message_id]);
      
    }
    public function fileupload(Request $request){
        $file = $request->file('files');
        $fileName = $file->getClientOriginalName();
        $destinationPath = 'uploads/chats';
        $ext = $file->getClientOriginalExtension();
        $uploadFileName = uniqid ('file_').'.'.$ext;
        $chat = new Chats;
        if(substr($file->getMimeType(), 0, 5) == 'image') {
            // this is an image
            $chat->type = 'image';
        }
        else{
            $chat->type = 'file';
        }
        $file->move($destinationPath,$uploadFileName);
        $uploadedPath = $destinationPath.'/'.$uploadFileName;
       
        $chat->user_id = $request->user_id;
        $chat->sender_id = $request->sender_id;
        $chat->message = $fileName;
        // $chat->type = 'file';
       
        $chat->url = $uploadedPath;
        $chat->save();
        $chat->user_profile_picture = User::find($chat->user->id)->profile_picture->src;
        $chat->sender_profile_picture = User::find($chat->sender->id)->profile_picture->src;
        $receiver =  User::find($chat->user->id);
        if(!$receiver->is_online()){
            $this->chatnotification($chat, $receiver);
            // email notification when user offline
        }
        event(new MessageSent($chat));
        $chats = $this->getChatHistory($request->user_id, $request->sender_id);
        return $chats;

    }
    public function getChatHistory($user_id, $sender_id){
        $final_read_chat_id = Chats::where('user_id', $user_id)->where('sender_id', $sender_id)->where('is_read', 1)->max('id');
        $chats =  Chats::where('user_id', $user_id)->where('sender_id', $sender_id)->orWhere('user_id', $sender_id)->where('sender_id', $user_id)->get();
        foreach($chats as $key => $chat){
            if($chats[$key]->url) $chats[$key]->url = asset($chats[$key]->url) ;
            $chats[$key]->user_profile_picture = User::find($chat->user->id)->profile_picture->src;
            $chats[$key]->sender_profile_picture = User::find($chat->sender->id)->profile_picture->src;
            if($chat->id == $final_read_chat_id){
                $chats[$key]->final_read_chat = 1;
            }
            else{
                $chats[$key]->final_read_chat = 0;
            }
        }
        return $chats;
    }
    public function chatnotification($chat, $receiver){
        if($receiver->users_phone_numbers()->get()->count()){
            $phone_numbers =  $receiver->users_phone_numbers()->get();
            foreach($phone_numbers as $phone_number){
                if($phone_number->status == 'Confirmed'){
                    Twilio::message($phone_number->phone_number, 'New '.($chat->type == 'text' ? 'Message' : 'Attached file').' from Vacation.Rentals:'.$chat->message);
                }
              
            }
         }
    }
    public function sendMessage(Request $request){
        
        $contact1 = ChatContact::where('user_id', $request->sender_id)->where('contact_user_id', $request->user_id)->first();
        if(!$contact1){
            $contact1 = new ChatContact;
            $contact1->user_id = $request->sender_id;
            $contact1->contact_user_id = $request->user_id;
            $contact1->save();
        }
        $contact2 = ChatContact::where('user_id', $request->user_id)->where('contact_user_id', $request->sender_id)->first();
        if(!$contact2){
            $contact2 = new ChatContact;
            $contact2->user_id = $request->user_id;
            $contact2->contact_user_id = $request->sender_id;
            $contact2->save();
        }
        // $contact = ChatContact::where('user_id', $request->user_id)->where('contact_user_id', $request->sender_id)->first();
        $chat = new Chats;
        $chat->user_id = $request->user_id;
        $chat->sender_id = $request->sender_id;
        $chat->message = $request->message;
        $chat->type='text';
        $chat->save();
        $contact1->last_message = $chat->id;
        $contact2->last_message = $chat->id;
        $contact1->save();
        $contact2->save();
        $chat->user_profile_picture = User::find($chat->user->id)->profile_picture->src;
        $chat->sender_profile_picture = User::find($chat->sender->id)->profile_picture->src;
        $receiver =  User::find($chat->user->id);
        
        if(!$receiver->is_online()){
            $this->chatnotification($chat, $receiver);
            // email notification when user offline
            // Twilio::message($user->phone, $message);
        }

        event(new MessageSent($chat));
        // echo env('BROADCAST_DRIVER');
        $chats = $this->getChatHistory($request->user_id, $request->sender_id);
        return $chats;
        return $chat;
        
        
    }


    public function isTyping(Request $request){
        $this->pusher->trigger('chat_'.$request->user_id, 'is_typing', ['typing_user' => $request->sender_id]);
    }
}
