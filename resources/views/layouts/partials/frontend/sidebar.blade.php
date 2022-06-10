<style type="text/css">.modulelist{display: none;}</style>
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                
                <?php
                $role_id = Auth::guard('admin')->user()->role_id;
               
                $modules = App\Models\Module::where('parent_id', null)->with(['rolePermission' => function ($query) use ($role_id) { $query->where('role_id', $role_id); }, 'sub_modules' => function ($query) use ($role_id){
                    if($role_id != SUPER_ADMIN){
                        $query->where('status', 1);
                    }
                	$query->where('is_hidden_sidebar', null)->with(['rolePermission' => function ($query) use ($role_id) { $query->where('role_id', '=', $role_id); }]);
                }]);
                if($role_id != SUPER_ADMIN){
                    $modules->where('status', 1);
                }
                $modules = $modules->orderBy('position', 'asc')->get()->toArray();
               
                ?>
            @foreach($modules as $index => $module) 
            @php $modulePermission = $module['role_permission']; @endphp
            @if($module['slug'] == 'dashboard')
	                @if($role_id == SUPER_ADMIN || ($modulePermission && $modulePermission['is_view'] == 1))
	                <li> <a class="waves-effect waves-dark" href="{{route('admin.dashboard')}}" aria-expanded="false"><i class="{{$module['icon']}}"></i><span class="hide-menu">{{$module['module_name']}}</span></a></li>
	                @endif
            @elseif($module['slug'] == 'post')

                @php $pendingPosts = App\Models\Product::where('status', 'pending')->count(); @endphp
               
                <li class="modulelist module{{$module['id']}}">
                	<a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="{{$module['icon']}}"></i><span class="hide-menu">{{$module['module_name']}}  <span class="badge badge-pill badge-cyan ml-auto">{{ $pendingPosts }}</span> </span></a>
                    
                    <ul aria-expanded="false" class="collapse">
                        @foreach($module['sub_modules'] as $submoduleIndex => $submodule)
                        @php $permission = $submodule['role_permission']; @endphp

                        @if($role_id == 1 || ($permission && $permission['is_view'] == 1))
                        <li><a href="{{ ($submodule['route']) ? route($submodule['route'], $submodule['slug']) : 'javascript:void(0)'}}">{{ $submodule['module_name'] }} @if($submodule['slug'] == 'pending') <span class="badge badge-pill badge-cyan ml-auto">{{ $pendingPosts }}</span> @endif</a></li>
                        <style type="text/css">.module{{$module['id']}}{display: block;}</style>
                        @endif
                        @endforeach
                    </ul>
                </li>
               @elseif($module['slug'] == 'packages')

                @php $pendingpackage = App\Models\PackagePurchase::where('payment_method', '!=', 'pending')->where('payment_status', 'pending')->count(); @endphp
                <li class="modulelist module{{$module['id']}}">
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="{{$module['icon']}}"></i><span class="hide-menu">{{$module['module_name']}}  <span class="badge badge-pill badge-cyan ml-auto">{{ $pendingpackage }}</span> </span></a>
                    
                    <ul aria-expanded="false" class="collapse">
                        @foreach($module['sub_modules'] as $submoduleIndex => $submodule)
                        @php $permission = $submodule['role_permission']; @endphp

                        @if($role_id == 1 || ($permission && $permission['is_view'] == 1))
                        <li><a href="{{ ($submodule['route']) ? route($submodule['route']) : 'javascript:void(0)'}}">{{ $submodule['module_name'] }} @if($submodule['slug'] == 'purchase-package') <span class="badge badge-pill badge-cyan ml-auto">{{ $pendingpackage }}</span> @endif</a></li>
                        <style type="text/css">.module{{$module['id']}}{display: block;}</style>
                        @endif
                        @endforeach
                    </ul>
                </li>
               
            @elseif($module['slug'] == 'blog-posts')
                @if($role_id == SUPER_ADMIN || ($modulePermission && ($modulePermission['is_add'] == 1 || $modulePermission['is_view'] == 1) ))
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="{{$module['icon']}}"></i><span class="hide-menu">{{$module['module_name']}}</span></a>
                    <ul aria-expanded="false" class="collapse">
                    	@if($role_id == SUPER_ADMIN || $modulePermission['is_add'] == 1)
                        <li><a href="{{route('admin.blog.upload')}}">Add New Blog</a></li>
                        @endif
                        @if($role_id == SUPER_ADMIN || $modulePermission['is_view'] == 1)
                        <li><a href="{{route('admin.blog.list')}}">Manage Blog</a></li>
                        @endif
                    </ul>
                </li>
                @endif
            @elseif($module['slug'] == 'staff')
                @if($role_id == SUPER_ADMIN || ($modulePermission && ($modulePermission['is_add'] == 1 || $modulePermission['is_view'] == 1) ))
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="{{$module['icon']}}"></i><span class="hide-menu">{{$module['module_name']}}</span></a>
                    <ul aria-expanded="false" class="collapse">
                        @if($role_id == SUPER_ADMIN || $modulePermission['is_add'] == 1)
                        <li><a href="{{route('staff.create')}}">Add New Staff</a></li>
                        @endif
                        @if($role_id == SUPER_ADMIN || $modulePermission['is_view'] == 1)
                        <li><a href="{{route('staff.list')}}">Manage Staff</a></li>
                        @endif
                    </ul>
                </li>
                @endif

            @elseif($module['slug'] == 'manage-pages')
                @if($role_id == SUPER_ADMIN || ($modulePermission && ($modulePermission['is_add'] == 1 || $modulePermission['is_view'] == 1) ))
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="{{$module['icon']}}"></i><span class="hide-menu">{{$module['module_name']}}</span></a>
                    <ul aria-expanded="false" class="collapse">
                        @if($role_id == SUPER_ADMIN || $modulePermission['is_add'] == 1)
                        <li><a href="{{route('page.create')}}">Add New Page</a></li>
                        @endif
                        @if($role_id == SUPER_ADMIN || $modulePermission['is_view'] == 1)
                        <li><a href="{{route('page.list')}}">Page list</a></li>
                        @endif
                    </ul>
                </li>
                @endif 
            @elseif($module['slug'] == 'account-setting')
                @if($role_id == SUPER_ADMIN || ($modulePermission && $modulePermission['is_view'] == 1 ))
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="{{$module['icon']}}"></i><span class="hide-menu">{{$module['module_name']}}</span></a>
                    <ul aria-expanded="false" class="collapse">
                        @if($role_id == SUPER_ADMIN || $modulePermission['is_view'] == 1)
                        <li><a href="{{route('admin.profileUpdate')}}">Profile Setting</a></li>
                        
                        <li><a href="{{route('admin.passwordChange')}}">Change Password</a></li>
                        @endif
                    </ul>
                </li>
                @endif
            @elseif($module['slug'] == 'reports')
                <li class="modulelist module{{$module['id']}}">
                    <a class="has-arrow waves-effect waves-dark" href="{{ ($module['route']) ? route($module['route']) : 'javascript:void(0)'}}" aria-expanded="false"><i class="{{$module['icon']}}"></i><span class="hide-menu">{{$module['module_name']}}  </span></a>
                    
                    <ul aria-expanded="false" class="collapse">
                        @foreach($module['sub_modules'] as $submoduleIndex => $submodule)
                        @php $permission = $submodule['role_permission']; @endphp

                        @if($role_id == 1 || ($permission && $permission['is_view'] == 1))
                        <li><a href="{{ ($submodule['route']) ? route($submodule['route'], $submodule['slug']) : 'javascript:void(0)'}}">{{ $submodule['module_name'] }}</a></li>
                        <style type="text/css">.module{{$module['id']}}{display: block;}</style>
                        @endif
                        @endforeach
                    </ul>
                </li>
           @elseif($module['slug'] == 'manage-users')
                @php $verifyRequest = App\User::whereNotNull('shop_name')->whereNull('verify')->count(); @endphp
                @if($role_id == SUPER_ADMIN || ($modulePermission && $modulePermission['is_view'] == 1) )
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu">Manage Users <span class="badge badge-pill badge-primary text-white ml-auto">{{ $verifyRequest }}</span></span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('customer.list')}}">All Users</a></li>
                        <li><a href="{{route('customer.list', 'active')}}">Active Users</a></li>
                        <li><a href="{{route('customer.list', 'band')}}">Banded Users</a></li>
                        <li><a href="{{route('customer.list', 'verified')}}">Verified Users</a></li>
                        <li><a href="{{route('customer.list', 'unverified')}}">Unverified Users</a></li>
                        <li><a href="{{route('userVerifyRequest')}}">Verified Request <span class="badge badge-pill badge-primary text-white ml-auto">{{ $verifyRequest }}</span></a></li>
                    </ul>
                </li>
                @endif
            @elseif($module['slug'] == 'wallet')
                <li>
                    @php $withdrawRequest = App\Models\Transaction::where('customer_id', '!=', null)->where('status', 'pending')->count(); @endphp

                    <a class="@if(count($module['sub_modules'])>0) has-arrow @endif waves-effect waves-dark" href="{{ ($module['route']) ? route($module['route']) : 'javascript:void(0)'}}" aria-expanded="false"><i class="{{$module['icon']}}"></i><span class="hide-menu">{{$module['module_name']}} <span class="badge badge-pill badge-cyan ml-auto">{{ $withdrawRequest }}</span></span></a>
                    @if(count($module['sub_modules'])>0)
                    <ul aria-expanded="false" class="collapse">
                        <li> <a href="{{route('customerWalletHistory')}}">Wallet History</a></li>
                        <li> <a href="{{route('customerWithdrawRequest')}}">Withdraw Request <span class="badge badge-pill badge-cyan ml-auto">{{$withdrawRequest}}</span></a></li>
                        @foreach($module['sub_modules'] as $submoduleIndex => $submodule)
                        @php $permission = $submodule['role_permission']; @endphp
                        <li><a href="{{ ($submodule['route']) ? route($submodule['route']) : 'javascript:void(0)'}}">{{ $submodule['module_name'] }}</a></li>
                        @endforeach
                    </ul>
                    @endif
                </li>
            @else 
                @if(count($module['sub_modules'])>0)   
                <li class="modulelist module{{$module['id']}}">
                    <a class="@if(count($module['sub_modules'])>0) has-arrow @endif waves-effect waves-dark" href="{{ ($module['route']) ? route($module['route']) : 'javascript:void(0)'}}" aria-expanded="false"><i class="{{$module['icon']}}"></i><span class="hide-menu">{{$module['module_name']}} </span></a>
                   
                    <ul aria-expanded="false" class="collapse">
                        @foreach($module['sub_modules'] as $submoduleIndex => $submodule)
                        @php $permission = $submodule['role_permission']; @endphp

                        @if($role_id == SUPER_ADMIN || ($permission && $permission['is_view'] == 1))
                        <li><a href="{{ ($submodule['route']) ? route($submodule['route']) : 'javascript:void(0)'}}">{{ $submodule['module_name'] }} </a></li>
                        <style type="text/css">.module{{$module['id']}}{display: block;}</style>
                        @endif
                        @endforeach
                    </ul>
                </li>
                @else
                @if($role_id == SUPER_ADMIN || ($modulePermission && $modulePermission['is_view'] == 1))
                <li>
                    <a class="waves-effect waves-dark" href="{{ ($module['route']) ? route($module['route']) : 'javascript:void(0)'}}" aria-expanded="false"><i class="{{$module['icon']}}"></i><span class="hide-menu">{{$module['module_name']}} </span></a></li>
                @endif
                @endif
            @endif
            @endforeach
                <li> <a class="waves-effect waves-dark" href="{{ route('adminLogout') }}"  aria-expanded="false"><i class="fa fa-power-off text-success"></i><span class="hide-menu">Log Out</span></a></li>
               
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>