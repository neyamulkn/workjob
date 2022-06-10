<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\MessageAdmin;
use App\Traits\CreateSlug;
use App\Traits\Sms;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\MessageEmail;
class MessageAdminController extends Controller
{
    use CreateSlug;
    use Sms;
    public function userConversations()
    {
         //check role permission
        $permission = $this->checkPermission('user-conversations');
        if(!$permission || !$permission['is_view']){ return back(); }

        $data['conversationUsers'] = Conversation::with(['product:id,title,slug,feature_image','last_message'])->orderBy('updated_at', 'desc')->get();
        $data['users'] = User::all();
        return view('admin.message.user_message')->with($data);

    }

    //get message by username
    public function getConversations($conversation_id){
      
        if($conversation_id){
            //Check if they connect
            $conversation = Conversation::with('product:id,title,slug,feature_image,price')->where('id', $conversation_id)->first();

            //get conversation message
            $messages = '';
            if($conversation){
                $messages = Message::where('conversion_id', $conversation->id)->orderBy('id', 'asc')->get();
            }
            
            return view('admin.message.user_conversations')->with(compact('conversation','messages'));
        }

        return false;
    }
    public function messageWrite(){
        //check role permission
        $permission = $this->checkPermission('send-message', 'is_add');
        if(!$permission){ Toastr::error(env('PERMISSION_MSG')); return back(); }

        $user_id = Auth::guard('admin')->id();
        $data['users'] = User::where('status', 'active')->get();

        return view('admin.message.message-create')->with($data);
    }
    // message list
    public function adminMessage(Request $request, string $status=null)
    {
         //check role permission
        $data['permission'] = $this->checkPermission('send-message');
        if(!$data['permission'] || !$data['permission']['is_view']){ return back(); }

        $user_id = Auth::guard('admin')->id();
        $messages = MessageAdmin::orderBy('id', 'desc');
        if($status){
            $messages->where('status', $status);
        }
        $data['messages'] = $messages->paginate(15);

        return view('admin.message.message')->with($data);
    }
    //message store/update
    public function adminMessageStore(Request $request, string $slug=null)
    {
        $request->validate([
            'subject' => 'required',
            'details' => 'required',
            'user_id' => 'required',
        ]);

        $sender_id = Auth::guard('admin')->id();
        if($slug){
            $data = MessageAdmin::where('slug', $slug)->first();
        }else{
            $data = new MessageAdmin();
        }
        
        $data->sender_id = $sender_id;
        $data->receiver_id = json_encode($request->user_id);
        $data->subject = $request->subject;
        if(!$slug){
        $data->slug = $this->createSlug('message_admins', $request->subject);}
        $data->details = $request->details;
        $data->send_via = $request->send_via;
        $data->status = $request->status;
        if ($request->hasFile('attachment')) {
            $image = $request->file('attachment');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload/messages'), $new_image_name);
            $data->attachment = $new_image_name;
        }
        $store = $data->save();
        if($store){
            if($request->status == 'send'){
            $msg = $request->details;
            foreach ($request->user_id as $user_id){
                if ($request->send_via == 'sms') {
                    $user = User::find($user_id);
                    if ($user && $user->mobile) {
                        $this->sendSms($user->mobile, $msg);
                    }
                }

                if ($request->send_via == 'email') {
                    $user = User::find($user_id);
                    if ($user && $user->email) {
                       //send message in email
                        Mail::to($user->email)->send(new MessageEmail($request->subject, $msg));
                    }
                }

                if ($request->send_via == 'database') {
                    // unconstruction
                }

            }
            Toastr::success('Message send success.');
            }
            
        }else{
            Toastr::error('Message submitted failed.');
        }
        return redirect()->route('adminMessage');
    }
    //message edit
    public function adminMessageEdit($slug){
        $user_id = Auth::guard('admin')->id();
        $message = MessageAdmin::where('slug', $slug)->first();
        if($message) {
            $users = User::where('status', 'active')->get();
            return view('admin.message.message-edit')->with(compact('message','users'));
        }
    }
    public function adminMessageDelete($id)
    {
        //check role permission
        $permission = $this->checkPermission('send-message', 'is_delete');
        if(!$permission){  
            return response()->json([
                'status' => false,
                'msg' => env("PERMISSION_MSG")
            ]); 
        }
        $user_id = Auth::guard('admin')->id();
        $message = MessageAdmin::where('id', $id)->first();
        if($message) {
            //delete image from folder
            $image_path = public_path('upload/messages/'. $message->attachment);
            if(file_exists($image_path) && $message->attachment){
                unlink($image_path);
            }
            $message->delete();
           
            $output = [
                'status' => true,
                'msg' => 'message deleted successful.'
            ];
        }else{
            $output = [
            'status' => false,
            'msg' => 'message cannot deleted.'
            ];
        }
        return response()->json($output);
    }
    //task detials
    public function adminMessageDetails($slug, $converation=null)
    {
        $user_id = Auth::guard('admin')->id();
        $taskDetails = WorkingTask::with(['workingTaskUsers.taskUser'])->where('slug', $slug)->first();
        //set relation with paginate
        $taskDetails->setRelation('taskConversations', $taskDetails->taskConversations()->with('conversationUser')->paginate(10));
        if($taskDetails){
            //when click reply conversation
            if($converation && $taskDetails->status == 'pending'){
                $taskDetails->status = 'processing';
                $taskDetails->save();
            }
            return view('backend.message.message-details')->with(compact('taskDetails'));
        }else{
            return redirect()->route('workingTask');
        }
    }

    public function adminMessageConversation(Request $request)
    {
        $task = WorkingTask::find($request->task_id);
        $from_user = Auth::guard('admin')->id();
        $taskConversation = new workingTaskConversation();
        $taskConversation->task_id = $request->task_id;
        $taskConversation->from_user = $from_user;
        $taskConversation->to_user = $task->assign_by;
        $taskConversation->message = $request->message;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload/workingTask'), $new_image_name);
            $taskConversation->image = $new_image_name;
        }
        $taskConversation->save();
        return redirect()->back();
    }
    
}
