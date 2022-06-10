@extends('layouts.admin-master')
@section('title', 'Report list')
@section('css')
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css">

@endsection
@section('content')
                <!-- Page wrapper  -->
        <!-- ============================================================== -->
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
                        <h4 class="text-themecolor">Report Reason List</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Report </a></li>
                                <li class="breadcrumb-item active">list</li>
                            </ol>
                            
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Report By</th>
                                                <th>Report For</th>
                                                <th>Reason</th>
                                                <th>Reason Details</th>
                                                
                                            </tr>
                                        </thead> 
                                        <tbody id="positionSorting">
                                            @foreach($reports as $index => $report)
                                            <tr id="item{{$report->id}}">
                                                <td>{{ $index+1 }}</td>
                                                <td style="display: flex;">
                                                    <a href="{{route('userProfile', $report->user->username)}}" class="author-img active">
                                                    <img width="80" src="{{ asset('upload/users') }}/{{($report->user->photo) ? $report->user->photo : 'defualt.png'}}">
                                                    </a>
                                                    <p style="padding-left: 5px;">
                                                    {{$report->user->name}}<br/>
                                                    {{$report->user->mobile}}<br/>
                                                    {{\Carbon\Carbon::parse($report->created_at)->format(Config::get('siteSetting.date_format'))}}</p>
                                                </td>
                                                <td>
                                                    @if($report->product)
                                                    <a class="inbox-header-img" style="display: flex;" target="_blank" href="{{route('post_details',$report->product->slug )}}">
                                                        <img width="80" src="{{ asset('upload/images/product/thumb/'.$report->product->feature_image) }}" alt="avatar">
                                                        <p style="padding-left: 5px;">{{$report->product->title}}</p>
                                                    </a>
                                                    @endif
                                                    @if($report->seller)
                                                   
                                                    <a style="display:flex;" href="{{route('userProfile', $report->seller->username)}}" class="author-img active">
                                                    <img width="80" src="{{ asset('upload/users') }}/{{($report->seller->photo) ? $report->seller->photo : 'defualt.png'}}">

                                                     <p style="padding-left: 5px;">
                                                    {{$report->seller->name}}<br/>
                                                    {{$report->seller->mobile}}</p>
                                                    </a>
                                                    @endif
                                                </td>
                                                <td>{{$report->reason}}</td>
                                                <td>{{$report->reason_details}}</td>
                                                
                                                
                                               
                                            </tr>
                                            @endforeach
                                            <tr><td colspan="7">{{$reports->appends(request()->query())->links()}}</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->

            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>

@endsection
@section('js')
    <!-- This is data table -->
    <script src="{{asset('assets')}}/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('assets')}}/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
   <script>
        $(function () {
            $('#myTable').DataTable({"ordering": false});
        });

    </script>
@endsection
