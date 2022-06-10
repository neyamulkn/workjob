<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Addvertisement;
use App\Models\Page;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddvertisementController extends Controller
{

    public function index(Request $request){
        $advertisements = Addvertisement::orderBy('id', 'DESC');
        if($request->title){
            $advertisements->where('ads_name', 'LIKE', '%'. $request->title .'%');
        }
        if($request->adsType && $request->adsType != 'all'){
            $advertisements->where('adsType', $request->adsType);
        }if($request->page_name && $request->page_name != 'all'){
            $advertisements->where('page', $request->page_name);
        }
        if($request->status && $request->status != 'all'){
            $advertisements->where('status', $request->status);
        }
        $perPage = 15;
        if($request->show){
            $perPage = $request->show;
        }
        $advertisements = $advertisements->paginate($perPage);
        $pages = Page::where('status', 1)->get();
        return view('admin.addvertisement.addvertisement-list')->with(compact('advertisements', 'pages'));
    }
 

    public function store(Request $request)
    {

        $request->validate([
            'adsType' => 'required',
            'page' => 'required',
            'position' => 'required'
        ]);

        $image_name = null;
        if($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time().$image->getClientOriginalName();
            $image->move(public_path('upload/marketing'), $image_name);

        }
        $created_by = Auth::user()->id;

        $data = [
            'ads_name' => $request->ads_name,
            'adsType' => $request->adsType,
            'page' => $request->page,
            'position' => $request->position,
            'image' => $image_name,
            'redirect_url' => $request->redirect_url,
            'clickBtn' => $request->clickBtn,
            'add_code' =>  $request->add_code,
            'created_by' => $created_by,
            'status' => ($request->status) ? '1' : '0',
        ];
        $insert = Addvertisement::create($data);
        Toastr::success('Addvertisement Created Successful.');
        return back();
    }

    public function edit($id)
    {  
        $data = Addvertisement::find($id);
        $pages = Page::where('status', 1)->get();
        return view('admin.addvertisement.addvertisement-edit')->with(compact('data', 'pages'));
    }

    public function update(Request $request)
    {

        $request->validate([
            'adsType' => 'required',
            'page' => 'required',
            'position' => 'required'
        ]);
        $data = Addvertisement::find($request->id);
        
        $data->ads_name = $request->ads_name;
        $data->adsType = $request->adsType;
        $data->page = $request->page;
        $data->position = $request->position;
        $data->redirect_url = $request->redirect_url;
        $data->clickBtn = $request->clickBtn;
        $data->add_code =  $request->add_code;
        $data->updated_by = Auth::guard('admin')->id();
        $data->status = ($request->status) ? '1' : '0';
        
        if($request->hasFile('image')) {
            
            //delete from store folder
            if ($data->image){
                $image_path = public_path('upload/marketing/' . $data->image);
                if (file_exists($image_path)) {
                    unlink($image_path);
                } 
            }
           
            $image = $request->file('image');
            $image_name = time().$image->getClientOriginalName();
            $image->move(public_path('upload/marketing'), $image_name);

            $data->image = $image_name;
        }

        $data->save();

        Toastr::success('Addvertisement updated Successful.');
        return back();
    }



    public function delete($id)
    {
        $get_ads = Addvertisement::find($id);
        

        if($get_ads){
            //delete from store folder
            if ($get_ads->image){
                $image_path = public_path('upload/marketing/' . $get_ads->image);
                if (file_exists($image_path)) {
                    unlink($image_path);
                } 
            }
            $get_ads->delete();
            $output = [
                'status' => true,
                'msg' => 'Ads deleted successfully.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Ads cannot deleted.'
            ];
        }
        return response()->json($output);
    }

    public function status($status){
        $status = Addvertisement::find($status);
        if($status->status == 1){
            $status->update(['status' => 0]);
            $output = array( 'status' => 'unpublish',  'message'  => 'Advertisement Unpublished');
        }else{
            $status->update(['status' => 1]);
            $output = array( 'status' => 'publish',  'message'  => 'Advertisement Published');
        }

        return response()->json($output);
    }
}
