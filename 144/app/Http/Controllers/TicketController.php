<?php

namespace App\Http\Controllers;

use App\Libs\LUrl;
use App\Mail\Ticket;
use App\Mail\TicketFeedback;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TicketController extends Controller
{
    public function ticket()
    {
        return view('pages.tickets');
    }

    public function ticketPost(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required',
        ]);

        Mail::send(new Ticket($request->email, $request->name, $request->phone, $request->message));
        Mail::send(new TicketFeedback($request->email, $request->name, $request->phone, $request->message));

        flash()->success(trans('pages/tickets.ticket_sent'));

        return redirect()->route(LUrl::name('ticket'));
    }
}
