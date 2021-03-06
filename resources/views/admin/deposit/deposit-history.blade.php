 @extends('layouts.admin-master')
@section('title', 'Deposit History')
@section('css')
<style type="text/css">
.progress{background-color: #dddedf;}
.clockdiv{ display: inline-flex; margin: 0 auto; text-align: center; align-items: center;}
.count_d {position: relative;width: 28px;padding: 0;overflow: hidden;color: #46b700;}
.count_d:before{ content: '';  position: absolute;top: 0;left: 0;width: 100%;height: 50%;}
.count_d span { text-align: center; font-size: 14px; font-weight: 800;}
.count_d h2 { display: block; text-align: center; font-size: 8px; font-weight: 800; margin: 0;}
.work_screenshot label{font-size: 12px;margin-bottom: 5px;}
    .details{padding: 10px;}
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
                        <h4 class="text-themecolor">Deposit History</h4>
                    </div>
                  
                </div>
                <div class="row">
                    
                     <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="config-table" class="table table-hover table-bdeposited table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>User</th>
                                                <th>Amount</th>
                                                <th>Commission</th>
                                                <th>Pay Method</th>
                                                <th>Pay Details</th>
                                                <th>Payment Status</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead> 
                                        <tbody>
                                            @if(count($deposits)>0)
                                            @foreach($deposits as $index => $deposit)
                                            <tr id="item{{$deposit->id}}">
                                                <td>{{$index+1}}</td>
                                                <td>{{Carbon\Carbon::parse($deposit->created_at)->format(Config::get('siteSetting.date_format'))}}</td>
                                                <td>{{$deposit->user->name}}</td>
                                                <td>{{Config::get('siteSetting.currency_symble').$deposit->amount}}</td>
                                                 <td>{{Config::get('siteSetting.currency_symble').$deposit->commission}}</td>
                                                <td>{{$deposit->payment_method}}</td>
                                                <td>{!! $deposit->payment_info .'<br>'. $deposit->tnx_id !!}</td>
                                                <td>
                                                 
                                                    <a href="javascript:void(0)" class="label btn-xs @if($deposit->payment_status == 'paid')  label-success @elseif($deposit->payment_status == 'received') label-info @else label-danger @endif">
                                                    
                                                    <span class="mytooltip tooltip-effect-2">
                                                    <div  onclick="depositPaymentPopup('{{ route("depositPaymentDetails", $deposit->id)}}')"   title="Deposit payment info" data-toggle="tooltip"  class="text-inverse p-r-10" >{{$deposit->payment_status}} </div>
                                                    </span>
                                                    </a>

                                                </td>
                                                <td>
                                                    <span style="cursor:pointer;" class="label @if($deposit->status == 'paid') label-success @elseif($deposit->status == 'reject') label-danger @else label-info @endif" title="deposit Status (pending, active, reject)" 
                                                     > {{$deposit->status}}</span>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr style="text-align: center;"><td colspan="8">deposit not found.!</td></tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                 {{$deposits->appends(request()->query())->links()}}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
       <div class="modal bs-example-modal-lg" id="depositPaymentModal" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Update payment info.</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">??</button>
                </div>
                @if(Session::has('error'))
                    <div class="alert alert-danger">
                      {{Session::get('error')}}
                    </div>
                @endif
                <div class="modal-body" id="depositPaymentDetails"></div> 
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection

@section('js')
<script type="text/javascript">
    
    function depositPaymentPopup(link){
            $('#depositPaymentModal').modal('show');
            $('#depositPaymentDetails').html('<div class="loadingData"></div>');
            $.ajax({
                url:link,
                method:"get",
                success:function(data){
                    $('#depositPaymentDetails').html(data);
                }
            });
        }
</script>
@endsection
