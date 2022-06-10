 @extends('layouts.frontend')
@section('title', 'Promote Ad' )
@section('css')
<link rel="stylesheet" href="{{asset('frontend')}}/css/custom/ad-post.css">
<style type="text/css">
    .packageBox{cursor: pointer; position: relative; border: 2px solid #bdbdbd;border-radius: 16px;padding: 10px;margin-bottom: 10px !important;width: 100%;}
    .packageValue{border: 1px solid #a3dca2; border-radius: 16px;padding: 3px 10px;margin-bottom: 5px; color: #279625;}
    .adpost-plan-list input[type="radio"]:checked + label { border-color: #3db83a; }

    .packageValueList input[type="radio"]:checked + label {background-color: #a3dca2;color: #279625;}
    .adpost-plan-list input[type="radio"]{display: none;}
</style>

@endsection
@section('content')

    <!--=====================================
                ADPOST PART START
    =======================================-->
    <section class="user-area">
        <div class="container">
            <div class="row">
                <!--Right Part Start -->
                @include('users.inc.sidebar')
                <!--Middle Part Start-->
                <div class="col-md-9 sticky-conent">
                    <form action="{{ route('ads.promote', $adsSlug) }}" data-parsley-validate method="post" enctype="multipart/form-data" class="adpost-form">
                        @csrf
                       	<div class="adpost-card">
                                <div class="row offset-md-2">
                           
                                    <div class="col-md-8">
                                        <div class="adpost-title" >
                                            <h3 style="text-align: center;">Promote your ad</h3>
                                            <p>Please choose one of the following options to post your ad</p>
                                        </div>
                                        <ul class="adpost-plan-list">

                                            <li>
                                                <a target="_blank" style="color:#000; display: flex;" href="{{ route('post_details', $post->slug) }}">
                                                    <div>
                                                    <img width="120" src="{{asset('upload/images/product/thumb/'.$post->feature_image)}}" alt="{{$post->title}}"> </div>
                                                    <div style="margin-left: 5px;">
                                                    <p> {{Str::limit($post->title, 60)}}</p>
                                                    <p style="font-size:12px"> <span><i class="fas fa-tags"></i> {{$post->get_category->name ?? ''}}, {{$post->get_state->name ?? ''}}</span></p>
                                                    <p class="fa fa-clock" style="font-size:10px"> {{Carbon\Carbon::parse(($post->approved) ? $post->approved : $post->created_at)->format(Config::get('siteSetting.date_format'))}}</p>
                                                    <p style="font-size:10px" class="fa fa-eye"> Views {{$post->views}} </p><br/>
                                                    {{Config::get('siteSetting.currency_symble') . $post->price}}</div>
                                                </a>
                                            </li>
                                        @if($post->status == 'Not posted')
                                            @php $last_free_post = App\Models\Product::where('subcategory_id', $post->subcategory_id)->where('user_id', $post->user_id)->where('ad_type', 'free')->orderBy('created_at', 'desc')->where('id', '!=', $post->id)->first();

                                            $to = \Carbon\Carbon::parse($last_free_post->created_at);
                                            $from = \Carbon\Carbon::parse(now());
                                            $days = $to->diffInDays($from);
                                            
                                            $free_ads_duration = App\Models\SiteSetting::where('type', 'free_ads_limit')->first();

                                            @endphp
                                        
                                            @if($free_ads_duration->status != 1 || $days >= $free_ads_duration->value)
                                            <input required type="radio" checked class="package" value="free" name="package" id="standard">
                                            <label class="packageBox" for="standard">
                                                <div class="adpost-plan-content">
                                                    <h6>Standard ad <span>Free Ad Listings</span></h6>
                                                </div>
                                            </label>
                                            @endif
                                        @endif
                                          
                                            @foreach($packageTypes as $index => $package)
                                            @if(count($package->get_purchasePackages)>0 || count($package->get_packageVlues)>0)
                                            <input type="radio" @if($index == 0) checked @endif class="package" value="{{$package->id}}" name="package" id="package{{$package->id}}">

                                            <label style="background: {{$package->background_color}}" class="packageBox" for="package{{$package->id}}">
                                                
                                                <div class="adpost-plan-content">
                                                    <h6><img width="25" src="{{asset('upload/images/package/'.$package->ribbon)}}"> {{$package->name}}</h6>
                                                    @if($package->promote_demo)
                                                    <span onclick="promteDemo('{{asset("upload/images/package/".$package->promote_demo)}}', '{{$package->details}}')" style="position: absolute;right: 10px;top: 0;"><i class="fa fa-eye"></i> See Example</span>@endif
                                                </div>
                                                <div class="packageValueList">
                                                    @if(count($package->get_purchasePackages)>0)
                                                        <p style="font-size: 12px;line-height: 5px;padding-left: 30px;">My Purchased Package</p>
                                                        @foreach($package->get_purchasePackages as $index => $packageValue)
                                                        @if($index == 0)
                                                        
                                                        <h3 style="text-align: right;">{{config('siteSetting.currency_symble')}}<span id="packagePrice{{$package->id}}">{{round($packageValue->price)}}</span></h3>@endif

                                                        <input onclick="packageBox('{{$package->id}}', {{$packageValue->price}})" type="radio" @if($index == 0) checked @endif name="purchasPackvalue[{{$package->id}}]" value="{{$packageValue->id}}" id="purchasPackvalue{{$packageValue->id}}">
                                                        <label for="purchasPackvalue{{$packageValue->id}}" class="packageValue">{{$packageValue->duration}} days</label>
                                                        @endforeach
                                                    @else
                                                       
                                                        @foreach($package->get_packageVlues as $index => $packageValue)
                                                        @if($index == 0)
                                                        <h3 style="text-align: right;">{{config('siteSetting.currency_symble')}}<span id="packagePrice{{$package->id}}">{{round($packageValue->price)}}</span></h3>@endif

                                                        <input onclick="packageBox('{{$package->id}}', {{$packageValue->price}})" type="radio" @if($index == 0) checked @endif name="packageValue[{{$package->id}}]" value="{{$packageValue->id}}" id="packvalue{{$packageValue->id}}">
                                                        <label for="packvalue{{$packageValue->id}}" class="packageValue">{{$packageValue->duration}} days</label>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </label>
                                            @endif
                                            @endforeach
                                            
                                        </ul>
                                    </div>
                                    <div class="col-md-8">
                                    <div class="form-group text-right">
                                        <button style="width: 100%;" class="btn btn-inline">
                                            <i class="fas fa-check-circle"></i>
                                            <span>Published Your Ad</span>
                                        </button>
                                    </div>
                                    </div>
                                </div>
                            </div>   
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!--=====================================
                ADPOST PART END
    =======================================-->
    <div class="modal fade" id="promte_demo_modal" role="dialog"   style="display: none;">
        <div class="modal-dialog" style="max-width: 95%;">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Promote Ad View</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div style="text-align:center;" id="promote_demo">
                
            </div>
          </div>
        </div>
    </div>
    <script type="text/javascript">
        function promteDemo(src, details=null) {
            $('#promte_demo_modal').modal('show');
            $('#promote_demo').html('<p>'+details+'</p><img style="max-width: 100%;" src="'+src+'">');
        }
    </script>
@endsection

@section('js')
<script type="text/javascript">
    function packageBox(id, price){
        $("#packagePrice"+id).html(price);
        $(".package").prop("checked", false);
        $('#package'+id).prop('checked', true);
    }
</script>



@endsection