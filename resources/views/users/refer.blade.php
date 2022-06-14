@extends('layouts.frontend')
@section('title', 'Refer')
@section('css')
<style type="text/css">
    .custom_tooltip {
      position: relative;
      display: inline-block; margin-left: 5px;
    }

    .custom_tooltip .custom_tooltiptext {
      visibility: hidden;
      width: 140px;
      background-color: #555;
      color: #fff;
      text-align: center;
      border-radius: 6px;
      padding: 5px;
      position: absolute;
      z-index: 1;
      bottom: 150%;
      left: 50%;
      margin-left: -75px;
      opacity: 0;
      transition: opacity 0.3s;
    }

    .custom_tooltip .custom_tooltiptext::after {
      content: "";
      position: absolute;
      top: 100%;
      left: 50%;
      margin-left: -5px;
      border-width: 5px;
      border-style: solid;
      border-color: #555 transparent transparent transparent;
    }

    .custom_tooltip:hover .custom_tooltiptext {
      visibility: visible;
      opacity: 1;
    }
    .bg-blue {
    background-color: #5e72e4!important;
}
</style>

@endsection
@section('content')

        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h4 class="text-themecolor">Refer</h4>
                    </div>
                    
                </div>
               
                <div class="row offset-md-1">

                    <div class="col-md-6">
                        <div class="card card-with-shadow-sm h-100">
                            <div class="card-body px-4">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <h4 class="text-gray-400 m-0">Your Affiliate Link</h4>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-alternative">
                                        <input class="form-control font-weight-600" value="{{Auth::user()->referral_code}}" id="myInput" type="text" readonly="">
                                        <div class="input-group-prepend">
                                            <div class="custom_tooltip">
                                                <button onclick="myFunction()" onmouseout="outFunc()">
                                                  <span class="custom_tooltiptext" id="mycustom_tooltip">Copy to clipboard</span>
                                                  Copy referral code
                                                  </button>
                                                </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="bg-blue py-5 px-4 rounded">
                                              <p class="d-flex flex-nowrap m-0">
                                                <span class="mr-2"><strong class="font-weight-bold text-white">0</strong></span>
                                                <span class="text-white">User joined by your reffer link.</span>
                                            </p>
                                  <p class="text-white">Your valid reffer <strong>0</strong></p>
                                  
                                  
                                  
                                 <p class="text-yellow"><b>If you activate the account at your referral then you will get instant 0.10$ bonus in your earning balance.</b></p>
                                                <p style="margin-top: 10px" class="text-white"> Hello sir, you can now earn more by referring your friends. You will get 4% commission from your referrals each completed task &amp; 2% from your referral’s each deposit. </p>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <div class="row justify-content-between align-items-center">
                                    <div class="col">
                                        <h2 class="font-weight-bold mb-0 limited-offer__heading">Affiliate Program</h2>
                                    </div>
                                    <div class="col-auto">
                                        <span class="badge badge-lg badge-success drk_black_theme">Activated</span>
                                    </div>
                                </div>
                                <p style="padding: 5px;margin-top: 10px">Post your affiliate link on blogs, websites, forums, social media or write Workupjob review - Refer new members (Freelancers &amp; Business Owner) and earn commission revenue!</p>
                            </div>
                        </div>
                    </div>
                  
                </div> 
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>

@endsection
<script>
                            function myFunction() {
                              var copyText = document.getElementById("myInput");
                              copyText.select();
                              copyText.setSelectionRange(0, 99999);
                              navigator.clipboard.writeText(copyText.value);
                              
                              var custom_tooltip = document.getElementById("mycustom_tooltip");
                              custom_tooltip.innerHTML = "Copied: " + copyText.value;
                            }

                            function outFunc() {
                              var custom_tooltip = document.getElementById("mycustom_tooltip");
                              custom_tooltip.innerHTML = "Copy to clipboard";
                            }
                        </script>
