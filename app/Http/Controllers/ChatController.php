<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatMessage;
use App\Models\ChatRoom;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function rooms(Request $request){
        return ChatRoom::all();
    }

    public function messages(Request $request , $roomId){
        return ChatMessage::where('chat_room_id' , $roomId)->with('user')
        ->orderBy('created_at' , 'DESC')->get();
    }

    public function new_message(Request $request , $roomId){

        $newmessage = new ChatMessage;
        $newmessage->user_id = Auth::id();
        $newmessage->chat_room_id = $roomId;
        $newmessage->message = $request->message;
        $newmessage->save();

        \broadcast(new NewChatMessage($newmessage))->toOthers();

        return $newmessage;
    }
}
