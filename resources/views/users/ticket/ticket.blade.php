@extends('layouts.frontend')
@section('title', 'Ticket')
@section('css')
    <link href="{{asset('assets')}}/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets')}}/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .clockdiv{margin-bottom: 0px;}
        .count{ display: inline-flex; margin: 0 auto; text-align: center; align-items: center;}
        .count_d {position: relative;padding: 0px 4px 0px;margin: 0px 3px;border-radius: 5px;background: #226c04;overflow: hidden;}
        .count_d:before{ content: '';  position: absolute;top: 0;left: 0;width: 100%;height: 50%;}
        .count_d span { display: block; text-align: center; font-size: 35px;line-height: 40px; font-weight: 800;color: #fff;}
        .count_d h2 { display: block; text-align: center;color: #fff;  text-transform: uppercase; font-size: 15px; margin: 0;}
    </style>
@endsection
@section('content')
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid" style="text-align:center;">
                
                 <div class="row">
                    <!-- Column -->
                    <div class="col-md-12">
                        <marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();" style="padding:8px 0;font-size: 15px;background: #226c04;color: #fff;">{!! $ticket->details !!}</marquee>
                    </div>
                    <div class="col-md-12">
                        
                        <div class="head  clockdiv" style="margin: 10px 0;" data-date="{{Carbon\Carbon::parse($ticket->end_date)}}">
                            <div class="count">
                              <div class="count_d" >
                                <span class="days">00</span>
                                <h2>Days</h2>
                              </div>
                              <div class="count_d" >
                                <span class="hours">00</span>
                                <h2>HOURS</h2>
                              </div>
                              <div class="count_d" >
                                <span class="minutes">00</span>
                                <h2>MINUTES</h2>
                              </div>
                              <div class="count_d" >
                                <span class="seconds">00</span>
                                <h2>SECONDS</h2>
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="card">
                            <div data-toggle="modal" title="Buy Ticket" style="height: 123px;cursor: pointer;" data-target="#add" class="ext-center">
                                <img style="width: 100%;height: 100%;" src="{{asset('upload/images/ticket')}}/{{($ticket && $ticket->banner) ? $ticket->banner : 'defualt.png'}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Tickets </h5>
                                <div class="d-flex no-block align-items-center">
                                    <h6 class="">This Season</h6>
                                    <a href="#" class="link display-5 ml-auto">{{$seasonTickets}}</a>,
                                    <h6 class="">All Time</h6>
                                    <a href="#" class="link display-5 ml-auto">{{$myAllTicket}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">TOP 10</h5>
                                <div class="table-responsive">
                                    <table class="table product-overview">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>User</th>
                                                <th>Ticket Buy</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($topTickets as $index => $topTicket)
                                            <tr>
                                                <td>{{$index+1}}</td>
                                                <td>{{$topTicket->user->name}}</td>
                                                <td>{{$topTicket->tickets}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Recent Buy</h5>
                                <div class="table-responsive ">
                                    <table class="table product-overview">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>User</th>
                                                <th>Ticket Buy</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentTickets as $index => $recentTicket)
                                            <tr>
                                                <td>{{$index+1}}</td>
                                                <td>{{$recentTicket->user->name}}</td>
                                                <td>{{$recentTicket->tickets}}</td>
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
        
        <!-- add Modal -->
        <div class="modal fade" id="add">
            <div class="modal-dialog modal-sm">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Buy Ticket</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row">
                        <div class="card-body">
                            @if($ticket && $ticket->end_date> now())
                            <form action="{{route('buyTicket')}}" method="POST" >
                                {{csrf_field()}}
                                <input type="hidden" name="id" value="{{$ticket->id}}">
                                <div class="form-body">
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h4>Per Ticket: {{ config('siteSetting.currency_symble'). $ticket->ticket_price}}</h4>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                            <label>Select Balance Type</label>
                                            <select class="form-control" name="balance_type">
                                               <option value="earning_balance">Earning Balance</option>
                                               <option value="deposit_balance">Deposit Balance</option>
                                               </select> 
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                           <div class="form-group"> <label for="ticket">Number Of Ticket</label>  <input type="number" value="1" name="ticket" min="1" id="ticket" class="form-control" > </div>
                                        </div>
                                    </div>

                                    <div class="row justify-content-md-center">
                                        <div class="col-md-12">
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-block btn-dribbble" id="submitBkash">Buy Ticket</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            @else
                            <h4>Ticket time expired</h4>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

  
@endsection
@section('js')
    <!-- This is data table -->
    <script src="{{asset('assets')}}/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
    <script src="{{asset('assets')}}/node_modules/dropify/dist/js/dropify.min.js"></script>
        <script type="text/javascript">
        document.addEventListener('readystatechange', event => {
        if (event.target.readyState === "complete") {
            var clockdiv = document.getElementsByClassName("clockdiv");
            var countDownDate = new Array();
            for (var i = 0; i < clockdiv.length; i++) {
                countDownDate[i] = new Array();
                countDownDate[i]['el'] = clockdiv[i];
                countDownDate[i]['time'] = new Date(clockdiv[i].getAttribute('data-date')).getTime();
                countDownDate[i]['days'] = 0;
                countDownDate[i]['hours'] = 0;
                countDownDate[i]['seconds'] = 0;
                countDownDate[i]['minutes'] = 0;
            }
          
            var countdownfunction = setInterval(function() {
                for (var i = 0; i < countDownDate.length; i++) {
                    var now = new Date().getTime();
                    var distance = countDownDate[i]['time'] - now;
                     countDownDate[i]['days'] = Math.floor(distance / (1000 * 60 * 60 * 24));
                     countDownDate[i]['hours'] = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                     countDownDate[i]['minutes'] = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                     countDownDate[i]['seconds'] = Math.floor((distance % (1000 * 60)) / 1000);
                    
                     if (distance < 0) {
                        countDownDate[i]['el'].querySelector('.days').innerHTML = 0;
                        countDownDate[i]['el'].querySelector('.hours').innerHTML = 0;
                        countDownDate[i]['el'].querySelector('.minutes').innerHTML = 0;
                        countDownDate[i]['el'].querySelector('.seconds').innerHTML = 0;
                     }else{
                        countDownDate[i]['el'].querySelector('.days').innerHTML = countDownDate[i]['days'];
                        countDownDate[i]['el'].querySelector('.hours').innerHTML = countDownDate[i]['hours'];
                        countDownDate[i]['el'].querySelector('.minutes').innerHTML = countDownDate[i]['minutes'];
                        countDownDate[i]['el'].querySelector('.seconds').innerHTML = countDownDate[i]['seconds'];
                    }
                }
            }, 1000);
        }
    });

    </script>
   
@endsection
