<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    #Route::get('/api/v1/searcher/contacts')
    public function contacts(Request $request)
    {
        return Contact::search(
            $request->input('query'),
            $request->input('fields')
        );
    }
}
