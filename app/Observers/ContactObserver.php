<?php

namespace App\Observers;

use App\Models\Contact;
use App\Mail\CreatedContact;
use Illuminate\Support\Facades\Mail;

class ContactObserver
{
    public function created(Contact $contact)
    {
        Mail::to(auth()->user())->queue(new CreatedContact($contact));
    }
}
