<input type="hidden" name="id" value="{{$ticket->id}}">
<div class="col-md-12">
    <div class="form-group">
        <label class="required" for="title">Ticket Title</label>
        <input  name="title" id="title" value="{{$ticket->title}}" required="" type="text" class="form-control">
    </div>
</div>

<div class="col-md-12">
    <div class="form-group">
        <label class="required" for="ticket_price">Ticket Price</label>
        <input  name="ticket_price" id="ticket_price" value="{{$ticket->ticket_price}}" required="" type="number" class="form-control">
    </div>
</div>


<div class="col-md-12">
    <div class="form-group">
        <label style="background: #fff;top:-10px;z-index: 1" for="ticket_details">Ticket Details</label>
        <textarea name="ticket_details" class="form-control" placeholder="Enter details" id="ticket_details" rows="3">{!!$ticket->details!!}</textarea>
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        <label class="required" for="name">Start Date</label>
        <input name="start_date" required class="form-control" type="datetime-local" value="{{ Carbon\Carbon::parse($ticket->start_date)->format('Y-m-d\TH:i:s')}}">
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label class="required" for="name">End Date</label>
        <input name="end_date" required class="form-control" type="datetime-local" value="{{ Carbon\Carbon::parse($ticket->end_date)->format('Y-m-d\TH:i:s')}}">
    </div>
</div>
<div class="col-md-12">
    <div class="form-group"> 
        <label class="dropify_image">Banner Image</label>
        <input  type="file" class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpg jpeg png gif" data-default-file="{{asset('upload/images/ticket/'.$ticket->banner)}}" data-max-file-size="10M"  name="banner" id="input-file-events">
        <i class="image_size">Image Size:600px * 300px </i>
    </div>
</div>

<div class="col-md-12 mb-12">
    <div class="form-group">
        <label class="switch-box">Status</label>
        <div  class="status-btn" >
            <div class="custom-control custom-switch">
                <input name="status" {{($ticket->status == 1) ?  'checked' : ''}}   type="checkbox" class="custom-control-input" id="status-edit">
                <label  class="custom-control-label" for="status-edit">Publish/UnPublish</label>
            </div>
        </div>
    </div>
</div>