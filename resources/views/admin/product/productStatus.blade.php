<input type="hidden" name="id" value="{{$product->id}}">
<div class="form-group">
    <label>Status</label>
    <select onchange="postStatus(this.value)" name="status" class="form-control">
        <option value="" >Select Status</option>
        <option value="pending" @if($product->status == 'pending') selected @endif >Pending</option>
        <option value="active" @if($product->status == 'active') selected @endif>Active</option>
        <option value="deactive" @if($product->status == 'deactive') selected @endif>Deactive</option>
       
        <option value="reject" @if($product->status == 'reject') selected @endif>Reject</option>
    </select>
</div>



<div class="form-group" id="rejectReason">@if($product->status == 'reject')<div class="form-group"><label>Reject reason</label><textarea name="reject_reason" class="form-control" placeholder="Write post reject reason">{!! $product->reject_reason !!}</textarea></div>@endif</div>

<script type="text/javascript">
     
        function postStatus(status) {
            if(status == 'reject'){
                $('#rejectReason').html(`<div class="form-group">
    <label>Reject reason</label>
    <select name="reason" class="form-control">
        @foreach($reasons as $reason)
        <option value="{{$reason->reason}}" >{{$reason->reason}}</option>
        @endforeach
    </select>
</div><div class="form-group"><label>Write reject issue</label><textarea name="reject_reason" class="form-control" placeholder="Write post reject reason">{!! $product->reject_reason !!}</textarea></div>`);
            }else{
                 $('#rejectReason').html('');
            }

        }
</script>