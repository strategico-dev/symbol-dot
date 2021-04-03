<?php

namespace App\Models;

class CompanyDetail extends Model
{
    protected $fillable = [
        'ogrn',
        'inn',
        'kpp',
        'address',
        'authorized_capital'
    ];
}
