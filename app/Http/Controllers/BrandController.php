<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Traits\CreateSlug;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class BrandController extends Controller
{
    use CreateSlug;

    public function index()
    {
        $data['permission'] = $this->checkPermission('product-brand');
        if(!$data['permission'] || !$data['permission']['is_view']){ return back(); }

        $data['get_category'] = Category::where('parent_id', '=' , null)->orderBy('position', 'asc')->get();

        $data['get_data'] = Brand::orderBy('position', 'asc')->paginate(25);
        return view('admin.brand')->with($data);
    }
    // store brand
    public function store(Request $request)
    {

        $data['permission'] = $this->checkPermission('product-brand', 'is_add');
        if(!$permission){ Toastr::error(env('PERMISSION_MSG')); return back(); }

        $request->validate([
            'category_id' => 'required',
            'name' => 'required',
        ]);
        $data = new Brand();
        $data->category_id = $request->category_id;
        $data->name = $request->name;
        $data->slug = $this->createSlug('brands', $request->name);
        $data->status = ($request->status ? 1 : 0);

        if ($request->hasFile('phato')) {
            $image = $request->file('phato');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();

            $image_path = public_path('upload/images/brand/thumb/' . $new_image_name);
            $image_resize = Image::make($image);
            $image_resize->resize(120, 120);
            $image_resize->save($image_path);
            $data->logo = $new_image_name;
        }

        $store = $data->save();
        if($store){
            Toastr::success('Brand Create Successfully.');
        }else{
            Toastr::error('Brand Cannot Create.!');
        }

        return back();
    }

    //edit brand
    public function edit($id)
    {
        $data['permission'] = $this->checkPermission('product-brand', 'is_edit');
        if(!$permission){ return env('PERMISSION_MSG'); }

        $data['get_category'] = Category::where('parent_id', '=' , null)->orderBy('name', 'asc')->get();

        $data['data'] = Brand::find($id);
        echo view('admin.edit.brand')->with($data);
    }

    //update brand
    public function update(Request $request, Brand $brand)
    {
        $data['permission'] = $this->checkPermission('product-brand', 'is_edit');
        if(!$permission){ Toastr::error(env('PERMISSION_MSG')); return back(); }

        $request->validate([
            'category_id' => 'required',
            'name' => 'required',
        ]);
        $data = Brand::find($request->id);
        $data->category_id = $request->category_id;
        $data->name = $request->name;
        $data->status = ($request->status ? 1 : 0);

        if ($request->hasFile('phato')) {
            //delete image from folder
            $image_path = public_path('upload/images/brand/thumb/'. $data->logo);
            if(file_exists($image_path) && $data->logo){
                unlink($image_path);
//                unlink(public_path('upload/images/brand/'. $data->logo));
            }
            $image = $request->file('phato');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();

            $image_path = public_path('upload/images/brand/thumb/' . $new_image_name);
            $image_resize = Image::make($image);
            $image_resize->resize(120, 120);
            $image_resize->save($image_path);

//            $image->move(public_path('upload/images/brand'), $new_image_name);

            $data->logo = $new_image_name;
        }

        $store = $data->save();
        if($store){
            Toastr::success('Brand Update Successfully.');
        }else{
            Toastr::error('Brand Cannot Update.!');
        }

        return back();
    }


    public function delete($id)
    {
        //check role permission
        $permission = $this->checkPermission('product-brand', 'is_delete');
        if(!$permission){  
            return response()->json([
                'status' => false,
                'msg' => env("PERMISSION_MSG")
            ]); 
        }
        $delete = Brand::where('id', $id)->first();

        if($delete){
            $image_path = public_path('upload/images/brand/thumb/'. $delete->logo);
            if(file_exists($image_path) && $delete->logo){
                unlink($image_path);
//                unlink(public_path('upload/images/brand/'. $delete->logo));
            }
            $delete->delete();

            $output = [
                'status' => true,
                'msg' => 'Brand deleted successfully.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Brand cannot deleted.'
            ];
        }
        return response()->json($output);
    }


}
