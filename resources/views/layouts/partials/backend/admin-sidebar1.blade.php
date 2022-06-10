<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li> <a class="waves-effect waves-dark" href="{{route('admin.dashboard')}}" aria-expanded="false"><i class="fa fa-tachometer-alt"></i><span class="hide-menu">Dashboard</span></a></li>
                
               
                <li> <a class="has-arrow waves-effect waves-dark @if(Request::route('attribute_slug')) active @endif" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-sitemap"></i><span class="hide-menu">Category & Variation </span></a>
                    <ul aria-expanded="false" class="collapse @if(Request::route('attribute_slug')) in @endif">
                        <li><a href="{{route('category')}}">Main Category</a></li>
                        <li><a href="{{route('subcategory')}}">Sub Category</a></li>
                        <li><a href="{{route('subchildcategory')}}">Type Or Child Category</a></li>
                        <li><a href="{{route('productAttribute')}}">Product Attributes</a></li>
                        <li><a href="{{route('predefinedFeature')}}">Product Feature</a></li>
                        <li><a href="{{route('brand')}}">Product Brand</a></li>
                    </ul>
                </li>
                
                @php $pendingPosts = App\Models\Product::where('status', 'pending')->count(); @endphp
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-align-left"></i><span class="hide-menu">Manage Posts <span class="badge badge-pill badge-cyan ml-auto">{{ $pendingPosts }}</span> </span></a>
                    <ul aria-expanded="false" class="collapse">
                       
                        <li><a href="{{route('admin.product.list', 'pending')}}">Pending Posts <span class="badge badge-pill badge-cyan ml-auto">{{ $pendingPosts }}</span></a></li>
                        <li><a href="{{route('admin.product.list')}}">All Posts</a></li>
                        <li><a href="{{route('admin.product.list', 'promoted')}}">Promoted Posts</a></li>
                        <li><a href="{{route('admin.product.list', 'trash')}}">Trash Posts</a></li>
                        
                    </ul>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-pencil-alt"></i><span class="hide-menu">Blog Posts  </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('admin.blog.upload')}}">Add New Blog</a></li>
                        <li><a href="{{route('admin.blog.list')}}">Manage Blog</a></li>
                    </ul>
                </li>
              
                 @php $pendingpackage = App\Models\PackagePurchase::where('payment_method', '!=', 'pending')->where('payment_status', 'pending')->count(); @endphp
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-podcast"></i><span class="hide-menu">Packages <span class="badge badge-pill badge-cyan ml-auto">{{ $pendingpackage }}</span></span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('admin.packageList')}}">Purchase Package <span class="badge badge-pill badge-cyan ml-auto">{{ $pendingpackage }}</span></a></li>
                        <li><a href="{{route('adspackage')}}">All Package</a></li>
                        
                    </ul>
                </li>
                

                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-envelope"></i><span class="hide-menu">Message </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('adminMessageWrite')}}">Send Message</a></li>
                        <li><a href="{{route('userConversations')}}">User Conversations</a></li>
                    </ul>
                </li>

                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-bug"></i><span class="hide-menu">Reports & Reason</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('reportReason.list')}}">Add Reasons</a></li>
                        <li><a href="{{route('report.list', 'seller')}}">Seller report</a></li>
                        <li><a href="{{route('report.list', 'product')}}">Product report</a></li>
                        
                    </ul>
                </li>
                 @php $verifyRequest = App\User::whereNotNull('shop_name')->whereNull('verify')->count(); @endphp
                
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

                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu">Staff</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('staff.list')}}">Staff list</a></li>
                    </ul>
                </li>
               
                <li> <a class="waves-effect waves-dark" href="{{route('addvertisement.list')}}" aria-expanded="false"><i class="fa fa-bullhorn"></i><span class="hide-menu">Advertisement</span></a></li>
                <li>
                <a class=" has-arrow  waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-cogs"></i><span class="hide-menu">General Settings </span></a>
                <ul aria-expanded="false" class="collapse">
                <li><a href="{{route('generalSetting')}}">General Setting</a></li>
                <li><a href="{{route('site_settings')}}">Site settings</a></li>
                <li><a href="{{route('headerSetting')}}">Header Setting</a></li>
                <li><a href="{{route('footerSetting')}}">Footer Setting</a></li>
                <li><a href="{{route('logoSetting')}}">Logo Setting</a></li>
                <li><a href="{{route('freeAdsLimit')}}">Ads Duration</a></li>
                <li><a href="{{route('safety_tip')}}">Safety Tip</a></li>
                <li><a href="{{route('seoSetting')}}">SEO Setting</a></li>
                <li><a href="{{route('faq.list')}}">FAQ</a></li>
                
                <li><a href="{{route('socialLoginSetting')}}">Social Media Login</a></li>
                <li><a href="{{route('socialSetting')}}">Social Media Link</a></li>
                <li><a href="{{route('googleSetting')}}">Analytics &amp; Adsense</a></li>
                <li><a href="{{route('google_recaptcha')}}">Google eCaptcha</a></li>

                </ul>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-home"></i><span class="hide-menu">Homepage Setting</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('admin.homepageSection')}}">Homepage</a></li>
                        <li><a href="{{route('menu')}}">Menus</a></li>
                        <li><a href="{{route('slider.create')}}">Sliders</a></li>
                       

                    </ul>
                </li>
                <li> <a class="waves-effect waves-dark" href="{{route('banner')}}" aria-expanded="false"><i class="fa fa-newspaper"></i><span class="hide-menu">Banners </span></a></li>
               
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-settings"></i><span class="hide-menu">Payment Settings</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('paymentGateway')}}">Purchase Gateway</a></li>
                        <li><a href="{{route('sellerPaymentGateway')}}">Payment Gateway</a></li>
                    </ul>
                </li>
                <li>
                <a class=" has-arrow  waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-email"></i><span class="hide-menu">SMTP &amp; OTP Config </span></a>
                <ul aria-expanded="false" class="collapse">
                <li><a href="{{route('smtp_settings')}}">SMTP settings</a></li>
                <li><a href="{{route('otp_configurations')}}">OTP configurations</a></li>

                </ul>
                </li>
            

                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-map"></i><span class="hide-menu">Location</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('state')}}">Division</a></li>
                        <li><a href="{{route('city')}}">City</a></li>
                        <!-- <li><a href="{{route('area')}}">Area</a></li> -->
                    </ul>
                </li>
                

                <li>
                <a class=" has-arrow  waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-lock"></i><span class="hide-menu">Module &amp; Role </span></a>
                <ul aria-expanded="false" class="collapse">
                <li><a href="{{url('/')}}/admin/module/list">Modules</a></li>
                <li><a href="{{url('/')}}/admin/role/list">Role &amp; Permission</a></li>

                </ul>
                </li>
                
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-newspaper"></i><span class="hide-menu">Manage Pages</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('page.create')}}">Add New Page</a></li>
                        <li><a href="{{route('page.list')}}">Page list</a></li>
                    </ul>
                </li>

                
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-user"></i><span class="hide-menu">Account Setting</span></a>
                    <ul aria-expanded="false" class="collapse">
                       <li><a href="{{route('admin.profileUpdate')}}">Profile Setting</a></li>
                        <li><a href="{{route('admin.passwordChange')}}">Change Password</a></li>
                    </ul>
                </li>
                <li> <a class="waves-effect waves-dark" href="{{ route('adminLogout') }}"  aria-expanded="false"><i class="fa fa-power-off text-success"></i><span class="hide-menu">Log Out</span></a></li>

            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
