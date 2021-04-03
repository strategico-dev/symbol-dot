<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $user_id
 */
class Company extends Model
{
    use SoftDeletes;

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

    public static function create($companyAttributes, $detailAttributes = null)
    {
        $companyAttributes['user_id'] = auth()->id();
        return DB::transaction(function () use ($companyAttributes, $detailAttributes) {
            $createdCompany = (new static)->newQuery()->create($companyAttributes);

            if($detailAttributes)
            {
                $companyDetail = new CompanyDetail($detailAttributes);
                $companyDetail->save();

                $createdCompany->companyDetail()->associate($companyDetail);
                $createdCompany->save();
            }

            return $createdCompany;
        });
    }
}
