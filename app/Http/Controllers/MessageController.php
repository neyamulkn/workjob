<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\Product;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\User;
use App\Traits\CreateSlug;
class MessageController extends Controller
{
    use CreateSlug;

    //show all conversation user list
    public function conversationList($username,$product=null)
    {
        $sender_id = Auth::user()->id;

        $conversationUsers = Conversation::with(['product:id,title,slug,feature_image','last_message'])->whereIn('sender_id', [$sender_id])->orWhereIn('receiver_id',[$sender_id])->orderBy('updated_at', 'desc')->get();

        $receiver = User::where('username', $username)->first();
        $product = Product::where('slug', $product)->first();
        $messageWriteBox = $messages =  $conversation = $receiver_id = $product_id = null;
            if($receiver && $product){
                $receiver_id = $product->user_id;
                $product_id = $product->id;
            }
            //Check if they connect
            $conversation = Conversation::where(function ($query) use ($sender_id, $receiver_id, $product_id) {
                $query->where(function ($query) use ($sender_id, $receiver_id, $product_id) {
                    $query->where('sender_id', $sender_id)->where('receiver_id', $receiver_id)->where('product_id', $product_id);
                })->orWhere(function ($query) use ($sender_id, $receiver_id, $product_id) {
                    $query->where('sender_id', $receiver_id)->where('receiver_id', $sender_id)->where('product_id', $product_id);
                });
                })->orWhere('id', $username)->first();

            //get conversation message
            if($conversation){
                $messages = $this->helperMessage($conversation, $sender_id);
            }
            $messageWriteBox = 'show';
        
 

        return view('users.message.inbox')->with(compact('conversationUsers','conversation','messages','receiver','product', 'messageWriteBox'));
    }

    //get message by username
    public function getMessages($conversation_id){
        $sender_id = Auth::user()->id;
       
        if($conversation_id){
            //Message seen if this user receive message
            Message::where('receiver_id', $sender_id)->update(['is_seen'=> 1]);

            //Check if they connect
            $conversation = Conversation::with('product:id,title,slug,feature_image,price')->where('id', $conversation_id)->first();

            //get conversation message
            $messages = '';
            if($conversation){
                $messages = $this->helperMessage($conversation, $sender_id);
            }
            $messageWriteBox = 'show';
            return view('users.message.message')->with(compact('conversation','messages', 'messageWriteBox'));
        }

        return false;
    }

    //get realtime message
    public function realTimeMessage(Request $request){
        $sender_id = Auth::user()->id;

        $conversationUsers = Conversation::with(['receiver','last_message'])->whereIn('sender_id', [Auth::id(), $sender_id])->orWhereIn('receiver_id',[Auth::id(), $sender_id])->orderBy('updated_at', 'desc')->get();

        $conversationUsers = view('users.message.conversationList')->with(compact('conversationUsers'))->render();

        $messages = null;
       
        if($request->conversation_id){
            //Check if they connect
            $conversation = Conversation::with('product:id,title,slug,feature_image')->where('id', $request->conversation_id)->first();

            if(!$conversation){
                $product = Product::where('id', $request->conversation_id)->first();
                $receiver_id = $product->user_id;
                $product_id = $product->id;
            
                $conversation = Conversation::with('product:id,title,slug,feature_image')->where(function ($query) use ($sender_id, $receiver_id, $product_id) {
                $query->where(function ($query) use ($sender_id, $receiver_id, $product_id) {
                    $query->where('sender_id', $sender_id)->where('receiver_id', $receiver_id)->where('product_id', $product_id);
                })->orWhere(function ($query) use ($sender_id, $receiver_id, $product_id) {
                    $query->where('sender_id', $receiver_id)->where('receiver_id', $sender_id)->where('product_id', $product_id);
                });
                })->orWhere('id', $request->conversation_id)->first();
            }
            //get conversation message
            if($conversation){
                $messages = $this->helperMessage($conversation, $sender_id);
                $messages = view('users.message.realtimeMessage')->with(compact('conversation','messages'))->render();
            }
        }

        return response()->json(['conversationUsers' => $conversationUsers, 'message' => $messages]);
    }

    //insert message
    public function sendMessage(Request $request)
    {

        $sender_id = Auth::guard()->id();
        
        if($request->productOrConId){
            $product = Product::where('id', $request->productOrConId)->first();
            $product_id = $receiver_id = null;
            if($product){
                $product_id = $product->id;
                $receiver_id = $product->user_id;
            }
            $conversation = Conversation::where(function ($query) use ($sender_id, $receiver_id,$product_id) {
                    $query->where('sender_id', $sender_id)->where('receiver_id', $receiver_id)->where('product_id', $product_id);
                    })->orWhere(function ($query) use ($sender_id, $receiver_id, $product_id) {
                        $query->where('sender_id', $receiver_id)->where('receiver_id', $sender_id)->where('product_id', $product_id);
                    })->orWhere('id', $request->productOrConId)->first();

            
                if($conversation){
                    $con_id =$conversation->id;
                    $conversation->updated_at = now();
                    $conversation->deleted_date_sender = null;
                    $conversation->deleted_date_receiver = null;
                    $conversation->save();
                    $receiver_id = $conversation->receiver_id;
                }else{
                    $con_id = $this->uniqueOrderId('conversations', 'id', '5');

                    $conversation = new Conversation();
                    $conversation->id = $con_id;
                    $conversation->sender_id = $sender_id;
                    $conversation->receiver_id = $receiver_id;
                    $conversation->product_id = $product_id;
                    $conversation->save();
                    //get last insert data
                    $conversation = Conversation::where('id', $con_id)->first();
                }
                //check user block status
                if($conversation->block_user != null){
                    return false;
                }
                //insert message
                $message = new Message();
                $message->conversion_id = $con_id;
                $message->sender_id = $sender_id;
                $message->receiver_id = $receiver_id;
                $message->message = $request->message;
                $message->save();

                // retrive message
                if($conversation){
                    $messages = $this->helperMessage($conversation, $sender_id);
                }

                return view('users.message.message')->with(compact('conversation','messages'));
            
        }

        return false;
       
    }

    //get message by converstion id
    private function helperMessage($conversation, $sender_id){
        $messages = Message::where('conversion_id', $conversation->id)->orderBy('id', 'asc');
        if($conversation->deleted_date_sender != null || $conversation->deleted_date_receiver != null ){
            //get converstion delete date
            $deleted_date = ($conversation->sender_id == $sender_id) ? $conversation->deleted_date_sender : $conversation->deleted_date_receiver;
            if($deleted_date){
                $messages->whereBetween('created_at', [$deleted_date, now()]);
            }
        }
        $messages = $messages->get();

        return $messages;
    }

    //delete single message
    public function deleteMessage($id){
        $message = Message::where('id', $id)->first();

        if($message){
            if($message->sender_id == Auth::id()){
                $message->deleted_from_sender = 1;
                $message->save();
            }else{
                $message->deleted_from_receiver = 1;
                $message->save();
            }

            //if multi user msg than apply wherejsoncontains

            $output = ['status' => true];
        }else{
            $output = ['status' => false];
        }
        return response()->json($output);
    }
 
    //delete all conversation message
    public function deleteAllMessage($id){

        $sender_id = Auth::guard()->id();
        $conversation = Conversation::where('id', $id)->where(function ($query) use ($sender_id) {
            $query->where('sender_id', $sender_id)->orWhere('receiver_id', $sender_id);
            })->first();

        if($conversation){
            //delete all msg
            $messages = Message::where('conversion_id', $id)->get();
            if($messages){
                foreach($messages as $message){
                    if($message->sender_id == Auth::id()){
                        $message->deleted_from_sender = 1;
                        $message->save();
                    }else{
                        $message->deleted_from_receiver = 1;
                        $message->save();
                    }
                }
            }
            //when delete all conversation set deleted date for msg query from date
            if($conversation->sender_id == Auth::id()){
                $conversation->deleted_date_sender = now();
                $conversation->save();
            }else{
                $conversation->deleted_date_receiver = now();
                $conversation->save();
            }
        }
        return redirect()->route('user.message');
    }

    //block/unlock user
    public function blockUser($id){

        $sender_id = Auth::guard()->id();
        $conversation = Conversation::where('id', $id)->where(function ($query) use ($sender_id) {
            $query->where('sender_id', $sender_id)->orWhere('receiver_id', $sender_id);
            })->first();

        if($conversation){
            if($conversation->block_user == null){
                $conversation->block_user = $sender_id;
            }else{
                $conversation->block_user = ($conversation->block_user == $sender_id) ? null : $conversation->block_user;
            }
            $conversation->save();
        }
        return back();
    }


}
