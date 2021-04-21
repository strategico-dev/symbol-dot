<?php

namespace App\Models;

use App\Observers\SalesStageObserver;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 * @property int $order
 * @property int $sales_funnel_id
 */
class SalesStage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'order',
        'sales_funnel_id'
    ];

    public function contacts()
    {
        return $this->belongsToMany(Contact::class, 'contact_stage');
    }

    /**
     * @param SalesStage $place
     * @param SalesStage $target
     */
    private static function swapOrder(SalesStage $place, SalesStage $target)
    {
        $placeOrder = $place->order;
        $place->order = $target->order;
        $target->order = $placeOrder;

        DB::transaction(function () use ($place, $target) {
            $place->save();
            $target->save();
        });
    }

    #TODO: Refactoring
    /**
     * @param SalesFunnel $salesFunnel
     * @param array $swappable
     */
    public static function swapOrders(SalesFunnel $salesFunnel, array $swappable)
    {
        foreach($swappable as $placeId => $targetId)
        {
            /* @var SalesStage $place */
            $place = self::where('sales_funnel_id', $salesFunnel->id)->findOrFail($placeId);
            /* @var SalesStage $target */
            $target = self::where('sales_funnel_id', $salesFunnel->id)->findOrFail($targetId);

            self::swapOrder($place, $target);
        }
    }

    /**
     * Move a contact to a new sales stage
     *
     * @param SalesStage $current
     * @param SalesStage $target
     * @param Contact $contact
     */
    public static function moveTo(SalesStage $current, SalesStage $target, Contact $contact)
    {
        DB::transaction(function () use ($current, $target, $contact) {
            $current->contacts()->detach($contact);
            $target->contacts()->attach($contact);
        });
    }

    protected static function boot()
    {
        parent::boot();
        self::observe(SalesStageObserver::class);
    }
}
