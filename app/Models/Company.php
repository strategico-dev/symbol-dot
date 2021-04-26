<?php

namespace App\Models;

use App\Traits\ElasticSearchable;
use App\Observers\ElasticObserver;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $user_id
 * @property mixed $companyDetail
 */
class Company extends CrmModel
{
    use SoftDeletes, ElasticSearchable;

    protected $fillable = [
        'name',
        'description',
        'user_id',
        'company_detail_id'
    ];

    public function companyDetail()
    {
        return $this->belongsTo(CompanyDetail::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    protected static function boot()
    {
        parent::boot();

        self::observe(ElasticObserver::class);
    }
}
