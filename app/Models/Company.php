<?php

namespace App\Models;

use App\Traits\ElasticSearchable;
use App\Observers\ElasticObserver;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $user_id
 * @property mixed $companyDetail
 */
class Company extends Model
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

    public static function create($companyAttributes, $detailAttributes = null)
    {
        $companyAttributes['user_id'] = auth()->id();
        return DB::transaction(function () use ($companyAttributes, $detailAttributes) {
            $createdCompany = (new static)->newQuery()->create($companyAttributes);

            if($detailAttributes)
            {
                $companyDetail = CompanyDetail::create($detailAttributes);

                $createdCompany->companyDetail()->associate($companyDetail);
                $createdCompany->save();
            }

            return $createdCompany;
        });
    }

    protected static function boot()
    {
        parent::boot();

        self::observe(ElasticObserver::class);
    }
}
