<?php

namespace App\Http\Controllers\Staff;

use App\Admin;
use App\Models\Role;
use App\Http\Controllers\Controller;
use App\Traits\CreateSlug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Brian2694\Toastr\Facades\Toastr;
use Image;
class StaffController extends Controller
{
    use CreateSlug;
    public function staffList(Request $request, $status= ''){
        //check role permission
        $data['permission'] = $this->checkPermission('staff');
        if(!$data['permission'] || !$data['permission']['is_view']){ return back(); }

        $staffs  = Admin::with('role')->where('role_id', '!=', SUPER_ADMIN);
        if($request->status && $request->status != 'all'){
            $staffs->where('status', $request->status);
        }if($request->role){
            $staffs->where('role', $request->role);
        }if($request->name) {
            $keyword = $request->name;
            $staffs->where(function ($query) use ($keyword) {
                $query->orWhere('name', 'like', '%' . $keyword . '%');
                $query->orWhere('mobile', 'like', '%' . $keyword . '%');
                $query->orWhere('email', 'like', '%' . $keyword . '%');
            });
        }
        $data['staffs']  = $staffs->orderBy('id', 'desc')->paginate(15);
        $data['roles'] = Role::orderBy('name', 'asc')->get();
        return view('staff.staff')->with($data);
    }

    public function create(){
         //check role permission
        $data['permission'] = $this->checkPermission('staff');
        if(!$data['permission'] || !$data['permission']['is_add']){ return back(); }

        $data['roles'] = Role::orderBy('name', 'asc')->get();
        return view('staff.staff-create')->with($data);
    }

    public function store(Request $request) {

        $request->validate([
            'name' => 'required',
            'mobile' => ['required','unique:admins,mobile'],
            'email' => ['email','unique:admins,email'],
        ]);
 
        $mobile = trim($request->mobile);
        $email = trim($request->email);
        $password = trim($request['password']);

        $username = explode(' ', trim($request->name))[0];
        $staff = new Admin;
        $staff->role_id = $request->role;
        $staff->name = $request->name;
        $staff->username = $this->createSlug('admins', $username, 'username');
        $staff->email = $email;
        $staff->mobile = $mobile;
        $staff->gender = $request->gender;
        $staff->birthday = $request->birthday;
        $staff->designation = $request->designation;
        $staff->password = Hash::make($password);

        if ($request->hasFile('photo')) {
           
            $image = $request->file('photo');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();

            $image_path = public_path('assets/images/users/' . $new_image_name);
            $image_resize = Image::make($image);
            $image_resize->resize(250, 250);
            $image_resize->save($image_path);
            $staff->photo = $new_image_name;
        }
        $staff->save();
        Toastr::success('Staff create success.');
        return back();
    }

    public function edit($id)
    {
        $data['staff'] = Admin::find($id);
        $data['roles'] = Role::orderBy('name', 'asc')->get();
        echo view('staff.edit')->with($data);
    }

    public function update(Request $request) {

        $staff = Admin::find($request->id);
        $staff_id = $staff->id;

        $request->validate([
            'name' => 'required',
            'mobile' => ['required'],
            'email' => ['email'],
        ]);
 
        $mobile = trim($request->mobile);
        $email = trim($request->email);
        $password = trim($request['password']);

       
        $staff = Admin::find($request->id);
        $staff->role_id = $request->role;
        $staff->name = $request->name;
        $staff->email = $email;
        $staff->mobile = $mobile;
        $staff->gender = $request->gender;
        $staff->birthday = $request->birthday;
        $staff->designation = $request->designation;
        if($request->password){
        $staff->password = Hash::make($password);
        }
        if ($request->hasFile('photo')) {
            //delete image from folder
            $image_path = public_path('assets/images/users/'. $staff->photo);
            if(file_exists($image_path) && $staff->photo){
                unlink($image_path);
            }
            $image = $request->file('photo');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();

            $image_path = public_path('assets/images/users/' . $new_image_name);
            $image_resize = Image::make($image);
            $image_resize->resize(250, 250);
            $image_resize->save($image_path);
            $staff->photo = $new_image_name;
        }
        $staff->save();
        Toastr::success('Staff create success.');
        return back();
    }

    public function staffProfile($username){
        $data['staff']  = Admin::where('username', $username)->first();
        return view('staff.profile')->with($data);
    }

    public function staffSecretLogin($id)
    {
        $user = Admin::findOrFail(decrypt($id));
        auth()->guard('admin')->login($user, true);
        Toastr::success('Staff panel login success.');
        return redirect()->route('admin.dashboard');
    }
    public function delete($id){
        $user = Admin::find($id);
        if($user){
            $user->delete();
            $output = [
                'status' => true,
                'msg' => 'User deleted successfully.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'User cannot deleted.'
            ];
        }
        return response()->json($output);
    }


}
