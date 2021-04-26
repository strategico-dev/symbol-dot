<?php

namespace App\Observers;

use App\Models\SalesStage;

class SalesStageObserver
{
    public function created(SalesStage $salesStage)
    {
        $lastPosition = SalesStage::query()->where('sales_funnel_id', $salesStage->sales_funnel_id)->
                                             max('position');

        if($lastPosition !== null)
        {
            $salesStage->position = $lastPosition + 1;
            $salesStage->save();
        }
    }
}
