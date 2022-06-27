<form  onsubmit="return confirm('Are you sure update this deposit payment info.?')" action="{{route('depositPaymentUpdate')}}" method="post">
    @csrf
    <div class="row">
        <div class="col-md-12">
        	<input type="hidden" name="deposit_id" value="{{ $deposit->id }}">
            <table class="">
                <tr><td style="font-weight: bold;">Author Name:</td><td> {{ $deposit->user->name }}</td></tr>
                <tr><td style="font-weight: bold;">Amount:</td><td>  {{config('siteSetting.currency_symble') . $deposit->amount   }}</td>
                </tr>
            </table>
            <span style="font-weight: bold;">Payment Information:</span><br/>
            @if($deposit->tnx_id) Trnx Id: {{$deposit->tnx_id}} <br> @endif {{ $deposit->payment_info}}
            
        </div>

 

        <div class="col-md-12">
            <label for="notes">Payment Status</label>
            <select name="payment_status" required="" class="form-control" id="status">
                <option value="">Select Status</option>
                <option @if($deposit->payment_status== 'pending') selected @endif value="pending">Pending</option>
                <option @if($deposit->payment_status== 'received') selected @endif value="received">Received</option>
                
                <option @if($deposit->payment_status== 'paid') selected @endif value="paid">Paid</option>
                <option @if($deposit->payment_status== 'reject') selected @endif value="reject">Reject</option>
                
            </select>
        </div>

       
        <div class="col-md-12">
           
            <div class="modal-footer">
                <button type="submit" id="submitBtn" class="btn btn-success"> <i class="fa fa-save"></i> Update payment</button>
            </div>
        </div>
       
    </div>
</form>