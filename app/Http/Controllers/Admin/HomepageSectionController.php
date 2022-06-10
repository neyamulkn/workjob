<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\HomepageSection;
use App\Models\Product;
use App\Models\Package;
use App\Traits\CreateSlug;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class HomepageSectionController extends Controller
{
    use CreateSlug;
    public function index()
    {
        //check role permission
        $data['permission'] = $this->checkPermission('homepage');
        if(!$data['permission'] || !$data['permission']['is_view']){ return back(); }

        $data['categories'] = Category::where('parent_id', null)->orderBy('name', 'asc')->get();
        $data['banners'] = Banner::orderBy('position', 'asc')->where('status', 1)->get();
        $data['packages'] = Package::orderBy('position', 'asc')->where('status', 1)->get();
        $data['homepageSections'] = HomepageSection::orderBy('position', 'asc')->get();
        return view('admin.homepage.index')->with($data);
    }

    public function store(Request $request)
    {
 
        $section = new HomepageSection();
        $section->title = $request->title;
        $section->slug = $this->createSlug('homepage_sections', $request->title);
        $section->section_type = $request->section_type;
        $section->page_name = 'homepage';
        $section->layout_width = ($request->layout_width == 'full') ? 1 : null;
        $section->background_color = $request->background_color;
        $section->text_color = $request->text_color;
        $section->section_number = ($request->section_number) ? $request->section_number : 1;
        $section->item_number = ($request->item_number) ? $request->item_number : 7;
        $section->product_id =  ($request->section_type == 'section' ?  implode(',', $request->product_id) : $request->product_id);
        $section->section_manage = 0;
        $section->notes = ($request->notes) ? $request->notes : null;
        $section->status = ($request->status ? 1 : 0);
        if ($request->hasFile('thumb_image')) {
            $image = $request->file('thumb_image');
            $new_image_name = $this->uniqueImagePath('homepage_sections', 'thumb_image', $image->getClientOriginalName());
            $image->move(public_path('upload/images/homepage'), $new_image_name);
            $section->thumb_image = $new_image_name;
        }
        $section->image_position = $request->image_position;
        $store = $section->save();
        if($store){
            Toastr::success('Homepage section added successfully.');
        }else{
            Toastr::error('Homepage section cann\'t added.');
        }

        return back();
    }

    public function edit($id)
    {

        $data['categories'] = Category::where('parent_id', null)->orderBy('name', 'asc')->get();
        $data['banners'] = Banner::orderBy('position', 'asc')->where('status', 1)->get();
        $data['packages'] = Package::orderBy('position', 'asc')->where('status', 1)->get();
        $data['section'] = HomepageSection::where('id', $id)->first();
        if($data['section']->section_type == 'section') {
            $data['products'] = Product::whereIn('id', explode(',', $data['section']->product_id))->get();
        }
        return view('admin.homepage.edit')->with($data);

    }


    public function update(Request $request)
    {

        $section = HomepageSection::find($request->id);
        $section->title = $request->title;
        $section->layout_width = ($request->layout_width == 'full') ? 1 : null;
        $section->background_color = $request->background_color;
        $section->section_number = ($request->section_number) ? $request->section_number : 1;
        $section->item_number = ($request->item_number) ? $request->item_number : 7;
        $section->text_color = $request->text_color;
        $section->notes = ($request->notes) ? $request->notes : null;
        if($request->section_type) {
            $section->section_type = ($request->special_item) ? $request->special_item : $request->section_type;
            $section->section_manage = ($request->section_type == 'special-item') ? 1 : 0;
            $section->product_id = ($request->section_type == 'section' ? implode(',', $request->product_id) : $request->product_id);
        }
        $section->status = ($request->status ? 1 : 0);
        if ($request->hasFile('thumb_image')) {
            //delete image from folder
            $image_path = public_path('upload/images/homepage/'. $section->thumb_image);
            if(file_exists($image_path) && $section->thumb_image){
                unlink($image_path);
            }
            $image = $request->file('thumb_image');
            $new_image_name = $this->uniqueImagePath('homepage_sections', 'thumb_image', $image->getClientOriginalName());
            $image->move(public_path('upload/images/homepage'), $new_image_name);
            $section->thumb_image = $new_image_name;
        }
        $section->image_position = $request->image_position;
        $store = $section->save();
        if($store){
            Toastr::success('Homepage section update successfully.');
        }else{
            Toastr::error('Homepage section update failed.');
        }

        return back();
    }


    public function delete($id)
    {
        $section = HomepageSection::find($id);

        if($section){
            $section->delete();
            $output = [
                'status' => true,
                'msg' => 'Home section deleted successfully.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Home section cannot deleted.'
            ];
        }
        return response()->json($output);
    }

    public function sectionImageDelete($id)
    {
        $section = HomepageSection::find($id);

        if($section){
            $image_path = public_path('upload/images/homepage/'. $section->thumb_image);
            if(file_exists($image_path)){
                unlink($image_path);
            }
            $section->thumb_image = null;
            $section->save();
            $output = [
                'status' => true,
                'msg' => 'Thumb image deleted successful.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Thumb image delete failed.'
            ];
        }
        return response()->json($output);
    }
//
//    public function getAllProducts (Request $request){
//        $output = '';
//        $products = Product::where('category_id', $request->id)->where('status', 'active')->get();
//        if(count($products)>0){
//            foreach ($products as $source) {
//                $output .= ' <option value="'.$source->id.'">'.$source->title.'</option>';
//            }
//        }
//        echo $output;
//    }

    public function getSingleProduct (Request $request){
        $output = '';
        $products = Product::where('id', $request->id)->where('status', 'active')->get();
        if(count($products)>0){
            foreach ($products as $source) {
                $output .= ' <option selected value="'.$source->id.'">'.$source->title.'</option>';
            }
        }
        echo $output;
    }

    public function HomepageSectionSorting (Request $request){
        for($i=0; $i<count($request->sectionIds); $i++)
        {
            HomepageSection::where('id', str_replace('item', '', $request->sectionIds[$i]))->update(['position' => $i]);
        }
        echo 'Section Order has been updated';
    }
}
