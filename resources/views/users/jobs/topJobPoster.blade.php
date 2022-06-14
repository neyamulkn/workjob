@extends('layouts.frontend')
@section('title', 'Top 10 Job Poster')

@section('content')
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid" style="text-align:center;">
                
               
                <div class="row offset-md-2">

                    <!-- Column -->
                    <div class="col-md-10">
                        <marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();" style="padding:8px 0;font-size: 15px;background: #226c04;color: #fff;">{!! $ticket->details !!}</marquee>
                    </div>
                    <div class="col-md-10">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Top 10 Job Poster</h5>
                                <div class="table-responsive">
                                    <table class="table product-overview">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>User</th>
                                                <th>Post</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($users as $index => $user)
                                            <tr>
                                                <td>{{$index+1}}</td>
                                                <td>{{$user->name}}</td>
                                                <td>{{$user->jobs_count}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
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

