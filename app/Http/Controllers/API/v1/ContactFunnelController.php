<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Contact;
use App\Models\SalesStage;
use App\Models\SalesFunnel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactFunnelController extends Controller
{
    #Route::post('/api/v1/sales-funnels/{salesFunnel}/contacts/{contact}')
    public function add(SalesFunnel $salesFunnel, Contact $contact, Request $request)
    {
        $stageId = $request->input('stage_id');
        /* @var SalesStage $salesStage */
        $salesStage = $salesFunnel->salesStages()->findOrFail($stageId);

        $salesStage->contacts()->attach($contact);

        return $contact;
    }

    #Route::put('/api/v1/sales-funnels/{salesFunnel}/contacts/{contact}')
    public function move(SalesFunnel $salesFunnel, Contact $contact, Request $request)
    {
        $currentStageId = $request->input('current_stage_id');
        $targetStageId = $request->input('target_stage_id');

        /* @var SalesStage $currentStage */
        $currentStage = $salesFunnel->salesStages()->findOrFail($currentStageId);
        /* @var SalesStage $targetStage */
        $targetStage = $salesFunnel->salesStages()->findOrFail($targetStageId);

        SalesStage::moveTo($currentStage, $targetStage, $contact);

        return response()->json(['message' => 'moved']);
    }

    #Route::delete('/api/v1/sales-funnels/{salesFunnel}/contacts/{contact}')
    public function delete(SalesFunnel $salesFunnel, Contact $contact, Request $request)
    {
        $stageId = $request->input('stage_id');
        /* @var SalesStage $salesStage */
        $salesStage = $salesFunnel->salesStages()->findOrFail($stageId);

        $salesStage->contacts()->detach($contact);

        return response()->json(['message' => 'Contact delete from a sales stage']);
    }
}
