<?php

namespace App\Models;

/**
 * @property int $mode
 */
class ContactPermission extends CrmModel
{
    const READ_MODE = 0;
    const WRITE_MODE = 1;
    const ADMIN_MODE = 2;

    const MODES_NAMES = [
        self::READ_MODE  => 'Только чтение',
        self::WRITE_MODE => 'Только запись',
        self::ADMIN_MODE => 'Администратор'
    ];

    protected $fillable = [
        'user_id',
        'contact_id',
        'mode'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function getModeAttribute($value)
    {
        return self::MODES_NAMES[$value];
    }

    public function scopeInMode($query, $mode = null)
    {
        if(!is_null($mode))
        {
            $query->where('mode', $mode);;
        }
    }

    /**
     * @return int[]
     */
    public static function getModes()
    {
        return [self::READ_MODE, self::WRITE_MODE, self::ADMIN_MODE];
    }

    /**
     * @return string[]
     */
    public static function getModesWithNames()
    {
        return self::MODES_NAMES;
    }

    public static function search(User $user, Contact $contact, int $mode)
    {
        return self::where('user_id', $user->id)->
                     where('contact_id', $contact->id)->
                     where('mode', $mode)->
                     first();
    }

    /**
     * @param User $user
     * @param Contact $contact
     * @param int $mode
     * @return bool
     */
    public static function can(User $user, Contact $contact, int $mode)
    {
        return self::search($user, $contact, $mode) !== null;
    }

    /**
     * @param User $user
     * @param Contact $contact
     * @return bool
     */
    public static function canRead(User $user, Contact $contact)
    {
        return self::can($user, $contact, self::READ_MODE);
    }

    /**
     * @param User $user
     * @param Contact $contact
     * @return bool
     */
    public static function canWrite(User $user, Contact $contact)
    {
        return self::can($user, $contact, self::WRITE_MODE);
    }

    /**
     * @param User $user
     * @param Contact $contact
     * @return bool
     */
    public static function isAdmin(User $user, Contact $contact)
    {
        return self::can($user, $contact, self::ADMIN_MODE);
    }

    /**
     * @param User $user
     * @param Contact $contact
     * @param int $mode
     * @return mixed
     */
    public static function add(User $user, Contact $contact, int $mode)
    {
        return (new static)->newQuery()->create([
            'user_id'       => $user->id,
            'contact_id'    => $contact->id,
            'mode'          => $mode
        ]);
    }

    /**
     * @param User $user
     * @param Contact $contact
     * @param int $mode
     */
    public static function remove(User $user, Contact $contact, int $mode)
    {
        if($access = self::search($user, $contact, $mode))
        {
            $access->delete();
        }
    }
}
