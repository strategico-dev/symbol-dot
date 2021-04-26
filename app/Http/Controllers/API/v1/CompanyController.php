<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Company;
use App\Services\CompanyService;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;

class CompanyController extends Controller
{
    #Route::get('/api/v1/companies')
    public function index()
    {
        return CompanyService::getWithPagination($this->getAuthorizedUser());
    }

    #Route::post('/api/v1/companies')
    public function store(CreateCompanyRequest $request)
    {
        return CompanyService::create(
            $this->getAuthorizedUser(),
            $request->input(),
            $request->input('details')
        );
    }

    #Route::get('/api/v1/companies/{companyId}')
    public function show($companyId)
    {
        $company = CompanyService::findById($companyId);
        $this->authorize('show', $company);

        return $company;
    }

    #Route::put('/api/v1/companies/{company}')
    public function update(Company $company, UpdateCompanyRequest $request)
    {
        $this->authorize('update', $company);

        return CompanyService::update(
            $company,
            $request->input(),
            $request->input('details')
        );
    }

    #Route::delete('/api/v1/companies/{company}')
    public function delete(Company $company)
    {
        $this->authorize('delete', $company);

        $company->delete();
        return $company;
    }
}
