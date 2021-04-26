<?php

namespace App\Models;

use App\Observers\SalesStageObserver;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 * @property int $position
 * @property int $sales_funnel_id
 */
class SalesStage extends CrmModel
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'position',
        'sales_funnel_id'
    ];

    public function contacts()
    {
        return $this->belongsToMany(Contact::class, 'contact_stage');
    }

    protected static function boot()
    {
        parent::boot();
        self::observe(SalesStageObserver::class);
    }
}
