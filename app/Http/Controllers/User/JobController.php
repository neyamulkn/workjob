<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Country;
use App\Models\Addvertisement;
use App\Models\JobTask;
use App\Models\RejectReason;
use App\Models\Transaction;
use App\Models\Notification;
use App\Models\User;
use App\Models\Ticket;
use Toastr;
use Auth;
class JobController extends Controller
{
    public function jobs(Request $request, string $category=null){
        $data['banners'] = $data['state'] = $data['category'] = $data['filterCategories'] = $data['brands'] = [];
        $posts = Product::withCount('jobTasks')->where('status', 'active');

            if($category){
                $posts->where(function($query) use ($category){
                    $query->where('category_id', $category)->orWhere('subcategory_id', $category );
                });
            }
          
            if ($request->location) {
                $location = $request->location;
                $posts->whereJsonContains('location', "$location");
            }
           
            
            //check search keyword
            if ($request->q) {
                $posts->where('title', 'like', '%' . $request->q . '%');
            }

            //period ratting
            if ($request->period) {
                if($request->period == 'hour'){
                    $period =  Carbon::parse(now())->subHours(2);
                }else{
                    $period =  Carbon::parse(now())->subDays(3);
                }
                $posts->where('approved', '>=', $period);
            }

           
            $field = 'id'; $value = 'desc';
            if (isset($request->sortby) && $request->sortby) {
                try {
                    $sort = explode('-', $request->sortby);
                    if ($sort[0] == 'name') {
                        $field = 'title';
                    } elseif ($sort[0] == 'price') {
                        $field = 'per_workers_earn';
                    } else {
                        $field = 'id';
                    }
                    $value = ($sort[1] == 'a' || $sort[1] == 'l') ? 'asc' : 'desc';
                    $posts->orderBy($field, $value);
                }catch (\Exception $exception){}
            }
            $posts->orderBy($field, $value);

            //check price keyword
            if ($request->price_min) {
                $posts->where('per_workers_earn', '>=', $request->price_min);
            }if ($request->price_max) {
                $posts->where('per_workers_earn', '<=', $request->price_max);
            }

            //check perPage
            $perPage = 25;
            if (isset($request->perPage) && $request->perPage) {
                $perPage = $request->perPage;
            }
            $data['get_ads'] = Addvertisement::whereIn('page', ['category', 'all'])->inRandomOrder()->where('status', 1)->get();
            $data['posts'] = $posts->paginate($perPage);

            if($request->filter){
                return view('users.jobs.job-filter')->with($data);
            }else{
                 $data['get_categories'] = Category::whereNull('parent_id')->orderBy('position', 'asc')->where('status', 1)->get();
                $data['locations'] = Country::orderBy('name', 'asc')->where('status', 1)->take(15)->get();
                return view('users.jobs.jobs')->with($data);
            }
    }

    //display product details by product id/slug
    public function job_details(Request $request, $slug)
    {
        $data['post'] = Product::withCount('jobTasks')->with(['user', 'userJobTask', 'get_category', 'get_subcategory'])->where('slug', $slug)->first();
        if($data['post']) {
          
            $data['locations'] = Country::whereIn('id', json_decode($data['post']->location))->get();
            $data['post']->increment('views'); // news view count
            return view('users.jobs.job-details')->with($data);
        }else{
            return view('404');
        }
    }

    public function jobApplicants($slug)
    {
        $data['post'] = Product::where('slug', $slug)->where('user_id', Auth::id())->first();
    
        if($data['post']) {
            $data['jobApplicants'] = JobTask::where('job_id', $data['post']->id)->paginate(25);
            return view('users.jobs.job-applicants')->with($data);
        }else{
            return view('404');
        }
    }

    //get applicant Status popup
    public function jobApplicantDetails($applicant_id){
        $data['applicant'] = JobTask::find($applicant_id);
        if($data['applicant']){
            $data['post'] = Product::where('id', $data['applicant']->job_id)->where('user_id', Auth::id())->first();
            return view('users.jobs.jobWorkDetails')->with($data);
        }
        return view('404');
    }

    //applicant Status Update
    public function applicantStatusUpdate(Request $request, $id){

        $applicant = JobTask::where('id', $id)->where('seller_id', Auth::id())->first();
        if($applicant){
            if($request->status && $applicant->status != $request->status){
                $applicant->status = $request->status;
               
                if($request->status == 'accepted'){

                    //insert customer transaction
                    $transaction = new Transaction();
                    $transaction->type = 'jobTaskEarn';
                    $transaction->item_id = $applicant->id;
                    $transaction->payment_method = 'Job Task Earn';
                    $transaction->amount = $applicant->amount;
                    $transaction->transaction_details = 'Job Task Earn';
                    $transaction->notes = 'Earning from job task.';
                    $transaction->customer_id = $applicant->user_id;
                    $transaction->seller_id = Auth::id();
                    $transaction->created_by = Auth::id();
                    $transaction->status = 'paid';
                    $transaction->save();

                    //update user wallet balance
                    $user = $applicant->user;
                    $user->wallet_balance = $user->wallet_balance + $applicant->amount;
                    $user->save();

                    $notify = 'Your job task has been accepted';
                }elseif($request->status == 'reject'){
                    $notify = 'This job task has been rejected.';
                }else{
                    $notify = 'This job task has been '.$request->status;
                }
                //insert notification in database
                Notification::create([
                    'type' => 'jobTask',
                    'fromUser' => null,
                    'toUser' => $applicant->user_id,
                    'item_id' => $applicant->id,
                    'notify' => $notify,
                ]);
            }
            $applicant->reject_reason = ($request->reject_reason) ? $request->reject_reason : $applicant->reject_reason;
            $applicant->save();
            Toastr::success('Job task  status update success.');
        }
        return back();
    } 


    public function topJobPoster(){
        $data['users'] = User::withCount('jobs')->where('status', 'active')->orderBy('jobs_count', 'desc')->take(10)->get();
        $data['ticket'] = Ticket::orderBy('id', 'desc')->first();
        return view('users.jobs.topJobPoster')->with($data);
    }

}
