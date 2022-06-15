    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ asset('js/custom.min.js') }}"></script>
  
    @yield('js')
    @yield('perpage-js')
    <script type="text/javascript">
        //change status by id
        function satusActiveDeactive(table, id, field = null){
            @if(env('MODE') == 'demo')
            toastr.error('Demo mode on edit/update not working');
            return false;
            @endif
            var  url = '{{route("statusChange")}}';
            $.ajax({
                url:url,
                method:"get",
                data:{table:table,field:field,id:id},
                success:function(data){
                    if(data.status){
                        toastr.success(data.message);
                    }else{
                        toastr.error(data.message);
                    }
                }
            });
        }
    </script>     

    <script type="text/javascript">
           function getNotification(type){
            $.ajax({
            url:'{{route("getNotifications")}}',
            type:'get',
            data:{type:type},
            success:function(data){
                if(data){
                    $('.'+type).html(data.notifications);
                }
            }
          });
        }
        function deleteConfirmPopup(route, item='') {
            $('#deleteModal').modal('show');
            document.getElementById('deleteItemRoute').value = route;
            //hide delete item
            document.getElementById('item').value = item;
        }

        function deleteItem(route) {
            @if(env('MODE') == 'demo')
            toastr.error('Demo mode on delete not working');
            return false;
            @endif
            //separate id from route
            var id = route.split("/").pop();
            var item = $('#item').val();
            $.ajax({
                url:route,
                method:"get",
                success:function(data){
                    if(data.status){
                        $("#item"+item+id).hide();
                        toastr.success(data.msg);
                    }else{
                        toastr.error(data.msg);
                    }
                }
            });
        }


    </script>    



    {!! Toastr::message() !!}
    <script>
        @if($errors->any())
            
            @if(Session::get('submitType'))
                // if occur error open model
                $("#{{Session::get('submitType')}}").modal('show');
                //open edit modal by id
                @if(Session::get('submitType')=='edit')
                    edit({{old('id')}});
                @endif
            @endif

            @foreach($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif
    </script>

