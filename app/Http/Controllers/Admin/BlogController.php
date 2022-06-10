<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\CreateSlug;
use Intervention\Image\Facades\Image;
use Brian2694\Toastr\Facades\Toastr;
class BlogController extends Controller
{
    use CreateSlug;
    public function index()
    {

        //check role permission
        $data['permission'] = $this->checkPermission('blog-posts');
        if(!$data['permission'] || !$data['permission']['is_view']){ Toastr::error(env('PERMISSION_MSG')); return back(); }

        $data['blogs'] = Blog::with('author')->withCount('comments')->orderBy('id', 'desc')->paginate(15);
        return view('admin.blog.index')->with($data);
    }

    public function create(){
        //check role permission
        $data['permission'] = $this->checkPermission('blog-posts');
        if(!$data['permission'] || !$data['permission']['is_add']){ Toastr::error(env('PERMISSION_MSG')); return back(); }
        $data['categories'] = Category::where('parent_id', '=', null)->orderBy('name', 'asc')->where('status', 1)->get();
        return view('admin.blog.blog')->with($data);
    }

       //store new post
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'feature_image' => 'image|mimes:jpeg,png,jpg,gif'
        ]);

        // Insert post
        $data = new Blog();
        $data->title = $request->title;
        $data->slug = $this->createSlug('blogs', $request->title);
        $data->description = $request->description;
        $data->category_id = $request->category_id;
        $data->user_id = $request->user_id;
        $data->publish_date = now();
        $data->keywords = ($request->keywords) ? implode(',', $request->keywords) : null;
        $data->status = 'active';

        //if feature image set
        if ($request->hasFile('feature_image')) {
            $image = $request->file('feature_image');
            $new_image_name = $this->uniqueImagePath('blogs', 'image', $request->title.'.'.$image->getClientOriginalExtension());
            $image_path = public_path('upload/images/blog/thumb/' . $new_image_name);
            $image_resize = Image::make($image);
            $image_resize->resize(200, 150);
            $image_resize->save($image_path);
            $image->move(public_path('upload/images/blog'), $new_image_name);
            $data->image = $new_image_name;
        }

        $store = $data->save();

        if($store) {
            
            Toastr::success('Blog Create Successfully.');
        }else{
            Toastr::error('Blog Cannot Create.!');
        }
        return back();
    }

        //edit product
    public function edit($slug)
    {
        $data['blog'] = Blog::where('slug', $slug)->orderBy('id', 'desc')->first();
        $data['categories'] = Category::where('parent_id', '=', null)->orderBy('name', 'asc')->where('status', 1)->get();
        return view('admin.blog.blog-edit')->with($data);
    }

    //update new post
    public function update(Request $request, $blog_id)
    {
        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
        ]);

        // update blog
        $data = Blog::where('id', $blog_id)->first();
        
        if($data){
       
        $data->title = $request->title;
        $data->description = $request->description;
        $data->category_id = $request->category_id;
        $data->keywords = ($request->keywords) ? implode(',', $request->keywords) : null;
       //if feature image set
        if ($request->hasFile('feature_image')) {
            $getimage_path = public_path('upload/images/blog/'.$data->image);
            if(file_exists($getimage_path) && $data->image){
                unlink($getimage_path);
                unlink(public_path('upload/images/blog/thumb/'.$data->image));
            }
            $image = $request->file('feature_image');
            $new_image_name = $this->uniqueImagePath('blogs', 'image', $request->title.'.'.$image->getClientOriginalExtension());
            $image_path = public_path('upload/images/blog/thumb/'.$new_image_name);
            $image_resize = Image::make($image);
            $image_resize->resize(200, 150);
            $image_resize->save($image_path);
            $image->move(public_path('upload/images/blog'), $new_image_name);
            $data->image = $new_image_name;
        }

        $update = $data->save();

            if($update) {
             
                Toastr::success('Blog update success.');
            }else{
                Toastr::error('Blog update failed.!');
            }
        }else{
            Toastr::error('Blog update failed.!');
        }
        return back();
    }

    // delete blog
    public function delete($id)
    {

        //check role permission
        $permission = $this->checkPermission('blog-posts', 'is_delete');
        if(!$permission){  
            return response()->json([
                'status' => false,
                'msg' => env("PERMISSION_MSG")
            ]); 
        }
        $user_id = Auth::id();
        $blog = Blog::where('id', $id)->where('user_id', $user_id)->first();
        if($blog){
            $image_path = public_path('upload/images/blog/'. $blog->image);
            if(file_exists($image_path) && $blog->image){
                unlink($image_path);
                unlink(public_path('upload/images/blog/thumb/'. $blog->image));
            }

            $blog->delete();

            $output = [
                'status' => true,
                'msg' => 'Blog deleted successful.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Blog cannot delete.'
            ];
        }
        return response()->json($output);
    }


}
