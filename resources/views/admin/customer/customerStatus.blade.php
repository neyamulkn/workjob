<input type="hidden" name="id" value="{{$customer->id}}">
<div class="form-group">
    <label>Status</label>
    <select required onchange="postStatus(this.value)" name="status" class="form-control">
        <option value="" >Select Status</option>
        
        @if($verify)
        <option value="verify" @if($customer->verify) selected @endif>Verify</option>
        <option value="unverify" @if($customer->verify == null) selected @endif>Unverify</option>
        @else
        <option value="pending" @if($customer->status == 'pending') selected @endif >Pending</option>
        <option value="active" @if($customer->status == 'active') selected @endif>Active</option>
        <option value="deactive" @if($customer->status == 'deactive') selected @endif>Deactive</option>
       
        <option value="band" @if($customer->status == 'band') selected @endif>Band</option>
        @endif
    </select>
</div>



<!-- <div class="form-group" id="bandReason">@if($customer->status == 'band')<div class="form-group"><label>Band reason</label><textarea name="band_reason" class="form-control" placeholder="Write band reason">{!! $customer->band_reason !!}</textarea></div>@endif</div>
 -->
<script type="text/javascript">
     
        function postStatus(status) {
            if(status == 'band'){
                $('#bandReason').html(`<div class="form-group">
    <label>band reason</label>
    <select name="reason" class="form-control">
        
    </select>
</div><div class="form-group"><label>Write band issue</label><textarea name="band_reason" class="form-control" placeholder="Write post band reason">{!! $customer->band_reason !!}</textarea></div>`);
            }else{
                 $('#bandReason').html('');
            }

        }
</script>