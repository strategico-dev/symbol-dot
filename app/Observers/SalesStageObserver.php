<?php

namespace App\Observers;

use App\Models\SalesStage;

class SalesStageObserver
{
    public function created(SalesStage $salesStage)
    {
        $maxOrder = SalesStage::query()->where('sales_funnel_id', $salesStage->sales_funnel_id)->
                                max('order');

        if($maxOrder !== null)
        {
            $salesStage->order = $maxOrder + 1;
            $salesStage->save();
        }
    }
}
