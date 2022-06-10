 @extends('layouts.frontend')
@section('title', 'Post lists' )
@section('css')
<style type="text/css">
    .post-list{display: flex;justify-content: space-between;border-bottom: 1px solid #e3e0e0;padding: 8px 0;}
    .post-list a{line-height: 16px;font-size: 15px;}
    .post-status{text-transform: capitalize; margin: 0 5px;}
    .action{display: flex;flex-direction: column;justify-content: space-between;min-width: 90px;}
    .actionBtn{display: flex;flex-direction: column;justify-content: space-between;}
    .actionBtn a{margin-bottom: 8px;}
    .info-area{display: flex;padding:0 5px 5px;justify-content: space-between;align-items: center;}
    @media (max-width: 767px) {
        .post-list{flex-direction: column;}
        .actionBtn a{border-right: 1px solid #ccc;padding: 0 5px;margin: 0;}
        .actionBtn a:last-child{border: none;}
       .action { flex-direction: initial;}
       .actionBtn { flex-direction: initial;align-items: center;}
       
    }
.clockdiv{ display: inline-flex; margin: 0 auto; text-align: center; align-items: center;}
.count_d {position: relative;width: 28px;padding: 0;overflow: hidden;color: #46b700;}
.count_d:before{ content: '';  position: absolute;top: 0;left: 0;width: 100%;height: 50%;}
.count_d span { text-align: center; font-size: 14px; font-weight: 800;}
.count_d h2 { display: block; text-align: center; font-size: 8px; font-weight: 800; margin: 0;}

</style>
@endsection
@section('content')
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
                        <h4 class="text-themecolor">Form Wizards</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                <li class="breadcrumb-item active">Form Wizards</li>
                            </ol>
                            <button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        @if(Session::has('success'))
                        <div class="alert alert-success">
                          <strong>Success! </strong> {{Session::get('success')}}
                        </div>
                        @endif
                        @if(Session::has('error'))
                        <div class="alert alert-danger">
                          <strong>Error! </strong> {{Session::get('error')}}
                        </div>
                        @endif
                        <form action="" method="get">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-6 col-md-4">
                                        <input name="title" placeholder="Title" value="{{ Request::get('title')}}" type="text" class="form-control">
                                    </div>
                                    <div class="col-6 col-md-3" style="margin-bottom: 5px;">
                                        <select name="status" class="form-control">
                                            <option value="all" {{ (Request::get('status') == "all") ? 'selected' : ''}}>All Status</option>
                                            <option value="pending" {{ (Request::get('status') == 'pending') ? 'selected' : ''}} >Pending</option>
                                            <option value="active" {{ (Request::get('status') == 'active') ? 'selected' : ''}}>Active</option>
                                            <option value="deactive" {{ (Request::get('status') == 'deactive') ? 'selected' : ''}}>Deactive</option>
                                            <option value="reject" {{ (Request::get('status') == 'reject') ? 'selected' : ''}}>Reject</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <div class="form-group" >
                                           <button type="submit" class="form-control btn btn-success">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <ul style="background:#fff">
                    @if(count($posts)>0)
                    @foreach($posts as $index => $post)
                    <li class="post-list" id="item{{$post->id}}">
                        <div style="display:flex;align-items: self-start;">

                        <a  target="_blank" href="{{ route('post_details', $post->slug) }}"><img src="{{asset('upload/images/product/thumb/'. $post->feature_image)}}" width="120"></a>
                        <div class="info-area">
                            <div>
                            <a target="_blank" style="color:#000" href="{{ route('post_details', $post->slug) }}"> {{Str::limit($post->title,45)}} </a><br/>
                            
                                
                                <p class="fa fa-clock" style="font-size:10px"> {{Carbon\Carbon::parse(($post->approved) ? $post->approved : $post->created)->format(Config::get('siteSetting.date_format'))}}</p>
                                <p style="font-size:10px" class="fa fa-eye"> Views {{$post->views}} </p><br/>
                                <p>
                                {{Config::get('siteSetting.currency_symble') . $post->price}}</p>
                                @if($post->approved)
                                @if(count($post->get_promotePackage)>0)
                                    @if(now() <= $post->get_promotePackage[0]->end_date) 

                                    <div class="clockdiv" data-date="{{$post->get_promotePackage[0]->end_date}}">
                                      <div class="count_d">
                                        <span class="days">0</span><sub>D</sub>
                                      </div>
                                      <div class="count_d">
                                        <span class="hours">0</span><sub>H</sub>
                                        </div>
                                        <div class="count_d">
                                          <span class="minutes">0</span><sub>M</sub>
                                        </div>
                                        <div class="count_d">
                                          <span class="seconds">0</span><sub>S</sub>
                                        </div>
                                    </div>
                                    @endif
                                @endif
                                @endif

                                @if($post->status == 'Not posted')
                                    @php $last_free_post = App\Models\Product::where('subcategory_id', $post->subcategory_id)->where('user_id', $post->user_id)->where('id', '!=', $post->id)->orderBy('created_at', 'desc')->where('ad_type', 'free')->first();
                                    $days = 0;
                                    if($last_free_post){
                                    $to = \Carbon\Carbon::parse($last_free_post->created_at);
                                    $from = \Carbon\Carbon::parse(now());
                                    $days = $to->diffInDays($from);
                                    }
                                    $free_ads_duration = App\Models\SiteSetting::where('type', 'free_ads_limit')->first();

                                    @endphp
                                    
                                    @if($free_ads_duration->status != 1 || $days >= $free_ads_duration->value )
                                    <p style="font-size:15px;color: green">Now available free post.</p>
                                    @else
                                    <p style="font-size:15px;color: red">Wait {{$free_ads_duration->value - $days}} days to post for free or pay to post now.</p>
                                    @endif
                                @else
                                @if($post->reject_reason)
                                <p style="font-size:15px;color: red">{{$post->reject_reason}}</p>
                                @endif
                                @endif
                            </div>
                            <div class="status">
                                <span class="post-status badge @if($post->status == 'reject')  badge-danger @elseif($post->status == 'Not posted') badge-danger @elseif($post->status == 'active') badge-success @else badge-info @endif"> {{$post->status}} </span>
                                
                            </div>
                        </div>
                           
                        </div>
                        <div class="action">
                           
                            <div class="actionBtn">
                                <a title="Edit ads" href="{{ route('post.edit', $post->slug) }}"><i class="fa fa-pencil-alt"></i> Edit</a>
                                <a href="javascript:void(0)" style="color:red;"  onclick='deleteModal({{$post->id}})' ><i class="fa fa-trash"></i> Delete</a> 
                            </div> 
                            <div >
                                @if($post->status == 'reject')
                                <a class="btn btn-danger btn-sm" title="Edit ads" href="{{ route('post.edit', $post->slug) }}"><i class="ti-pencil-alt"></i> Edit Post</a>
                                @elseif($post->status == 'Not posted' || $post->status == 'draft')
                                <a class="bt btn-primary btn-sm" title="Wait for free or promote ads" href="{{ route('ads.promotePackage', $post->slug) }}?status=post-now"><i class="ti-pencil-alt"></i>Post Now</a>

                                @elseif($post->status == 'pending')
                                <a class="btn btn-warning btn-sm" title="Review this post" href="{{ route('post.edit', $post->slug) }}"> In review</a>

                                @else
                                <a class="bt btn-info btn-sm" title="Promote ads" href="{{ route('ads.promotePackage', $post->slug) }}?status=promote"><i class="ti-pencil-alt"></i>@if(count($post->get_promotePackage)>0) Boosted @else Sell faster @endif</a>
                                @endif
                             </div>                                    
                        </div>
                    </li>
                    @endforeach
                    @else
                    <li style="text-align: center;">Posts not found.!</li>
                    @endif

                    <li style="margin: 5px">{{$posts->appends(request()->query())->links()}}</li>
                </ul>
        </div>
    </div>
    <div class="modal fade" id="deleteModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Post Delete</h4>
                    <button class="fas fa-times" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('post.delete')}}" method="post">
                        @csrf()
                        <input type="hidden" name="product_id" id="product_id">
                         
                        <div class="row justify-content-md-center">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required" for="reason">Delete Reason</label>
                                    <select required name="reason" class="form-control">
                                        <option value="">Select reason</option>
                                    @foreach($reasons as $reason)
                                        <option value="{{ $reason->reason }}">{{ $reason->reason }}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required" for="reason_details">Please describe delete reason.</label>
                                    <textarea class="form-control" required minlength="6" rows="2" id="reason_details" placeholder="Write reason details" name="reason_details"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger"> Delete Now</button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>  
@endsection

@section('js')
<script type="text/javascript">
    function deleteModal(product_id){
        $('#deleteModal').modal('show');
        $('#product_id').val(product_id);
    }
    document.addEventListener('readystatechange', event => {
        if (event.target.readyState === "complete") {
            var clockdiv = document.getElementsByClassName("clockdiv");
          var countDownDate = new Array();
            for (var i = 0; i < clockdiv.length; i++) {
                countDownDate[i] = new Array();
                countDownDate[i]['el'] = clockdiv[i];
                countDownDate[i]['time'] = new Date(clockdiv[i].getAttribute('data-date')).getTime();
                countDownDate[i]['days'] = 0;
                countDownDate[i]['hours'] = 0;
                countDownDate[i]['seconds'] = 0;
                countDownDate[i]['minutes'] = 0;
            }
          
            var countdownfunction = setInterval(function() {
                for (var i = 0; i < countDownDate.length; i++) {
                    var now = new Date().getTime();
                    var distance = countDownDate[i]['time'] - now;
                    countDownDate[i]['days'] = Math.floor(distance / (1000 * 60 * 60 * 24));
                    countDownDate[i]['hours'] = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    countDownDate[i]['minutes'] = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    countDownDate[i]['seconds'] = Math.floor((distance % (1000 * 60)) / 1000);

                    if (distance < 0) {
                        countDownDate[i]['el'].querySelector('.days').innerHTML = 0;
                        countDownDate[i]['el'].querySelector('.hours').innerHTML = 0;
                        countDownDate[i]['el'].querySelector('.minutes').innerHTML = 0;
                        countDownDate[i]['el'].querySelector('.seconds').innerHTML = 0;
                    }else{
                        countDownDate[i]['el'].querySelector('.days').innerHTML = countDownDate[i]['days'];
                        countDownDate[i]['el'].querySelector('.hours').innerHTML = countDownDate[i]['hours'];
                        countDownDate[i]['el'].querySelector('.minutes').innerHTML = countDownDate[i]['minutes'];
                        countDownDate[i]['el'].querySelector('.seconds').innerHTML = countDownDate[i]['seconds'];
                    } 
                }
            }, 1000);
        }
    });
</script>  
@endsection