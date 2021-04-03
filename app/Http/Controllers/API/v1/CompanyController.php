<?php

namespace App\Http\Controllers\API\v1;

use App\Models\User;
use App\Models\Company;
use App\Models\CompanyDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;

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
    public function store(CreateCompanyRequest $request)
    {
        return Company::create(
            $request->input(),
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

    #Route::put('/api/v1/companies/{company}')
    public function update(Company $company, UpdateCompanyRequest $request)
    {
        $this->authorize('update', $company);

        $company->update($request->only(['name', 'description']));
        if($request->exists('detail'))
        {
            if(!$company->companyDetail)
            {
                DB::transaction(function () use ($company) {
                    $companyDetail = CompanyDetail::create($request->input('detail'));
                    $company->companyDetail()->associate($companyDetail);
                    $company->save();
                });
            }
            else
            {
                $company->companyDetail()->update($request->input('detail'));
            }
        }

        return $company;
    }

    #Route::delete('/api/v1/companies/{company}')
    public function delete(Company $company)
    {
        $this->authorize('delete', $company);

        $company->delete();
        return $company;
    }
}
