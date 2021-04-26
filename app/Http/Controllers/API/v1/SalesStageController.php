<?php

namespace App\Http\Controllers\API\v1;

use App\Models\SalesFunnel;
use Illuminate\Http\Request;
use App\Services\SalesStageService;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSalesStageRequest;

class SalesStageController extends Controller
{
    #Route::get('/api/v1/sales-funnels/{sales-funnel}/sales-stages')
    public function index(SalesFunnel $salesFunnel)
    {
        $this->authorize('show', $salesFunnel);

        return SalesStageService::getWithPagination($salesFunnel);
    }

    #Route::post('/api/v1/sales-funnels/{sales-funnel}/sales-stages')
    public function store(SalesFunnel $salesFunnel, CreateSalesStageRequest $request)
    {
        $this->authorize('update', $salesFunnel);

        return SalesStageService::create($salesFunnel, $request->input());
    }

    #Route::post('/api/v1/sales-funnels/{sales-funnel}/sales-stages/swapper')
    public function swap(SalesFunnel $salesFunnel, Request $request)
    {
        $this->authorize('update', $salesFunnel);

        SalesStageService::swapPositions(
            $salesFunnel,
            $request->input('current_stage_id'),
            $request->input('target_stage_id')
        );

        return response()->json([
            'message' => 'swapped'
        ]);
    }

    #Route::post('/api/v1/sales-funnels/{sales-funnel}/sales-stages/{salesStageId}')
    public function delete(SalesFunnel $salesFunnel, $salesStageId)
    {
        $this->authorize('delete', $salesFunnel);

        return SalesStageService::delete($salesFunnel, $salesStageId);
    }
}
