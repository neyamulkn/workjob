<div class="row justify-content-md-center">
    <input type="hidden" name="id" value="{{ $staff->id}}">
    <div class="col-md-12">
        <div class="form-group">
            <label for="name">Staff Name</label>
            <input  name="name" id="name" value="{{$staff->name}}" required="" type="text" placeholder="Enter name" class="form-control">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="mobile">Mobile</label>
            <input placeholder="Enter mobile" name="mobile" id="mobile" value="{{$staff->mobile }}" required="" type="text" class="form-control">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="email">Email</label>
            <input  name="email" id="email" value="{{$staff->email }}" required="" type="email" class="form-control">
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="gender" class="control-label">Gender</label>
            <select name="gender" required id="gender" class="form-control">
                <option value="">Select</option>
                <option @if($staff->gender == 'male') selected @endif value="male">Male</option>
                <option @if($staff->gender == 'female') selected @endif value="female">Female</option>
            </select>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label class="control-label">Birthday</label>
            <input type="date" value ="{{ $staff->birthday }}" class="form-control"  placeholder="birthday" name="birthday">
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group"> 
            <label class="dropify_image">Image</label>
            <input  type="file" class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpg jpeg png gif"  data-default-file="{{asset('assets/images/users/'.$staff->photo)}}"  data-max-file-size="5M"  name="photo" id="input-file-events">
        </div>
        @if ($errors->has('photo'))
            <span class="invalid-feedback" role="alert">
                {{ $errors->first('photo') }}
            </span>
        @endif
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="role" class="control-label">Role</label>
            <select name="role" required id="role" class="form-control">
                <option value="">Select Role</option>
                @foreach($roles as $role)
                <option @if($staff->role_id == $role->id) selected @endif value="{{$role->id}}">{{$role->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="password">Password</label>
            <input  name="password" id="password" value="{{old('password')}}" type="password" class="form-control">
        </div>
    </div>

</div>