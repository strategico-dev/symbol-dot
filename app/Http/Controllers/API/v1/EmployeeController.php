<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Company;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Services\EmployeeService;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    #Route::get('/api/v1/companies/{company}/employees')
    public function index(Company $company, Request $request)
    {
        $this->authorize('show', $company);
        return EmployeeService::getByCompany($company);
    }

    #Route::get('/api/v1/companies/{company}/employees')
    public function store(Company $company, Request $request)
    {
        $this->authorize('update', $company);

        $contact = Contact::findOrFail($request->input('contact_id'));
        $this->authorize('update', $contact);

        return EmployeeService::create($company, $contact, $request->input());
    }

    #Route::delete('/api/v1/companies/{company}/employees/{employee}')
    public function delete(Company $company, $employeeId)
    {
        return EmployeeService::delete($company, $employeeId);
    }
}
