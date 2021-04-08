<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $user_id
 */
class SalesFunnel extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'user_id',
        'cover',
        'background_image'
    ];

    public function salesStages()
    {
        return $this->hasMany(SalesStage::class);
    }
}
