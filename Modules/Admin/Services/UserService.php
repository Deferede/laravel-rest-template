<?php

namespace Modules\Admin\Services;

use App\Dto\UserDto;
use App\Models\User;
use App\Services\BaseService;
use Exception;
use Spatie\Permission\Models\Role;

class UserService extends BaseService
{
    public function createUser(UserDto $userDto)
    {
        $user = User::create($userDto->toArray());

        if (!isset($userDto->role)) {
            $this->assignRole($user, 'user');
        }

        return $user;
    }

    /**
     * var int|App\Models\User $user
     * var App\Dto\UserDto $userDto
     */
    public function updateUser($user, UserDto $userDto)
    {
        if (is_int($user)) {
            $user = User::findOrFail($user);
        }

        $user->update($userDto->toArray());

        if (isset($userDto->role)) {
            $this->assignRole($user, $userDto->role);
        }

        $user->refresh();

        return $user;
    }

    /**
     * var int|App\Models\User $user
     */
    public function deleteUser($user)
    {
        if (is_int($user)) {
            $user = User::findOrFail($user);
        }

        if ($user->hasRole('admin')) {
            throw new \Exception("You can't delete admins.");
        }

        $user->delete();
    }

    private function assignRole(User $user, string $role)
    {

        if ($user->role->name !== 'admin') {
            throw new Exception(trans('admin.users.cant_change.role'));
        }

        $role = Role::findByName($role, 'api');

        $user->syncRoles($role);
    }
}
