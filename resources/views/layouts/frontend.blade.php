<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="shortcut icon" type="text/css" href="{{asset('upload/images/logo/'. Config::get('siteSetting.favicon'))}}"/>
    <title>@yield('title')</title>
  
    <!-- /*process bar*/ -->
    <style type="text/css">
        .pace{-webkit-pointer-events:none;pointer-events:none;-webkit-user-select:none;-moz-user-select:none;user-select:none}.pace-inactive{display:none}.pace .pace-progress{background:#07c10d;position:fixed;z-index:2000;top:0;right:100%;width:100%;height:2px}
        .page-wrapper {padding: 0 !important;}
        .adsArea {padding-top: 67px ;}
        @media (min-width: 1024px){.adsArea {margin-left: 220px;}}

        @media (min-width: 768px){ .mini-sidebar .adsArea {margin-left: 70px;}}
    </style>
    @include('layouts.partials.frontend.css')
</head>
<body class="fixed-layout skin-blue-dark" >
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <!--<div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Please Wait...</p>
        </div>
    </div> -->
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
    <div id="app">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        @include('layouts.partials.frontend.header')
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
      
        @include('layouts.partials.frontend.sidebar1')

        <div class="adsArea">
            @php
            $get_ads = App\Models\Addvertisement::inRandomOrder()->where('status', 'active')->get();

            $topOfContent = $middleOfContent = $bottomOfContent = $sitebarTop = $sitebarMiddle = $sitebarBottom = null ;
            foreach ($get_ads as $ads){
                if($ads->position == 'top-content'){
                    $topOfContent = ($ads->adsType == 'image') ? '<a  href="'.$ads->redirect_url.'"><img src="'.asset('upload/marketing/'.$ads->image).'" alt=""></a>' : $ads->add_code;
                }elseif($ads->position == 'middle-content'){
                    $middleOfContent = ($ads->adsType == 'image') ? '<a  href="'.$ads->redirect_url.'"><img src="'.asset('upload/marketing/'.$ads->image).'" alt=""></a>' : $ads->add_code;
                }elseif($ads->position == 'bottom-content'){
                    $bottomOfContent = ($ads->adsType == 'image') ? '<a  href="'.$ads->redirect_url.'"><img src="'.asset('upload/marketing/'.$ads->image).'" alt=""></a>' : $ads->add_code;
                }elseif($ads->position == 'sidebar-top'){
                    $sitebarTop = '<div class="sidebar">'. ($ads->adsType == 'image' ? '<a  href="'.$ads->redirect_url.'"><img src="'.asset('upload/marketing/'.$ads->image).'" alt=""></a>' : $ads->add_code) . '</div>';
                }elseif($ads->position == 'sidebar-middle'){
                    $sitebarMiddle = '<div class="sidebar">'. ($ads->adsType == 'image' ? '<a  href="'.$ads->redirect_url.'"><img src="'.asset('upload/marketing/'.$ads->image).'" alt=""></a>' : $ads->add_code) . '</div>';
                }elseif($ads->position == 'sidebar-bottom'){
                    $sitebarBottom = '<div class="sidebar">'. ($ads->adsType == 'image' ? '<a href="'.$ads->redirect_url.'"><img src="'.asset('upload/marketing/'.$ads->image).'" alt=""></a>' : $ads->add_code) . '</div>' ; 
                }else{
                    echo '';
                }
            }
            @endphp
             <div class="advertising">
                {!! $topOfContent !!}
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
       <!-- ============================================================== -->
        @yield('content')
        <div class="advertising">
            {!! $middleOfContent !!}
        </div>

        <!-- footer -->
        <!-- ============================================================== -->
        <footer class="footer">
            {!! config('siteSetting.copyright_text') !!}
        </footer>
    </div>
    </div>
    <!-- End Wrapper -->
    <!-- include js files -->
    @include('layouts.partials.frontend.scripts')
</body>
</html>
