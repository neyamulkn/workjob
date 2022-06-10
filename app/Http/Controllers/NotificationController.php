<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Message;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
class NotificationController extends Controller
{

    public function allNotifications(Request $request){

       
        $user_id = Auth::user()->id;
        $notifications = Notification::with('user')->where('toUser', $user_id);
        if($request->mark && $request->mark != 'all'){
            $mark = ($request->mark == 'read') ? 1 : 0;
            $notifications->where('read', $mark);
        }
        $notifications = $notifications->orderBy('created_at', 'desc')->paginate(20);

       
        return view('users.notifications.notifications')->with(compact('notifications'));
    }
    
    public function countMessageNotification()
    {
        $user_id = Auth::user()->id;
        $messages = Message::where('receiver_id', $user_id)->where('is_seen', 0)->orderBy('created_at', 'desc')->count();

        $notifications = Notification::where('toUser', $user_id)->where('read', 0)->orderBy('created_at', 'desc')->count();
        
        return response()->json(["messages" => $messages, "notifications" => $notifications]); 
    }    

    public function getNotifications(Request $request)
    {
        $user_id = Auth::user()->id;
        if($request->type == 'message-user-list'){
            $notifications = Conversation::with(['receiver','last_message'])->whereIn('sender_id', [$user_id])->orWhereIn('receiver_id',[$user_id])->orderBy('updated_at', 'desc')->take(8)->get();
             //$notifications = Message::whereRaw('id IN (select MAX(id) FROM messages GROUP BY conversion_id)')->where( function($query) use ($user_id){ $query->where('receiver_id', $user_id)->orWhere('sender_id',$user_id);  } )->orderBy('created_at', 'desc')->groupBy('conversion_id')->get();
        }
        if($request->type == 'notify-item-list'){
            $notifications = Notification::with('user')->where('toUser', $user_id)->orderBy('created_at', 'desc')->take(8)->get();
        }
       
        $notifications = view('users.notifications.'.$request->type)->with(compact('notifications'))->render();
        return response()->json(["notifications" => $notifications]); 
    }

    public function readNotify(int $id=null)
    {
        $user_id = Auth::user()->id;
        $notify = Notification::where('toUser', $user_id);
        if($id){
            $notify->where('id', $id);
        }
        
        $notify->update(['read' => 1]);
        return back();
    }

    public function markAllread()
    {
        $user_id = Auth::user()->id;
        Notification::where('toUser', $user_id)->update(['read' => 1]);
        return true;
    }
}
