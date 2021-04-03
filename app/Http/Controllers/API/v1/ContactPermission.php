<?php

namespace App\Http\Controllers\API\v1;

use App\Models\User;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeContactPermissionRequest;
use App\Models\ContactPermission as Permission;

class ContactPermission extends Controller
{
    #Route::get('/api/v1/contact-permissions')
    public function modes()
    {
        return Permission::getModesWithNames();
    }

    /**
     * Show all allowed users to a contact with permissions modes
     *
     * @param Contact $contact
     * @param Request $request
     * @return mixed
     */
    #Route::get('/api/v1/contacts/{contact}/permissions')
    public function index(Contact $contact, Request $request)
    {
        return $contact->contactPermissions()->
                         select('mode', 'user_id')->
                         with('user')->
                         inMode($request->input('mode'))->
                         fetch();
    }

    #Route::post('/api/v1/contacts/{contact}/permissions')
    public function store(Contact $contact, ChangeContactPermissionRequest $request)
    {
        $mode = $request->input('mode');
        $permissibleUser = User::findOrFail($request->input('user_id'));

        if(Permission::can($permissibleUser, $contact, $mode))
        {
            return response()->json([
                'message' => 'Already has mode'
            ], 403);
        }

        return Permission::add($permissibleUser, $contact, $mode);
    }

    #Route::delete('/api/v1/contacts/{contact}/permissions')
    public function delete(Contact $contact, ChangeContactPermissionRequest $request)
    {
        $mode = $request->input('mode');
        $permissibleUser = User::findOrFail($request->input('user_id'));

        Permission::remove($permissibleUser, $contact, $mode);

        return response()->json([
            'message' => 'Access changed'
        ]);
    }
}
