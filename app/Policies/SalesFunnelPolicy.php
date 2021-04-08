<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SalesFunnel;

class SalesFunnelPolicy
{
    /**
     * @param User $user
     * @param SalesFunnel $salesFunnel
     * @return bool
     */
    public function show(User $user, SalesFunnel $salesFunnel)
    {
        return $user->id === $salesFunnel->user_id;
    }

    /**
     * @param User $user
     * @param SalesFunnel $salesFunnel
     * @return bool
     */
    public function update(User $user, SalesFunnel $salesFunnel)
    {
        return $user->id === $salesFunnel->user_id;
    }

    /**
     * @param User $user
     * @param SalesFunnel $salesFunnel
     * @return bool
     */
    public function delete(User $user, SalesFunnel $salesFunnel)
    {
        return $user->id === $salesFunnel->user_id;
    }
}
