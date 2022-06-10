@extends('layouts.frontend')
@section('title', Config::get('siteSetting.title'))
@section('metatag')
    <title>{{Config::get('siteSetting.title')}}</title>
    <meta name="title" content="{{Config::get('siteSetting.title')}}">
    <meta name="description" content="{{Config::get('siteSetting.description')}}">
    <meta name="keywords" content="{{Config::get('siteSetting.meta_keywords')}}" />
    <meta name="robots" content="index,follow" />

    <!-- Open Graph general (Facebook, Pinterest & Google+) -->
    <meta property="og:title" content="{{Config::get('siteSetting.title')}}">
    <meta property="og:description" content="{{Config::get('siteSetting.description')}}">
    <meta property="og:image" content="{{asset('upload/images/'.Config::get('siteSetting.meta_image'))}}">
    <meta property="og:url" content="{{ url()->full() }}">
    <meta property="og:site_name" content="{{Config::get('siteSetting.site_name')}}">
    <meta property="og:locale" content="bd">
    <meta property="og:type" content="e-commerce">
    <!-- Schema.org for Google -->

    <meta itemprop="title" content="{{Config::get('siteSetting.title')}}">
    <meta itemprop="description" content="{{Config::get('siteSetting.description')}}">
    <meta itemprop="image" content="{{asset('upload/images/'.Config::get('siteSetting.meta_image'))}}">

    <!-- Twitter -->
    <meta name="twitter:card" content="{{Config::get('siteSetting.title')}}">
    <meta name="twitter:title" content="{{Config::get('siteSetting.title')}}">
    <meta name="twitter:description" content="{{Config::get('siteSetting.description')}}">
    <meta name="twitter:site" content="{{url('/')}}">
    <meta name="twitter:creator" content="@Neyamul">
    <meta name="twitter:image:src" content="{{asset('upload/images/'.Config::get('siteSetting.meta_image'))}}">
    <meta name="twitter:player" content="#">
@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('frontend')}}/css/custom/index.css">
    <style type="text/css">
        .homepage .container{padding: 10px;}
        .category .suggest-card {min-width: 120px;}
        .contentArea{margin: 0;}
        .search-btn{display: none;}
        .header-form{display: block;}
    </style>
@endsection
@section('content')
@php
    $get_ads = App\Models\Addvertisement::whereIn('page', ['homepage', 'all'])->inRandomOrder()->where('status', 1)->get();

    $topOfContent = $middleOfContent = $bottomOfContent = $sitebarTop = $sitebarMiddle = $sitebarBottom = null ;
    foreach ($get_ads as $ads){
        if($ads->position == 'top-content'){
            $topOfContent = ($ads->adsType == 'image') ? '<a  href="'.$ads->redirect_url.'"><img src="'.asset('upload/marketing/'.$ads->image).'" alt=""></a>' : $ads->add_code;
        }elseif($ads->position == 'middle-content'){
            $middleOfContent = ($ads->adsType == 'image') ? '<a  href="'.$ads->redirect_url.'"><img src="'.asset('upload/marketing/'.$ads->image).'" alt=""></a>' : $ads->add_code;
        }elseif($ads->position == 'bottom-content'){
            $bottomOfContent = ($ads->adsType == 'image') ? '<a  href="'.$ads->redirect_url.'"><img src="'.asset('upload/marketing/'.$ads->image).'" alt=""></a>' : $ads->add_code;
        }else{
            echo '';
        }
    }
    @endphp
    <!--=====================================
                BANNER PART START
    =======================================-->
    @if($slider)
    <section class="banner-part" style="background: url({{asset('upload/images/slider/'.$slider->photo)}}) no-repeat 50% 50%;">
        <div class="container">
            <div class="banner-content">
                <h1>{{$slider->title}}</h1>
                <p>{{$slider->subtitle}}</p>
                @if($slider->btn_text)
                <a href="{{$slider->btn_link}}" class="btn btn-outline">
                    <i class="fas fa-eye"></i>
                    <span>{{$slider->btn_text}}</span>
                </a>@endif
            </div>
        </div>
    </section>
    @endif
    <div class="container advertising">
        {!! $topOfContent !!}
    </div>
    <div class="homepage" >
        <div id="loadProducts">
            <!-- Load products here -->
        </div>
        <div class="ajax-load  text-center" id="data-loader"><img src="{{asset('frontend/images/loading.gif')}}"></div>
    </div>
    <div class="container advertising">
        {!! $bottomOfContent !!}
    </div>
@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function(){
        var page = 1;
        loadMoreProducts(page);
        function loadMoreProducts(page){
            $.ajax(
                {
                    url: '?page=' + page,
                    type: "get",
                    beforeSend: function()
                    {
                        $('.ajax-load').show();
                    }
                })
            .done(function(data)
            {
                $('.ajax-load').hide();
                $("#loadProducts").append(data.html);

                //check section last page
                if(page <= '{{$sections->lastPage()}}' ){
                    page++;
                    loadMoreProducts(page);
                }
                 
            })
            .fail(function(jqXHR, ajaxOptions, thrownError)
            {
                $('.ajax-load').hide();
            });
        }
    });
</script>
@endsection
