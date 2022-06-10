@extends('layouts.frontend')
@section('title', 'Dashboard | '. Config::get('siteSetting.site_name') )
@section('css')
 <link rel="stylesheet" href="{{asset('frontend')}}/css/custom/dashboard.css">

@endsection
@section('content')
        <section class="dash-header-part">
            <div class="container">
                <div class="row">
                   
                    <!--Middle Part Start-->
                    <div class="col-md-9 sticky-conent">
                        <div class="dash-header-card">
                            <div class="row">
                                <div class="col-lg-5">
                                    <div class="dash-header-left">
                                         
                                        <div class="dash-intro">
                                            <h4><a href="#">{{$user->name}}</a></h4>
                                            <h5>Member Since: {{Carbon\Carbon::parse($user->created_at)->format(Config::get('siteSetting.date_format'))}}</h5>
                                            <ul class="dash-meta">
                                                <li>
                                                    <i class="fas fa-phone-alt"></i>
                                                    <span>{{$user->mobile}}</span>
                                                </li>
                                                @if($user->email)
                                                <li>
                                                    <i class="fas fa-envelope"></i>
                                                    <span>{{$user->email}}</span>
                                                </li>@endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="dash-header-right">
                                        <div class="dash-focus dash-list">
                                            <h2>{{$total_posts}}</h2>
                                            <p>listing ads</p>
                                        </div>
                                        <div class="dash-focus dash-book">
                                            <h2>{{$follower}}</h2>
                                            <p>follower</p>
                                        </div>
                                        <div class="dash-focus dash-rev">
                                            <h2>{{$following}}</h2>
                                            <p>following</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($user->user_dsc)
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="dash-header-alert">
                                        <p>{{$user->user_dsc}}</p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <section style="margin-top: 15px;">
                                <h4>Published Ads</h4>
                                <div class="table-responsive">
                                    <table id="config-table" class="table post-list table-hover ">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Image</th>
                                                <th>Ads Title</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead> 
                                        <tbody>
                                            @if(count($posts)>0)
                                            @foreach($posts as $index => $post)
                                            <tr id="item{{$post->id}}">
                                                <td>{{$index+1}}</td>
                                                <td><a  target="_blank" href="{{ route('post_details', $post->slug) }}"><img src="{{asset('upload/images/product/thumb/'. $post->feature_image)}}" width="80"></a></td>
                                                <td><a target="_blank" style="color:#000" href="{{ route('post_details', $post->slug) }}"> {{$post->title}} </a><br/>
                                                
                                              
                                                {{Config::get('siteSetting.currency_symble') . $post->price}}<br/>
                                                
                                                    <p class="fa fa-clock" style="font-size:10px"> {{Carbon\Carbon::parse($post->created_at)->format(Config::get('siteSetting.date_format'))}}</p>
                                                    <p style="font-size:10px" class="fa fa-eye"> Views {{$post->views}} </p>
                                                    
                                                </td>
                                               
                                                <td>
                                                   
                                                    <span class="post-status badge @if($post->status == 'reject') badge-danger @elseif($post->status == 'active') badge-success @else badge-info @endif"> {{$post->status}} </span>
                                                    
                                                </td>
                                                
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr style="text-align: center;"><td colspan="8">Posts not found.!</td></tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection     
    


