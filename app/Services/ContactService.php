<?php


namespace App\Services;

use App\Models\User;
use App\Models\Contact;

class ContactService
{
    /**
     * @param User $user
     * @return mixed
     */
    public static function getWithPagination(User $user)
    {
        return $user->contacts()->fetch();
    }

    /**
     * @param User $owner
     * @param array $data
     * @return mixed
     */
    public static function create(User $owner, array $data)
    {
        return $owner->contacts()->save(new Contact($data));
    }

    /**
     * @param $contactId
     * @return mixed
     */
    public static function findById($contactId)
    {
        return Contact::findOrFail($contactId);
    }
}
