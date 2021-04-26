<?php


namespace App\Services;

use App\Models\User;
use App\Models\Contact;
use App\Models\SalesStage;
use App\Models\SalesFunnel;
use Illuminate\Support\Facades\DB;

class SalesFunnelService
{
    /**
     * @param User $user
     * @return mixed
     */
    public static function getWithPagination(User $user)
    {
        return $user->salesFunnels()->fetch();
    }

    /**
     * @param User $owner
     * @param array $data
     * @return mixed
     */
    public static function create(User $owner, array $data)
    {
        return $owner->contacts()->save(new Contact($data));
    }

    /**
     * @param $salesFunnelId
     * @return mixed
     */
    public static function findById($salesFunnelId)
    {
        return SalesFunnel::with(['salesStages'])->findOrFail($salesFunnelId);
    }
}
