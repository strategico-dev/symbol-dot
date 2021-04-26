<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Contact;
use App\Services\CompanyService;
use App\Services\ContactService;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateContactRequest;
use App\Http\Requests\UpdateContactRequest;

class ContactController extends Controller
{
    #Route::get('/api/v1/contacts')
    public function index()
    {
        return ContactService::getWithPagination($this->getAuthorizedUser());
    }

    #Route::post('/api/v1/contacts')
    public function store(CreateContactRequest $request)
    {
        return ContactService::create(
            $this->getAuthorizedUser(),
            $request->input()
        );
    }

    #Route::get('/api/v1/orders/{contactId}')
    public function show($contactId)
    {
        $contact = ContactService::findById($contactId);
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
        $this->authorize('delete', $contact);

        $contact->delete();
        return $contact;
    }
}
