<?php

namespace App\Models;

/**
 * @property int $company_id
 */
class Employee extends Model
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

    public static function add(Company $company, Contact $contact, array $data)
    {
        return (new static)->newQuery()->create([
            'company_id'    => $company->id,
            'contact_id'    => $contact->id,
            'name'          => $data['name'],
            'description'   => $data['description'] ?? null
        ]);
    }
}
