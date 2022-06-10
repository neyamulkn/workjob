@extends('layouts.admin-master')
@section('title', 'Staff list')
@section('css')

    <link href="{{asset('assets')}}/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets')}}/node_modules/bootstrap-switch/bootstrap-switch.min.css" rel="stylesheet">
    <link href="{{asset('css')}}/pages/bootstrap-switch.css" rel="stylesheet">

    <style type="text/css">
        .dropify_image{
            position: absolute;top: -12px!important;left: 12px !important; z-index: 9; background:#fff!important;padding: 3px;
        }
        .dropify-wrapper{
            height: 100px !important;
        }
    </style>
@endsection
@section('content')
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h4 class="text-themecolor">Staff List</h4>
                </div>
                <div class="col-md-7 align-self-center text-right">
                    <div class="d-flex justify-content-end align-items-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Staff</a></li>
                            <li class="breadcrumb-item active">list</li>
                        </ol>
                        @if($permission['is_add'])
                        <button data-toggle="modal" data-target="#add" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</button>@endif
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card" style="margin-bottom: 2px;">

                        <form action="{{route('staff.list')}}" method="get">

                            <div class="form-body">
                                <div class="card-body">
                                    <div class="row">
                                        
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="text" value="{{ Request::get('name')}}" placeholder="staff name or mobile or email" name="name" class="form-control">
                                           </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <select name="role" required  style="width:100%" class="select2 form-control custom-select">
                                                   <option value="">All Role</option>
                                                   @foreach($roles as $role)
                                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                                    @endforeach
                                               </select>
                                           </div>
                                        </div>


                                        <div class="col-md-2">
                                            <div class="form-group">
                                                
                                                <select name="status" class="form-control">
                                                    <option value="all" {{ (Request::get('status') == "all") ? 'selected' : ''}}>All Status</option>
                                                    
                                                    <option value="active" {{ (Request::get('status') == 'active') ? 'selected' : ''}}>Active</option>
                                                    <option value="deactive" {{ (Request::get('status') == 'deactive') ? 'selected' : ''}}>Deactive</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-1">
                                            <div class="form-group">
                                               <button type="submit" class="form-control btn btn-success"><i style="color:#fff; font-size: 20px;" class="ti-search"></i> </button>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">

                    <div class="card ">
                        <div class="card-body">
                           
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Member Since</th>
                                            <th>Mobile</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                           
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead> 
                                    <tbody>
                                        @foreach($staffs as $index => $staff)
                                        <tr id="item{{$staff->id}}">
                                            <td>{{(($staffs->perPage() * $staffs->currentPage() - $staffs->perPage()) + ($index+1) )}}</td>
                                            <td><img alt="" src="{{asset('assets/images/users')}}/{{( $staff->photo) ? $staff->photo : 'default.png'}}" width="40"> {{$staff->name}}</td>
                                            <td>{{\Carbon\Carbon::parse($staff->created_at)->format(Config::get('siteSetting.date_format'))}}</td>
                                            <td>{{$staff->mobile}}</td>
                                            <td>{{$staff->email}}</td>
                                            <td>@if($staff->role){{$staff->role->name}}@endif</td>
                                           
                                            <td>

                                                <div class="bt-switch">
                                                    <input @if($permission['is_edit']) onchange="satusActiveDeactive('admins', '{{$staff->id}}')" @endif type="checkbox" {{($staff->status == 1) ? 'checked' : ''}} data-on-color="success" data-off-color="danger" data-on-text="Active" data-off-text="Deactive"> 
                                                </div>
                                            </td>
                                          
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="ti-settings"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                       
                                                        <!-- <a class="dropdown-item" title="View staff Profile" data-toggle="tooltip" href="{{ route('staff.profile', $staff->username) }}"><i class="ti-eye"></i> View Profile</a> -->
                                                        @if($permission['is_edit'])
                                                        <a class="dropdown-item" target="_blank" title="Secret login in the staff pannel" data-toggle="tooltip" href="{{route('admin.staffSecretLogin', encrypt($staff->id))}}"><i class="ti-lock"></i> Staff panel</a>

                                                        <button type="button" class="dropdown-item" title="Edit profile" onclick="edit({{$staff->id}})" ><i class="ti-pencil-alt"></i> Edit</button>
                                                        <button title="Password Reset" data-toggle="tooltip" onclick='PasswordReset("{{ $staff->id }}")' class="dropdown-item" ><i class="fa fa-retweet"></i> Password Reset</button>
                                                        @endif
                                                       
                                                        @if($permission['is_delete'])
                                                        <span title="Delete" data-toggle="tooltip"><button   data-target="#delete" onclick='deleteConfirmPopup("{{ route("staff.delete", $staff->id) }}")'  data-toggle="modal" class="dropdown-item" ><i class="ti-trash"></i> Delete staff</button></span>@endif

                                                        
                                                       
                                                    </div>
                                                </div>                                          
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
               <div class="col-sm-6 col-md-6 col-lg-6 text-center">
                   {{$staffs->appends(request()->query())->links()}}
                  </div>
                <div class="col-sm-6 col-md-6 col-lg-6 text-right">Showing {{ $staffs->firstItem() }} to {{ $staffs->lastItem() }} of total {{$staffs->total()}} entries ({{$staffs->lastPage()}} Pages)</div>
            </div>
            <!-- ============================================================== -->
            <!-- End PAge Content -->
            <!-- ============================================================== -->

        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <!-- update Modal -->
    @if($permission['is_add'])
    <div class="modal fade" id="add" role="dialog"  tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add new staff</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body form-row">
                    <div class="card-body">
                        <form action="{{route('staff.store')}}" enctype="multipart/form-data" method="POST">
                            {{csrf_field()}}
                            <div class="form-body">
                                <!--/row-->
                                <div class="row justify-content-md-center">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Staff Name</label>
                                            <input  name="name" id="name" value="{{old('name')}}" required="" type="text" placeholder="Enter name" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mobile">Mobile</label>
                                            <input placeholder="Enter mobile" name="mobile" id="mobile" value="{{old('mobile')}}" required="" type="text" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input  name="email" id="email" value="{{old('email')}}" required="" type="email" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="gender" class="control-label">Gender</label>
                                            <select name="gender" required id="gender" class="form-control">
                                                <option value="">Select</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="birthday" class="control-label">Birthday</label>
                                            <input type="date" class="form-control" id="birthday" placeholder="birthday" name="birthday">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group"> 
                                            <label class="dropify_image">Image</label>
                                            <input  type="file" class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpg jpeg png gif"  data-max-file-size="5M"  name="photo" id="input-file-events">
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
                                                <option value="{{$role->id}}">{{$role->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input  name="password" id="password" value="{{old('password')}}" required="" type="password" class="form-control">
                                        </div>
                                    </div>
                                
                                
                                    <div class="col-md-12">
                                        <div class="modal-footer">
                                            <button type="submit" name="submit" value="add" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                                            <button type="button" data-dismiss="modal" class="btn btn-inverse">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
      </div>
    @endif
    @if($permission['is_edit'])
    <!-- update Modal -->
    <div class="modal fade" id="edit" role="dialog"  tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <form action="{{route('staff.update')}}" enctype="multipart/form-data" method="post">
            {{ csrf_field() }}
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update staff</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body form-row" id="edit_form"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-success">Update</button>
                </div>
              </div>
            </form>
        </div>
    </div>

    <!-- reset password Modal -->
    <div class="modal fade" id="PasswordReset" role="dialog"  tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <form action="{{route('admin.resetPassword')}}" enctype="multipart/form-data" method="post">
            {{ csrf_field() }}
            <input type="hidden" id="userId" name="id">
            <input type="hidden" name="table" value="admins">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Password Reset</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body form-row">
                    <div class="col-md-12">
                        <label for="password"><span style="font-weight: bold">Enter new password</span></label>
                        <input type="text" required id="password" name="password" placeholder="Enter password" class="form-control">
                    </div> 
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-success">Password Reset</button>
                </div>
              </div>
            </form>
        </div>
    </div>
    @endif
    @if($permission['is_delete'])
    <!-- delete Modal -->
    @include('admin.modal.delete-modal')
    @endif

@endsection
@section('js')

    <!-- bt-switch -->
    <script src="{{asset('assets')}}/node_modules/bootstrap-switch/bootstrap-switch.min.js"></script>
    <script type="text/javascript">
    $(".bt-switch input[type='checkbox'], .bt-switch input[type='radio']").bootstrapSwitch();
    var radioswitch = function() {
        var bt = function() {
            $(".radio-switch").on("switch-change", function() {
                $(".radio-switch").bootstrapSwitch("toggleRadioState")
            }), $(".radio-switch").on("switch-change", function() {
                $(".radio-switch").bootstrapSwitch("toggleRadioStateAllowUncheck")
            }), $(".radio-switch").on("switch-change", function() {
                $(".radio-switch").bootstrapSwitch("toggleRadioStateAllowUncheck", !1)
            })
        };
        return {
            init: function() {
                bt()
            }
        }
    }();
    $(document).ready(function() {
        radioswitch.init()
    });
    </script>


    <script type="text/javascript">

    function edit(id){
        $('#edit').modal('show');
        $('#edit_form').html('<div class="loadingData"></div>');
        var  url = '{{route("staff.edit", ":id")}}';
        url = url.replace(':id',id);
        $.ajax({
            url:url,
            method:"get",
            success:function(data){
                if(data){
                    $("#edit_form").html(data);
                    $('.dropify').dropify();
                }
            },
            // $ID Error display id name
            @include('common.ajaxError', ['ID' => 'edit_form'])

        });
    }

    function PasswordReset(userId) {
       $('#PasswordReset').modal('show');
       $('#userId').val(userId);
    }

</script>
    <script src="{{asset('assets')}}/node_modules/dropify/dist/js/dropify.min.js"></script>
     <script>
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();

    });
    </script>

@endsection
