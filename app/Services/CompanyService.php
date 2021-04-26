<?php


namespace App\Services;


use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Arr;
use App\Models\CompanyDetail;
use Illuminate\Support\Facades\DB;

class CompanyService
{
    /**
     * @param User $user
     * @return mixed
     */
    public static function getWithPagination(User $user)
    {
        return $user->companies()->with(['companyDetail', 'employees.contact'])->fetch();
    }

    /**
     * @param User $owner
     * @param array $companyData
     * @param array|null $details
     * @return mixed
     */
    public static function create(User $owner, array $companyData, ?array $details = null)
    {
        return DB::transaction(function () use ($owner, $companyData, $details) {
            /* @var Company $createdCompany */
            $createdCompany = $owner->companies()->create($companyData);

            if(!is_null($details))
            {
                $details = CompanyDetail::query()->create($details);
                $createdCompany->companyDetail()->associate($details);
                $createdCompany->save();
            }

            return $createdCompany;
        });
    }

    /**
     * @param int $companyId
     * @return mixed
     */
    public static function findById(int $companyId)
    {
        return Company::with(['companyDetail', 'employees.contact'])->findOrFail($companyId);
    }

    public static function update(Company $company, array $updatableData, ?array $details = null)
    {
        return DB::transaction(function () use ($company, $updatableData, $details) {
            $company->update(Arr::only($updatableData, ['name', 'description']));

            if(!is_null($details))
            {
                $company->companyDetail()->update($details);
            }

            return $company;
        });
    }
}
