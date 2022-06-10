<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use App\Traits\CreateSlug;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Brian2694\Toastr\Facades\Toastr;

class SliderController extends Controller
{
    use CreateSlug;
    // Slider list
    public function index()
    {
        //check role permission
        $permission = $this->checkPermission('sliders');
        if(!$permission || !$permission['is_view']){ return back(); }

        $sliders = Slider::orderBy('position', 'asc')->get();
        return view('admin.slider.slider')->with(compact('sliders', 'permission'));
    }

    // store slider
    public function store(Request $request)
    {

        $request->validate([
            'photo' => 'required|mimes:jpeg,jpg,png,gif'
        ]);

        $data = new Slider();
        $data->title = $request->title;
        $data->title_size = $request->title_size;
        $data->title_color = $request->title_color;
        $data->title_style = $request->title_style;
        $data->type = $request->type;
        $data->subtitle = $request->subtitle;
        $data->subtitle_size = $request->subtitle_size;
        $data->subtitle_color = $request->subtitle_color;
        $data->subtitle_style = $request->subtitle_style;
        $data->btn_text = $request->btn_text;
        $data->btn_link = $request->btn_link;
        $data->text_position = $request->text_position;
        $data->bg_color = $request->bg_color;
        $data->status = ($request->status ? 1 : 0);
        
        //if feature image set
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $new_image_name = uniqid().'.'.$image->getClientOriginalExtension();
            $image_path = public_path('upload/images/slider/'.$new_image_name);
            $image_resize = Image::make($image);
            $image_resize->resize(1400, 385);
            $image_resize->save($image_path);

           
            $data->photo = $new_image_name;
        }

        $store = $data->save();

        if($store){
            Toastr::success('Slider added successfully.');
        }else{
            Toastr::error('Slider cannot added.!');
        }
       
        return back();
    }

    //Slider edit
    public function edit($id)
    {
        $data = Slider::find($id);
        echo view('admin.slider.editform')->with(compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $data = Slider::find($request->id);
        $data->title = $request->title;
        $data->title_size = $request->title_size;
        $data->title_color = $request->title_color;
        $data->title_style = $request->title_style;

        $data->subtitle = $request->subtitle;
        $data->subtitle_size = $request->subtitle_size;
        $data->subtitle_color = $request->subtitle_color;
        $data->subtitle_style = $request->subtitle_style;
        $data->btn_text = $request->btn_text;
        $data->btn_link = $request->btn_link;
        $data->text_position = $request->text_position;
        $data->bg_color = $request->bg_color;
        $data->status = ($request->status ? 1 : 0);
        $data->updated_by = Auth::id();

        //if feature image set
        if ($request->hasFile('photo')) {
            //delete image from folder
            $image_path = public_path('upload/images/slider/'.$data->photo);
            if(file_exists($image_path) && $data->photo){
                unlink($image_path);
            }

            $image = $request->file('photo');
            $new_image_name = uniqid().'.'.$image->getClientOriginalExtension();
            $image_path = public_path('upload/images/slider/'.$new_image_name);
            $image_resize = Image::make($image);
            $image_resize->resize(1400, 385);
            $image_resize->save($image_path);

            //$image->move(public_path('upload/images/slider/'), $new_image_name);

            $data->photo = $new_image_name;
        }

        $update = $data->save();
        if($update){
            Toastr::success('Slider update successfully.');
        }else{
            Toastr::error('Slider cannot update.!');
        }
        return redirect()->back();
    }

    public function delete($id)
    {
        $slider = Slider::find($id);

        if($slider){
            $image_path = public_path('upload/images/slider/'.$slider->photo);
            if(file_exists($image_path)){
                unlink($image_path);
            }
            $slider->delete();
            $output = [
                'status' => true,
                'msg' => 'Item deleted successfully.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Item cannot deleted.'
            ];
        }
        return response()->json($output);
    }

}
