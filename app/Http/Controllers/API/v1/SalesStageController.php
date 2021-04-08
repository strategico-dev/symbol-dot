<?php

namespace App\Http\Controllers\API\v1;

use App\Models\SalesStage;
use App\Models\SalesFunnel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSalesStageRequest;

class SalesStageController extends Controller
{
    #Route::get('/api/v1/sales-funnels/{sales-funnel}/sales-stages')
    public function index(SalesFunnel $salesFunnel)
    {
        $this->authorize('show', $salesFunnel);

        return $salesFunnel->salesStages()->
                             with('contacts')->
                             orderBy('order', 'ASC')->
                             get();
    }

    #Route::post('/api/v1/sales-funnels/{sales-funnel}/sales-stages')
    public function store(SalesFunnel $salesFunnel, CreateSalesStageRequest $request)
    {
        $this->authorize('update', $salesFunnel);

        return $salesFunnel->salesStages()->save(new SalesStage($request->input()));
    }

    #Route::post('/api/v1/sales-funnels/{sales-funnel}/sales-stages/swapper')
    /**
     * The parameters for the endpoint are an object
     * in which the key and values are elements for swap
     *
     * Example:
     *      swappable[1] = 2
     *      swappable[4] = 5
     * Swap stages with id 1 and 2, then with 4 and 5
     *
     * @param SalesFunnel $salesFunnel
     * @param Request $request
     * @return mixed
     */
    public function swap(SalesFunnel $salesFunnel, Request $request)
    {
        $swappable = $request->input('swappable');
        SalesStage::swapOrders($salesFunnel, $swappable);

        return response()->json([
            'message' => 'swapped'
        ]);
    }

    #Route::post('/api/v1/sales-funnels/{sales-funnel}/sales-stages/{salesStage}')
    public function delete(SalesFunnel $salesFunnel, SalesStage $salesStage)
    {
        if($salesFunnel->id !== $salesStage->sales_funnel_id)
        {
            return response()->json([
                'message' => 'Not Found'
            ], 404);
        }

        $salesStage->delete();
        return $salesStage;
    }
}
