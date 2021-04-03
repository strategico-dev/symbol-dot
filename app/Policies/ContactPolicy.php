<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Contact;
use App\Models\ContactPermission;

class ContactPolicy
{
    /**
     * @param User $user
     * @param Contact $contact
     * @return bool
     */
    public function show(User $user, Contact $contact)
    {
        if($user->id === $contact->user_id || ContactPermission::isAdmin($user, $contact))
        {
            return true;
        }

        return ContactPermission::canRead($user, $contact);
    }

    /**
     * @param User $user
     * @param Contact $contact
     * @return bool
     */
    public function update(User $user, Contact $contact)
    {
        if($user->id === $contact->user_id || ContactPermission::isAdmin($user, $contact))
        {
            return true;
        }

        return ContactPermission::canWrite($user, $contact);
    }

    /**
     * @param User $user
     * @param Contact $contact
     * @return bool
     */
    public function delete(User $user, Contact $contact)
    {
        return $user->id === $contact->user_id || ContactPermission::isAdmin($user, $contact);
    }

    /**
     * @param User $user
     * @param Contact $contact
     * @return bool
     */
    public function changePermission(User $user, Contact $contact)
    {
        return $user->id === $contact->user_id || ContactPermission::isAdmin($user, $contact);
    }
}
