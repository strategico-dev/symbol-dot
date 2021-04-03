<?php

namespace App\Http\Controllers\API\v1;

use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    #Route::get('/api/v1/companies')
    public function index()
    {
        /* @var User $user */
        $user = User::find(auth()->id());
        return $user->companies()->with(['companyDetail'])->fetch();
    }

    #Route::post('/api/v1/companies')
    public function store(Request $request)
    {
        return Company::create(
            $request->input('company'),
            $request->input('detail')
        );
    }

    #Route::get('/api/v1/companies/{companyId}')
    public function show($companyId)
    {
        $company = Company::with(['companyDetail'])->findOrFail($companyId);
        $this->authorize('show', $company);

        return $company;
    }
}
