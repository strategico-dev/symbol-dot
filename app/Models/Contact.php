<?php

namespace App\Models;

use App\Observers\ContactObserver;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $user_id
 */
class Contact extends Model
{
    use SoftDeletes;

    const LIMIT = 10;

    protected $fillable = [
        'first_name',
        'surname',
        'middle_name',
        'email',
        'phone',
        'description'
    ];

    public function contactPermissions()
    {
        return $this->hasMany(ContactPermission::class);
    }

    protected static function boot()
    {
        parent::boot();
        self::observe(ContactObserver::class);
    }
}
