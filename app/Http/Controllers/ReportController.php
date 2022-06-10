<?php

namespace App\Http\Controllers;

use App\Models\ReportReason;
use Illuminate\Http\Request;

use Toastr;
use Auth;
class ReportController extends Controller
{

    //report lists
    public function reports(string $type=null)
    {

        //check role permission
        $permission = $this->checkPermission($type);
        if(!$permission || !$permission['is_view']){ return back(); }

        $reports = ReportReason::whereNotNull('reason_details')->orderBy('id', 'desc');
        if($type){
            $reports->where('type', $type);
        }
        $reports = $reports->paginate(15);

        return view('admin.report.report-list')->with(compact('reports','permission'));
    }

    //reason lists
    public function reportReason()
    {
        //check role permission
        $permission = $this->checkPermission('add-reasons');
        if(!$permission || !$permission['is_view']){ return back(); }

        $reasons = ReportReason::whereNull('reason_details')->get();
        return view('admin.report.report-reason')->with(compact('reasons', 'permission'));
    }

    //insert return reason
    public function reasonStore(Request $request)
    {
        $reason = new ReportReason();
        $reason->reason = $request->reason;
        $reason->status = ($request->status) ? 1 : 0;
        $reason->type = (!$request->type) ? 'reason' : $request->type;
        $store = $reason->save();
        Toastr::success('Report Reason Insert Success.');
        return back();
    }

    //edit reason
    public function reasonEdit($id)
    {
        $data = ReportReason::find($id);
        echo view('admin.report.report-reason-edit')->with(compact('data'));
    }
    //update data
    public function reasonUpdate(Request $request)
    {
        $reason = ReportReason::find($request->id);
        $reason->reason = $request->reason;
        $reason->status = ($request->status) ? 1 : 0;
        $reason->type = ($request->type) ? $request->type : null;
        $store = $reason->save();
        Toastr::success('Report Reason update Success.');
        return back();

    }

    //delate reason
    public function reasonDelete($id)
    {
        $reason = ReportReason::where('id', $id)->delete();

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
    public function reportForm(Request $request){
        
        $data['reportReasons'] = ReportReason::where('type', $request->type)->where('status', 1)->get();
        return view('users.report.report')->with($data);
    }     

    //report submit
    public function sellerReport(Request $request){
        $request->validate([
            'reason' => 'required',
            'reason_details' => 'required',
        ]);
        $user_id = Auth::id();

        $report = new ReportReason();
        $report->reason = $request->reason;
        $report->reason_details = $request->reason_details;
        if($request->product_id){
            $report->product_id = ($request->product_id) ? $request->product_id : null;
            $report->type = 'product';
        }
        if($request->seller_id){
            $report->seller_id = ($request->seller_id) ? $request->seller_id : null;
            $report->type = 'seller';
        }
        $report->user_id = $user_id; 
        $report->status = 1;
        $report->save();
        Toastr::success('Report send successfully.');
        return back();
    } 

}
