<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketBuy;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Auth;
use App\Traits\CreateSlug;
class TicketController extends Controller
{
    
    use CreateSlug;

    public function allTickets(){
        $tickets = Ticket::orderBy('id', 'desc')->paginate(25);
        return view('admin.ticket.ticket-list')->with(compact('tickets'));
    }

    public function ticketStore(Request $request){
        $ticket = new Ticket();
        $ticket->title = $request->title;
        $ticket->ticket_price = $request->ticket_price;
        $ticket->details = $request->ticket_details;
        $ticket->start_date = $request->start_date;
        $ticket->end_date = $request->end_date;
        $ticket->end_date = $request->end_date;
        $ticket->status = ($request->status) ? 1 : 0;

        //if feature image set
        if ($request->hasFile('banner')) {
            $image = $request->file('banner');
            $new_image_name = $this->uniqueImagePath('tickets', 'banner', $image->getClientOriginalName());
            $image->move(public_path('upload/images/ticket/'), $new_image_name);
            $ticket->banner = $new_image_name;
        }

        $store = $ticket->save();
        if($store) {
            Toastr::success('Ticket created successfully.');
        }else{
            Toastr::error('Ticket can\'t created.');
        }
        return back();
    }


    public function ticketEdit($id)
    {
        $ticket = Ticket::where('id', $id)->first();
        return view('admin.ticket.ticket-edit')->with(compact('ticket'));
    }

    public function ticketUpdate(Request $request){
        $ticket = Ticket::where('id', $request->id)->first();
        $ticket->title = $request->title;
        $ticket->ticket_price = $request->ticket_price;
        $ticket->details = $request->ticket_details;
        $ticket->start_date = $request->start_date;
        $ticket->end_date = $request->end_date;
        $ticket->end_date = $request->end_date;
        $ticket->status = ($request->status) ? 1 : 0;

        //if feature image set
        if ($request->hasFile('banner')) {
            $image = $request->file('banner');
            $new_image_name = $this->uniqueImagePath('tickets', 'banner', $image->getClientOriginalName());
            $image->move(public_path('upload/images/ticket/'), $new_image_name);
            $ticket->banner = $new_image_name;
        }

        $store = $ticket->save();
        if($store) {
            Toastr::success('Ticket update successfully.');
        }else{
            Toastr::error('Ticket update failed.');
        }
        return back();
    }

    public function ticketDelete($id){
        $ticket = Ticket::find($id);

        if($ticket){
            $image_path = public_path('upload/images/ticket/'. $ticket->banner);
            if(file_exists($image_path) && $ticket->banner){
                unlink($image_path);
            }
            $ticket->delete();

            $output = [
                'status' => true,
                'msg' => 'Ticket deleted successfully.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Ticket cannot deleted.'
            ];
        }
        return response()->json($output);
    }

    public function saleTickets(){
        $data['saleTickets'] = TicketBuy::with('user')->orderBy('id', 'desc')->paginate(25);
        return view('admin.ticket.ticket-sales')->with($data);
    }

    public function myTicket(){
        $user_id = Auth::id();
        $data['ticket'] = Ticket::orderBy('id', 'desc')->first();
        $data['seasonTickets'] = TicketBuy::where('ticket_id', $data['ticket']->id)->where('user_id', $user_id)->count();
        $data['myAllTicket'] = TicketBuy::where('user_id', $user_id)->count();
        $data['topTickets'] = TicketBuy::with('user')->where('ticket_id', $data['ticket']->id)->orderBy('tickets', 'desc')->take(10)->get();
        $data['recentTickets'] = TicketBuy::with('user')->where('ticket_id', $data['ticket']->id)->orderBy('id', 'desc')->take(10)->get();
        return view('users.ticket.ticket')->with($data);
    }

  
    public function buyTicket(Request $request)
    {
        $ticket = Ticket::where('id', $request->id)->whereDate('start_date', '<=', Carbon::now())->whereDate('end_date', '>=', Carbon::now())->first();

        if($ticket){
            $user_id = Auth::id();
            $buyTicket = new TicketBuy();
            $buyTicket->user_id = $user_id;
            $buyTicket->ticket_id = $ticket->id;
            $buyTicket->tickets = $request->ticket;
            $buyTicket->price = $ticket->ticket_price;
            $buyTicket->balance_type = $request->balance_type;
            $buyTicket->status = 1;
            $store = $buyTicket->save();
            if($store) {
                Toastr::success('Ticket buy successfully.');
            }else{
                Toastr::error('Ticket buy failed.');
            }
            return back();
        }

    }

}
