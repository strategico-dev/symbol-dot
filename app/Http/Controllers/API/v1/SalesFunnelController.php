<?php

namespace App\Http\Controllers\API\v1;

use App\Models\User;
use App\Models\SalesFunnel;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSalesFunnelRequest;

class SalesFunnelController extends Controller
{
    #Route::get('/api/v1/sales-funnels')
    public function index()
    {
        /* @var User $user */
        $user = User::find(auth()->id());
        return $user->salesFunnels()->fetch();
    }

    #Route::post('/api/v1/sales-funnels')
    public function store(CreateSalesFunnelRequest $request)
    {
        /* @var User $user */
        $user = User::find(auth()->id());
        return $user->salesFunnels()->save(new SalesFunnel($request->input()));
    }

    #Route::get('/api/v1/sales-funnels/{salesFunnelId}')
    public function show($salesFunnelId)
    {
        $salesFunnel = SalesFunnel::with(['salesStages'])->
                                    findOrFail($salesFunnelId);

        $this->authorize('show', $salesFunnel);

        return $salesFunnel;
    }

    #Route::delete('/api/v1/sales-funnels/{salesFunnel}')
    public function delete(SalesFunnel $salesFunnel)
    {
        $this->authorize('delete', $salesFunnel);

        $salesFunnel->delete();
        return $salesFunnel;
    }
}
