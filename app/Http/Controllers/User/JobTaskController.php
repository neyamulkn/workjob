<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\JobTask;
use App\Models\applicant;
use Illuminate\Http\Request;
use Auth;
class JobTaskController extends Controller
{
    

    //job task store 
    public function jobTaskStore(Request $request, $slug)
    {
        $job = applicant::where('slug', $slug)->where('status', 'active')->first();
        if($job){
            $task = new JobTask();
            $task->user_id = Auth::id();
            $task->seller_id = $job->seller_id;
            $task->job_id = $job->id;
            $task->task_date = now();
            $task->work_prove = $request->work_prove;
            $task->amount = $job->per_workers_earn;
            $task->status = 'pending';

            if ($request->hasFile('screenshot')) {
                $screenshots = [];
                foreach ($request->file('screenshot') as $image) {
                    $new_image_name = time().rand().'.'.$image->getClientOriginalExtension();
                    $image->move(public_path('upload/images/jobs'), $new_image_name);
                    $screenshots[] = $new_image_name;
                }
                $task->screenshots = json_encode($screenshots);
            }

            $task->save();
        }

        return back();
    }  

    //my job work list
    public function myWorks(Request $request, $status=null)
    {
        $myWorks = JobTask::with('job')->where('user_id', Auth::id());

        if($status){
            $myWorks->where('status', $status);
        }
        if(!$status && $request->status && $request->status != 'all'){
            $myWorks->where('status',$request->status);
        }

        $data['myWorks'] = $myWorks->orderBy('id', 'desc')->paginate(25);
        return view('users.jobs.myWorks')->with($data);
        
    }

    
}
