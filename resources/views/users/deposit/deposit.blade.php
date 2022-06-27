@extends('layouts.frontend')
@section('title', 'Deposit Balance')
@section('css')
<style type="text/css">
.progress{background-color: #dddedf;}
    .details{padding: 10px;}
    a.active{border: 1px solid #ddd; border-bottom: none; }
    .custom-checkbox{margin: 10px 0 5px;padding: 0;}
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
                        <h4 class="text-themecolor">Deposit Balance</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Deposit</a></li>
                                <li class="breadcrumb-item active">Deposit</li>
                            </ol>
                            <a href="{{route('depositHistory')}}" class="btn btn-sm btn-info d-none d-lg-block m-l-15"><i class="fa fa-eye"></i> Deposit Balance</a>
                        </div>
                    </div>
                </div>
                <?php

                $deposit_config = App\Models\SiteSetting::where('type', 'discount_config')->first();
                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
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
                                <h5>Select Payment Method</h5>
                                <div style="background: #fff; padding-bottom: 0 10px 10px;">
                                    <div class="box-inner">          
                                        <div id="process"></div>  
                                        <ul class="nav nav-tabs">
                                          @foreach($paymentgateways as $index => $method)
                                            <li ><a onclick="paymentGateway({{$method->id}})" @if($index == 0) class="active" @endif style="display:block;padding: 10px;background: #fff;" data-toggle="tab" href="#paymentgateway{{$method->id}}"><img @if($method->method_slug == 'shurjopay') width = "190" height="45" @else width="90" @endif src="{{asset('upload/images/payment/'.$method->method_logo)}}"></a></li>
                                        
                                          @endforeach
                                        </ul>
                                        <div class="tab-content col-md-5" style="padding:10px">
                                            
                                            <label>Deposit Amount</label>
                                            <div class="wallet" id="wallet">
                                                <input type="number" required name="amount" onkeyup="commission(this.value)" min="{{$deposit_config->value2}}" placeholder="Enter amount" class="amount form-control" min="1" form="form{{$method->id}}">
                                            </div>
                                            <p style="color:#726a6a;margin-bottom: 5px;">*Minimum Deposit {{Config::get('siteSetting.currency_symble'). $deposit_config->value2}}</p>
                                            <strong style="font-size:17px"> Total Deposit Amount: <span id="commission">{{config('siteSetting.currency_symble')}}0</span></strong>
                                            
                                            @foreach($paymentgateways as $index => $method)

                                              @if($method->is_default == 1)
                                              <div id="paymentgateway{{$method->id}}" class="tab-pane fade @if($index == 0) active show @endif">
                                                  <form action="{{route('depositPayment')}}" name="form{{$method->id}}" id="form{{$method->id}}" method="post" @if($method->method_slug == 'masterCard') class="require-validation" data-cc-on-file="false" data-stripe-publishable-key="{{$method->public_key}}"  @endif >
                                                      @csrf
                                                      <input type="hidden"  name="payment_method" value="{{$method->method_slug}}">
                                                      
                                                      {!! $method->method_info !!}
                                                      
                                                      @if($method->method_slug == 'wallet-balance')
                                                         Your wallet balance: {{ config('siteSetting.currency_symble').Auth::user()->wallet_balance }}
                                                      @endif

                                                      @if($method->method_slug == 'masterCard')
                                                        <div class="form-row">                                    
                                                            <div id="card-element" style="width: 100%">
                                                                 <div class="display-td" >                            
                                                                    <img class="img-responsive pull-right" src="https://i76.imgup.net/accepted_c22e0.png">
                                                                  </div>
                                                               
                                                                  <div class="row">
                                                                    <div class="col-lg-8 col-md-8">
                                                                    <div class='col-lg-12 col-md-12 col-xs-12 card '> <span class='control-label required'>Card Number</span> <input  autocomplete='off' placeholder='Enter card number' class='form-control card-number' required size='20' type='text'> </div> <div class='col-xs-3  cvc '> <span class='control-label required'>CVC</span> <input autocomplete='off' class='form-control card-cvc' maxlength="3" placeholder='ex. 311' required size='4' type='text'> </div> <div class='col-xs-4 expiration '> <span class='required control-label'>Month</span>  <input maxlength="2" required class='form-control card-expiry-month' placeholder='MM' size='2' type='text'> </div> <div class='col-xs-5 expiration '> <span class='control-label required'>Expiration Year</span> <input class='form-control card-expiry-year' placeholder='YYYY' required size='4' maxlength="4" type='text'> </div>
                                                                  </div>
                                                                </div>
                                          
                                                                <div class='row'>
                                                                    <div class='col-md-12 error form-group hide'>
                                                                        <div style="padding: 5px;margin-top: 10px;" class='alert-danger alert'>Please correct the errors and try again.</div>
                                                                    </div>
                                                                </div>          
                                                            </div>
                                                          <!-- Used to display Element errors. -->
                                                          <div id="card-errors" role="alert"></div>
                                                        </div>
                                                      @endif
                                                    
                                                    <div>
                                                    @if($method->method_slug == 'wallet-balance')
                                                        @if(Auth::user()->wallet_balance >= 0)
                                                        <div class="custom-control custom-checkbox">
                                                              
                                                              <label class=""><input form="form{{$method->id}}" type="checkbox"class=""  required=""> I agree to all Terms of Service and all Policy.</label>
                                                              
                                                            </div>
                                                          <button  class="btn btn-block btn-dribbble payButton"><span><i class="fa fa-money" aria-hidden="true"></i> Pay with wallet balance </span></button>


                                                       
                                                        @else
                                                         <button title="Insufficient wallet balance" disabled  class="btn btn-block btn-dribbble payButton"><span><i class="fa fa-money" aria-hidden="true"></i> Insufficient wallet balance </span></button>
                                                        @endif
                                                      @else
                                                       

                                                    <div class="custom-control custom-checkbox">
                                                      
                                                      <label class=""><input form="form{{$method->id}}" type="checkbox" class=""  required="">@if($deposit_config->value > 0) Additional commission will be added {{$deposit_config->value}}%.@endif I agree to all Terms of Service and all Policy.</label>
                                                      
                                                    </div>
                                                    <button type="submit" name="payment_method" value="manual" class="btn btn-block btn-dribbble">Continue to payment</button> 
                                              
                                                      @endif
                                                      </div>
                                                  </form>
                                              </div>
                                              @else
                                              <div id="paymentgateway{{$method->id}}" class="tab-pane fade @if($index == 0) active show @endif">
                                                
                                                {!! $method->method_info !!}
                                                <form action="{{route('depositPayment')}}" name="form{{$method->id}}" id="form{{$method->id}}" data-parsley-validate method="post">
                                                  @csrf
                                                  <strong style="color: green;">Pay with {{$method->method_name}}.</strong><br/>
                                                  <input type="hidden"  name="manual_method_name" value="{{$method->method_slug}}">
                                                  @if($method->method_slug != 'cash')
                                                  <strong>Payment Transaction Id</strong>
                                                  <p><input type="text" required data-parsley-required-message = "Transaction Id is required" placeholder="Enter Transaction Id" value="{{old('trnx_id')}}" class="form-control" name="trnx_id"></p>
                                                  @endif
                                                  <strong>Write Your {{$method->method_name}} Payment Information below.</strong>
                                                  <textarea required data-parsley-required-message = "Payment Information is required" name="payment_info" style="margin: 0;" rows="2" placeholder="Write Payment Information" class="form-control">{{old('payment_info')}}</textarea>
                                                  
                                                  <div class="custom-control custom-checkbox">
                                                      
                                                      <label class=""><input form="form{{$method->id}}" type="checkbox" class=""  required="">@if($deposit_config->value > 0) Additional commission will be added {{$deposit_config->value}}%.@endif I agree to all Terms of Service and all Policy.</label>
                                                      
                                                    </div>
                                                    <button type="submit" name="payment_method" value="manual" class="btn btn-block btn-dribbble">Continue to payment</button> 
                                              
                                                </form>
                                              </div>
                                              @endif
                                            @endforeach
                                             </div>
                                          </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
@endsection

@section('js')
    <script type="text/javascript">
    
    //Allow checkbox check/uncheck handle
    function paymentGateway(id){
    var amount = $('.amount').val();
    $("#wallet").html('<input type="number" required onkeyup="commission(this.value)" value="'+amount+'" min="{{$deposit_config->value2}}" class="amount form-control" style="padding: 0 7px;border: 1px solid #ccc;" form="form'+id+'" required placeholder="Enter amount" min="1" max="{{Auth::user()->wallet_balance}}" name="amount">');    
    }

    function commission(){
        var amount = $('.amount').val();
        var commission =  {{$deposit_config->value}};

        commission = ((amount * commission) / 100);
        commission = parseInt(amount) + parseInt(commission);
        $('#commission').html("{{config('siteSetting.currency_symble')}}"+commission);
    }

</script>
@endsection
