<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactSearchRequest;
use App\Http\Requests\CompanySearchRequest;

class SearchController extends Controller
{
    #Route::get('/api/v1/searcher/contacts')
    public function contacts(ContactSearchRequest $request)
    {
        return Contact::search(
            $request->input('query'),
            $request->input('fields')
        );
    }

    #Route::get('/api/v1/searcher/companies')
    public function companies(CompanySearchRequest $request)
    {
        return Contact::search(
            $request->input('query'),
            $request->input('fields')
        );
    }
}
