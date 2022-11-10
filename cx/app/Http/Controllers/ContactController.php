<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Libs\LUrl;
use App\Mail\Contact;
use App\Mail\ContactCustomer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('pages.contact');
    }

    public function send(ContactRequest $request): RedirectResponse
    {
        // email contact data to RIEL
        Mail::send(new Contact($request->email, $request->name, $request->message));

        // email contact data to user
        Mail::send(new ContactCustomer($request->email, $request->name, $request->message));

        // redirect to contact
        flash()->success(trans('pages/contact.contact_success_message'));

        return redirect()->route(LUrl::name('contact'));
    }
}
