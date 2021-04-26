<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Contact;
use App\Models\SalesFunnel;
use Illuminate\Http\Request;
use App\Services\SalesStageService;
use App\Http\Controllers\Controller;

class ContactFunnelController extends Controller
{
    #Route::post('/api/v1/sales-funnels/{salesFunnel}/contacts/{contact}')
    public function store(SalesFunnel $salesFunnel, Contact $contact, Request $request)
    {
        return SalesStageService::addContact(
            $salesFunnel,
            $contact,
            $stageId = $request->input('stage_id')
        );
    }

    #Route::put('/api/v1/sales-funnels/{salesFunnel}/contacts/{contact}')
    public function move(SalesFunnel $salesFunnel, Contact $contact, Request $request)
    {
        SalesStageService::changeSalesStage(
            $salesFunnel,
            $contact,
            $request->input('current_stage_id'),
            $request->input('target_stage_id')
        );

        return response()->json(['message' => 'moved']);
    }

    #Route::delete('/api/v1/sales-funnels/{salesFunnel}/contacts/{contact}')
    public function delete(SalesFunnel $salesFunnel, Contact $contact, Request $request)
    {
        SalesStageService::deleteContact(
            $salesFunnel,
            $contact,
            $request->input('stage_id')
        );

        return response()->json(['message' => 'Contact delete from a sales stage']);
    }
}
