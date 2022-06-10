<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">

                <li> <a class="waves-effect waves-dark" href="{{route('admin.dashboard')}}" aria-expanded="false"><i class="fa fa-tachometer-alt"></i><span class="hide-menu">Dashboard</span></a></li>

                <li> <a class="waves-effect waves-dark" href="{{route('find.jobs')}}" aria-expanded="false"><i class="fa fa-search"></i><span class="hide-menu">Find Jobs</span></a></li>

                <li> <a class="waves-effect waves-dark" href="{{route('post.job')}}" aria-expanded="false"><i class="fa fa-plus-square"></i><span class="hide-menu">Post New Job</span></a></li>
                <li> <a class="waves-effect waves-dark" href="{{route('myJobs')}}" aria-expanded="false"><i class="fa fa-briefcase"></i><span class="hide-menu">My Jobs</span></a></li>
               
               
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-sitemap"></i><span class="hide-menu">My Work</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('myWorks')}}">My Task</a></li>
                        <li><a href="{{route('myWorks', 'accepted')}}">Accepted Task</a></li>
                        
                    </ul>
                </li>

                
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-dollar-sign"></i><span class="hide-menu">Deposit </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('depositBalance')}}">Deposit Balance</a></li>
                        <li><a href="{{route('depositHistory')}}">Deposit History</a></li>
                    </ul>
                </li>

                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-dollar-sign"></i><span class="hide-menu">Transactions</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('user.walletHistory')}}">Withdraw</a></li>
                    </ul>
                </li>
              
               
                <li> <a class="waves-effect waves-dark" href="{{route('allNotifications')}}" aria-expanded="false"><i class="fa fa-bell"></i><span class="hide-menu">Notifications</span></a></li>
                <li> <a class="waves-effect waves-dark" href="{{route('userDeposit')}}" aria-expanded="false"><i class="fa fa-bell"></i><span class="hide-menu">Deposit</span></a></li>

                <li> <a class="waves-effect waves-dark" href="{{route('addvertisement.list')}}" aria-expanded="false"><i class="fa fa-adversal"></i><span class="hide-menu">Advertisement</span></a></li>
                
                <li> <a class="waves-effect waves-dark" href="{{route('addvertisement.list')}}" aria-expanded="false"><i class="fa fa-box-open"></i><span class="hide-menu">Ticket</span></a></li>
                
                <li> <a class="waves-effect waves-dark" href="{{route('addvertisement.list')}}" aria-expanded="false"><i class="fa fa-trophy"></i><span class="hide-menu">Play & Earn</span></a></li>

                
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
