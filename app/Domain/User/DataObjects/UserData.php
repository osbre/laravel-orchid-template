<?php

namespace Domain\User\DataObjects;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\DataTransferObject\DataTransferObject;

class UserData extends DataTransferObject
{
    /**
     * @var int|null
     */
    public $id = null;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;

    /**
     * @var array|null
     */
    public $permissions = null;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'name' => $request->get('user')['name'],
            'email' => $request->get('user')['email'],
            'password' => Hash::make($request->get('user')['password']),
            'permissions' => self::formatPermissions($request->get('permissions'))
        ]);
    }

    public static function formatPermissions(array $permissions)
    {
        foreach ($permissions as $key => $value) {
            unset($permissions[$key]);
            $permissions[base64_decode($key)] = $value;
        }

        return $permissions;
    }
}
