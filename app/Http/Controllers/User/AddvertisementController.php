<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\Addvertisement;
use App\Models\Page;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddvertisementController extends Controller
{

    public function index(Request $request){
        $user_id = Auth::user()->id;
        $advertisements = Addvertisement::where('created_by',$user_id )->orderBy('id', 'DESC');
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
        return view('users.addvertisement.addvertisement-list')->with(compact('advertisements', 'pages'));
    }
 

    public function store(Request $request)
    {

        $request->validate([
            'ads_name' => 'required',
            'price' => 'required'
        ]);

        $image_name = null;
        if($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time().$image->getClientOriginalName();
            $image->move(public_path('upload/marketing'), $image_name);
        }
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
            
        $balance_type = ($request->balance_type == 'earning_balance') ? 'wallet_balance' : 'deposit_balance';
        if($request->price > $user->$balance_type){
            Toastr::error('Insufficient  balance.');
            return back()->with('error', 'Insufficient balance.');
        }

        $data = [
            'ads_name' => $request->ads_name,
            'adsType' => 'image',
            'days' => $request->price,
            'price' => $request->price,
            'page' => $request->page,
            'position' => $request->position,
            'image' => $image_name,
            'redirect_url' => $request->redirect_url,
            'clickBtn' => $request->clickBtn,
            'add_code' =>  $request->add_code,
            'created_by' => $user_id,
            'status' => ($request->status) ? 'active' : 'pending',
        ];
        $insert = Addvertisement::create($data);
        if($insert){
            $user->$balance_type = $user->$balance_type - $request->price;
            $user->save();
            Toastr::success('Addvertisement Created Successful.');
        }else{
            Toastr::error('Addvertisement created failed.');
        }
        
        return back();
    }

    public function edit($id)
    {  
        $data = Addvertisement::find($id);
        $pages = Page::where('status', 1)->get();
        return view('users.addvertisement.addvertisement-edit')->with(compact('data', 'pages'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'ads_name' => 'required',
            'price' => 'required'
        ]);
        $data = Addvertisement::find($request->id);
        
        $data->ads_name = $request->ads_name;
        $data->position = $request->position;
        $data->redirect_url = $request->redirect_url;
        $data->clickBtn = $request->clickBtn;
        $data->add_code =  $request->add_code;
        
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
