<?php

namespace App\Http\Controllers;

use App\Models\RejectReason;
use Illuminate\Http\Request;
use Toastr;
use Auth;
class RejectReasonController extends Controller
{

    //reason lists
    public function rejectReason()
    {
        $reasons = RejectReason::where('type','reason')->get();
        return view('admin.product.reject-reason')->with(compact('reasons'));
    }

    //insert return reason
    public function rejectReasonStore(Request $request)
    {
        $reason = new RejectReason();
        $reason->reason = $request->reason;
        $reason->status = 1;
        $reason->reason_for = ($request->reason_for) ? $request->type : 'product';
        $reason->type = ($request->type) ? $request->type : 'reason';
        $store = $reason->save();
        Toastr::success('Reject Reason Insert Success.');
        return back();
    }

    //edit reason
    public function rejectReasonEdit($id)
    {
        $data = RejectReason::find($id);
        echo view('admin.product.reject-reason-edit')->with(compact('data'));
    }
    //update data
    public function rejectReasonUpdate(Request $request)
    {
        $reason = RejectReason::find($request->id);
        $reason->reason = $request->reason;
        $reason->status = ($request->status) ? 1 : 0;
        $reason->reason_for = ($request->reason_for) ? $request->type : 'product';
        $reason->type = ($request->type) ? $request->type : 'reason';
        $store = $reason->save();
        Toastr::success('Reject Reason update Success.');
        return back();

    }

    //delate reason
    public function rejectReasonDelete($id)
    {
        $reason = RejectReason::where('id', $id)->delete();

        if($reason){
            $output = [
                'status' => true,
                'msg' => 'Reason deleted successfully.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Reason cannot deleted.'
            ];
        }
        return response()->json($output);
    }


    //report form
    public function rejectReasonForm(Request $request){
        
        $data['reportReasons'] = RejectReason::where('reason_for', $request->reason_for)->where('status', 1)->get();
        return view('users.product.reject')->with($data);
    }     

    //Reject submit
    public function productReject(Request $request){
        $rejectBy = Auth::admin('guard')->id();

        $report = new RejectReason();
        $report->reason = $request->reason;
        $report->reason_details = $request->reason_details;
        $report->product_id = ($request->product_id) ? $request->product_id : null;
        $report->rejectBy = $rejectBy; 
        $report->status = 1;
        $report->save();
        Toastr::success('Reject successfully.');
        return back();
    }
}
