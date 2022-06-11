<input type="hidden" value="{{$data->id}}" name="id">
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="ads_name">Ads Title</label>
            <input type="text" value="{{$data->ads_name}}"  name="ads_name"  id="ads_name" placeholder="Enter ads name" class="form-control" >
        </div>
    </div>

    <div class="col-md-12">
       <div class="form-group"> <label for="redirect_url">Redirect URL</label>  <input type="text" name="redirect_url"  id="redirect_url" value="{{$data->redirect_url}}" class="form-control" > </div>
    </div>

    <div class="col-md-12">
        <div class="form-group labelArea row"> 
            @for($i=1; $i<=7; $i++)
            <div class="col-md-6">
            <input type="radio" name="price" @if($data->days == $i) checked @endif value="{{$i}}" id="editprice{{$i}}">
            <label for="editprice{{$i}}" class="labelBox"><span> <i class="fab fa-adversal"></i> {{$i}} Day</span> <span>{{ config('siteSetting.currency_symble'). $i}}</span></label> </div>
            @endfor
        </div>
    </div>

    <div class="col-md-12">
       <div class="form-group"><label class="dropify_image_area required">Add Images</label> <div class="form-group"> <input data-default-file="{{asset('upload/marketing/'.$data->image)}}" type="file" name="image" id="input-file-now" class="dropify" /> </div> </div>
    </div>
    

    
</div>