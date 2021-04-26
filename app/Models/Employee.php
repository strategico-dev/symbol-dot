<?php

namespace App\Models;

/**
 * @property int $company_id
 */
class Employee extends CrmModel
{
    protected $fillable = [
        'company_id',
        'contact_id',
        'name',
        'description'
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
