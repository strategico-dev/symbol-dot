<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Company;

class CompanyPolicy
{
    /**
     * @param User $user
     * @param Company $company
     * @return bool
     */
    public function show(User $user, Company $company)
    {
        return $user->id === $company->user_id;
    }

    /**
     * @param User $user
     * @param Company $company
     * @return bool
     */
    public function update(User $user, Company $company)
    {
        return $user->id === $company->user_id;
    }

    /**
     * @param User $user
     * @param Company $company
     * @return bool
     */
    public function delete(User $user, Company $company)
    {
        return $user->id === $company->user_id;
    }
}
