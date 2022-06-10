<form  onsubmit="return confirm('Are you sure update this package payment info.?')" action="{{route('changePaymentStatus')}}" method="post">
    @csrf
    <div class="row">
        <div class="col-md-12">
        	<input type="hidden" name="order_id" value="{{ $order->order_id }}">
            <table class="">
                <tr><td style="font-weight: bold;">Seller Name:</td><td> {{ $order->customer->name }}</td></tr>
                <tr><td style="font-weight: bold;">Payble Amount:</td><td>  {{$order->currency_sign . $order->price   }}</td>
                </tr>
                
                
            </table>
      
            <span style="font-weight: bold;">Payment Information:</span><br/>
            @if($order->tnx_id) Trnx Id: {{$order->tnx_id}} <br> @endif {{ $order->payment_info}}
            
        </div>

 

        <div class="col-md-12">
            <label for="notes">Payment Status</label>
            <select name="payment_status" required="" class="form-control" id="status">
                <option value="">Select Status</option>
                <option @if($order->payment_status== 'pending') selected @endif value="pending">Pending</option>
                <option @if($order->payment_status== 'received') selected @endif value="received">Received</option>
                
                <option @if($order->payment_status== 'paid') selected @endif value="paid">Paid</option>
                
            </select>
        </div>

       
        <div class="col-md-12">
           
            <div class="modal-footer">
                <button type="submit" id="submitBtn" class="btn btn-success"> <i class="fa fa-save"></i> Update payment</button>
            </div>
        </div>
       
    </div>
</form>