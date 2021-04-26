<?php

namespace App\Models;

class CompanyDetail extends CrmModel
{
    protected $fillable = [
        'ogrn',
        'inn',
        'kpp',
        'address',
        'authorized_capital'
    ];
}
