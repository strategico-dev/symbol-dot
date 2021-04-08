<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Company;
use App\Models\Contact;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    #Route::get('/api/v1/companies/{company}/employees')
    public function index(Company $company, Request $request)
    {
        $this->authorize('show', $company);
        return $company->employees()->with('contact')->fetch();
    }

    #Route::get('/api/v1/companies/{company}/employees')
    public function store(Company $company, Request $request)
    {
        $this->authorize('update', $company);

        $contact = Contact::findOrFail($request->input('contact_id'));
        $this->authorize('update', $contact);

        return Employee::add($company, $contact, $request->input());
    }

    #Route::delete('/api/v1/companies/{company}/employees/{employee}')
    public function delete(Company $company, Employee $employee)
    {
        if($company->id !== $employee->company_id)
        {
            return response()->json([
                'message' => 'Not Found'
            ], 404);
        }

        $employee->delete();
        return $company;
    }
}
