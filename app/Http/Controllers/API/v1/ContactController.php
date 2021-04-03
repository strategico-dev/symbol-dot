<?php

namespace App\Http\Controllers\API\v1;

use App\Models\User;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Mail\CreatedContact;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateContactRequest;
use App\Http\Requests\UpdateContactRequest;

class ContactController extends Controller
{
    #Route::get('/api/v1/contacts')
    public function index(Request $request)
    {
        $user = User::find(auth()->id());
        return $user->contacts()->fetch();
    }

    #Route::post('/api/v1/contacts')
    public function store(CreateContactRequest $request)
    {
        $user = User::find(auth()->id());
        return $user->contacts()->save(new Contact($request->input()));
    }

    #Route::get('/api/v1/orders/{contactId}')
    public function show($contactId)
    {
        $contact = Contact::findOrFail($contactId);
        $this->authorize('show', $contact);

        return $contact;
    }

    #Route::put('/api/v1/orders/{contact}')
    public function update(Contact $contact, UpdateContactRequest $request)
    {
        $this->authorize('update', $contact);

        $contact->update($request->input());
        return $contact;
    }

    #Route::delete('/api/v1/orders/{contact}')
    public function delete(Contact $contact)
    {
        $contact->delete();
        return $contact;
    }
}
