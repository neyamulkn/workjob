 @extends('layouts.frontend')
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
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Deposit</a></li>
                                <li class="breadcrumb-item active">lists</li>
                            </ol>
                            <a href="{{route('depositBalance')}}" class="btn btn-sm btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Deposit Balance</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    
                     <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="config-table" class="table table-hover table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Amount</th>
                                                <th>Pay Method</th>
                                                <th>Pay Details</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead> 
                                        <tbody>
                                            @if(count($deposits)>0)
                                            @foreach($deposits as $index => $deposit)
                                            <tr id="item{{$deposit->id}}">
                                                <td>{{$index+1}}</td>
                                                <td>{{Carbon\Carbon::parse($deposit->created_at)->format(Config::get('siteSetting.date_format'))}}</td>
                                                <td>{{Config::get('siteSetting.currency_symble').$deposit->amount}}</td>
                                                <td>{{$deposit->payment_method}}</td>
                                                <td>{!! $deposit->payment_info .'<br>'. $deposit->tnx_id !!}</td>
                                               
                                                <td>
                                                    <span style="cursor:pointer;" class="label @if($deposit->status == 'accepted') label-success @elseif($deposit->status == 'reject') label-danger @else label-info @endif" title="deposit Status (pending, active, reject)" 
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
       
@endsection
