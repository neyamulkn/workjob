<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Package;
use App\Models\PackageValue;
use App\Traits\CreateSlug;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PackageController extends Controller
{
    use CreateSlug;

    public function package_create()
    {
        $data['permission'] = $this->checkPermission('all-package');
        if(!$data['permission'] || !$data['permission']['is_view']){ return back(); }
        
        $data['get_data'] = Package::orderBy('id', 'desc')->get();
        $data['get_category'] = Category::where('parent_id', '=' , null)->orderBy('name', 'asc')->get();
        
        return view('admin.package.package')->with($data);
    }

    public function package_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $data = new Package();
        $data->name = $request->name;
        $data->slug = $this->createSlug('packages', $request->name);
        $data->ribbon_position = ($request->ribbon_position ? $request->ribbon_position : 'right');
        $data->background_color = ($request->background_color ? $request->background_color : null);
        $data->text_color = ($request->text_color ? $request->text_color : null);
        $data->border_color = ($request->border_color ? $request->border_color : null);
        $data->details = ($request->details ? $request->details : null);
        $data->status = ($request->status ? 1 : 0);
        if ($request->hasFile('ribbon')) {
            $image = $request->file('ribbon');
            $new_image_name = $this->uniqueImagePath('packages', 'ribbon', $image->getClientOriginalName());
            $image->move(public_path('upload/images/package'), $new_image_name);
            $data->ribbon = $new_image_name;
        }

        if ($request->hasFile('promote_demo')) {
            $image = $request->file('promote_demo');
            $new_image_name = $this->uniqueImagePath('packages', 'promote_demo', $image->getClientOriginalName());
            $image->move(public_path('upload/images/package'), $new_image_name);
            $data->promote_demo = $new_image_name;
        }
        $store = $data->save();
        if($store){
            Toastr::success('Package Create Successfully.');
        }else{
            Toastr::error('Package Cannot Create.!');
        }
        Session::put('autoSelectId', $request->category_id);
        return back();
    }



    public function package_edit($id)
    {
        $data['data'] = Package::find($id);
        echo view('admin.package.edit.package')->with($data);
    }


    public function package_update(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $data = Package::find($request->id);
        $data->name = $request->name;
        $data->ribbon_position = ($request->ribbon_position ? $request->ribbon_position : 'right');
        $data->background_color = ($request->background_color ? $request->background_color : null);
        $data->text_color = ($request->text_color ? $request->text_color : null);
        $data->border_color = ($request->border_color ? $request->border_color : null);
        $data->details = ($request->details ? $request->details : null);

        if ($request->hasFile('ribbon')) {
            //delete previous ribbon
            $get_ribbon = public_path('upload/images/package/'.$data->ribbon);
            if($data->ribbon && file_exists($get_ribbon) ){
                unlink($get_ribbon);
            }
            $image = $request->file('ribbon');
            $new_image_name = $this->uniqueImagePath('packages', 'ribbon', $image->getClientOriginalName());
            $image->move(public_path('upload/images/package'), $new_image_name);
            $data->ribbon = $new_image_name;
        }if ($request->hasFile('promote_demo')) {
            //delete previous promote demo
            $promote_demo = public_path('upload/images/package/'.$data->promote_demo);
            if($data->promote_demo && file_exists($promote_demo) ){
                unlink($promote_demo);
            }
            $image = $request->file('promote_demo');
            $new_image_name = $this->uniqueImagePath('packages', 'promote_demo', $image->getClientOriginalName());
            $image->move(public_path('upload/images/package'), $new_image_name);
            $data->promote_demo = $new_image_name;
        }
        $store = $data->save();
        if($store){
            Toastr::success('package Update Successfully.');
        }else{
            Toastr::error('package Cannot Update.!');
        }

        return back();
    }


    public function package_delete($id)
    {
        $delete = Package::where('id', $id)->delete();

        if($delete){
            //delete previous ribbon
            $get_ribbon = public_path('upload/images/package/'.$delete->ribbon);
            if($delete->ribbon && file_exists($get_ribbon) ){
                unlink($get_ribbon);
            }
            PackageValue::where('package_id', $id)->delete();
            $output = [
                'status' => true,
                'msg' => 'Package deleted successfully.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Package delete failed.'
            ];
        }
        return response()->json($output);
    }

    public function packagevalue(Request $request, $slug)
    {
        $data['permission'] = $this->checkPermission('all-package');
        if(!$data['permission'] || !$data['permission']['is_view']){ return back(); }
        
        $data['package'] = Package::where('slug', $slug)->first();
        if( $data['package']) {
            $data['get_category'] = Category::where('parent_id', '=' , null)->orderBy('name', 'asc')->get();
            
            $get_data = PackageValue::with('get_category')->where('package_id', $data['package']->id);
            if($request->ads){
                $get_data->where('ads', $request->ads);
            }
            if($request->category && $request->category != 'all'){
                $get_data->where('category_id', $request->category);
            }
            $perPage = 15;
            if($request->show){
                $perPage = $request->show;
            }
            $data['get_data'] = $get_data->get();
        }else{
            Toastr::error('package not found.!');
            return back();
        }
        return view('admin.package.packageValue')->with($data);
    }


    public function packagevalue_store(Request $request)
    {

        $request->validate([
            'package_id' => 'required'
        ]);
        $data = new PackageValue();
        $data->package_id = $request->package_id;
        $data->category_id = $request->category_id;
        $data->ads = $request->ads;
        $data->price = $request->price;
        $data->discount = $request->discount;
        $data->duration = $request->duration;
        $data->details = $request->details;
        $data->position = 9999;
        $data->status = ($request->status ? 1 : 0);
       
        $store = $data->save();
        if($store){
            Toastr::success('package value set successfully.');
        }else{
            Toastr::error('package value cannot create.!');
        }
        Session::put('autoSelectId', $request->package_id);
        return back();
    }



    public function packagevalue_edit($id)
    {
        $data['data'] = PackageValue::find($id);
        $data['get_category'] = Category::where('parent_id', '=' , null)->orderBy('name', 'asc')->get();
        echo view('admin.package.edit.packageValue')->with($data);
    }


    public function packagevalue_update(Request $request)
    {
        $request->validate([
            'category_id' => 'required'
        ]);
        $data = PackageValue::find($request->id);
       
        $data->category_id = $request->category_id;
        $data->ads = $request->ads;
        $data->price = $request->price;
        $data->discount = $request->discount;
        $data->duration = $request->duration;
        $data->details = $request->details;
        $data->status = ($request->status ? 1 : 0);
        $store = $data->save();
        if($store){
            Toastr::success('Package value update successfully.');
        }else{
            Toastr::error('Package value cannot update.!');
        }

        return back();
    }


    public function packagevalue_delete($id)
    {
        $delete = PackageValue::where('id', $id)->delete();

        if($delete){
            $output = [
                'status' => true,
                'msg' => 'package deleted successful.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'package delete failed.'
            ];
        }
        return response()->json($output);
    }

    public function freeAdsLimit(Request $request){
        $data = Category::find($request->category);
        $data->free_ads_limit = $request->adslimit;
        $update = $data->save();
        if($update){
            $output = [
                'status' => true,
                'msg' => 'Ads limit set successful.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Ads limit set failed.'
            ];
        }
        return response()->json($output);
    }
}
