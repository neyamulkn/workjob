@php
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
@if(count($posts)>0)

<div class="row">
	<div class="col-12"><span style="padding-left:10px"><i class="fa fa-th-list"></i> 370 Job Found</span></div>
    @foreach($posts as $index => $post)
    <div class="col-12">
    	<a class="post-area" href="{{ route('job_details', $post->slug) }}">
        
            <div class="post-media" >
                <div class="post-img">
                   
                    <h5 class="post-title">
	                   {{Str::limit(ucfirst($post->title), 60)}}
	                </h5>
                </div>
            </div>
			<div class="post-content">
				<div class="post-info">
	                <span> {{$post->job_tasks_count}} OF {{$post->job_workers_need}} </span>
	                <div class="progress">
	                    <div class="progress-bar bg-success" style="width: {{\App\Http\Controllers\HelperController::workerProgress($post->job_tasks_count, $post->job_workers_need)}}%; height:6px;" role="progressbar"> </div>
	                </div>
                </div>
            
                <h5 class="post-price">{{Config::get('siteSetting.currency_symble') . $post->per_workers_earn}}<span></span></h5>
            </div>    
             
        </a>
    </div>
   
    @if($posts && $index > 2 && $index == (count($posts)/2))
    <div style="padding:3px 8px;" class="col-12 advertising">
    {!! $middleOfContent !!}
    </div>
    @endif
    
    @endforeach
 
    @if($posts && count($posts) >= 8)
    <div style="padding:3px 8px;" class="col-12 advertising">
    {!! $bottomOfContent !!}
    </div>
    @endif
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="footer-pagection">
            {{$posts->appends(request()->query())->links()}}
            
        </div>
    </div>
</div>

@else
<div style="text-align: center;">
    <h3>Search Result Not Found.</h3>
    <p>We're sorry. We cannot find any matches for your search term</p>
    <i style="font-size: 10rem;" class="fa fa-search"></i>
</div>
@endif