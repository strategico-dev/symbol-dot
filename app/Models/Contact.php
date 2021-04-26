<?php

namespace App\Models;

use App\Traits\ElasticSearchable;
use App\Observers\ContactObserver;
use App\Observers\ElasticObserver;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $user_id
 */
class Contact extends CrmModel
{
    use SoftDeletes, ElasticSearchable;

    const LIMIT = 10;

    protected $fillable = [
        'first_name',
        'surname',
        'middle_name',
        'email',
        'phone',
        'description'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    protected static function boot()
    {
        parent::boot();
        self::observe(ContactObserver::class);
        self::observe(ElasticObserver::class);
    }
}
