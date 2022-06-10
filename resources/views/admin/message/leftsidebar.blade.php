<div class="card-body inbox-panel"><a href="{{route('adminMessageWrite')}}" class="btn btn-danger m-b-20 p-10 btn-block waves-effect waves-light">Write New Message</a>
    <ul class="list-group list-group-full">
        <!-- <li class="list-group-item @if(Request::segment(3)  == 'inbox') active @endif"> <a href="{{route('adminMessage', 'inbox')}}"><i class="mdi mdi-gmail"></i> Inbox <span class="badge badge-success ml-auto">0</a></span>
        </li> -->
        <li class="list-group-item @if(Request::segment(3)  == 'all') active @endif">
            <a href="{{route('adminMessage')}}"> <i class="mdi mdi-label"></i> Message list</a>
        </li>
        <li class="list-group-item @if(Request::segment(3) == 'draft') active @endif" >
            <a  href="{{route('adminMessage', 'draft')}}"> <i class="mdi mdi-send"></i> Draft </a></li>
       
        
    </ul>
</div>