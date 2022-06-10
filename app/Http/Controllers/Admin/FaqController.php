<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Toastr;
class FaqController extends Controller
{

    public function index()
    {

        $permission = $this->checkPermission('manage-pages');
        if(!$permission || !$permission['is_view']){ return back(); }

        $faqs = Faq::all();
        return view('admin.faq.faq')->with(compact('faqs', 'permission'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ]);

        $faq = new Faq();
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->status = ($request->status) ? 1 : null;
        $faq->save();
        Toastr::success('FAQ add succcess.');
        return back();
    }


    public function edit($id)
    {
        $faq = Faq::find($id);
        return view('admin.faq.faq-edit')->with(compact('faq'));
    }

 
    public function update(Request $request)
    {
        $faq = Faq::find($request->id);
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->status = ($request->status) ? 1 : null;
        $faq->save();
        Toastr::success('FAQ update succcess.');
        return back();
    }


    public function delete($id)
    {
        $faq = Faq::find($id);

        if($faq){
            
            $faq->delete();

            $output = [
                'status' => true,
                'msg' => 'FAQ deleted successfully.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'FAQ cannot delete.'
            ];
        }
        return response()->json($output);
    }
}
