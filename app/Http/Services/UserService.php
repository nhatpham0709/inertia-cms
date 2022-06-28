<?php

namespace App\Http\Services;

use App\Exceptions\ApiException;
use App\Models\Role;
use App\Models\User;
use App\Repositories\Admin\UserRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserService
{
    private $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function add($roleId, $username, $email, $password, $name, $status)
    {
        $role = Role::find($roleId);

        if (!$role) {
            throw ApiException::notFound('Role not found');
        }

        return response()->json([
            'code' => $this->userRepo->add(
                $username,
                $email,
                $password,
                $name,
                $status,
                $roleId
            ) ? SUCCESS_CODE : ERROR_CODE
        ]);
    }

    public function update($roleId, $id, $email, $password, $name)
    {
        $role = Role::find($roleId);
        // validate for exist role
        if (!$role) {
            return response()->json([
                'code' => ERROR_CODE,
                'msg' => 'Role not found'
            ], 400);
        }

        $result = $this->userRepo->edit(
            $id,
            $email,
            $password,
            $name,
            $roleId
        );
        return response()->json([
            'code' => $result ? SUCCESS_CODE : ERROR_CODE,
        ]);
    }

    public function status($id)
    {
        $user = User::find($id);
        // validate for exist user
        if (!$user) {
            return response()->json([
                'code' => ERROR_CODE,
                'msg' => 'User not found'
            ], 400);
        }
        return response()->json([
            'code' => $this->userRepo->updateById($id, [
                'status' => $user->status == USER_STATUS_ACTIVE ? USER_STATUS_INACTIVE : USER_STATUS_ACTIVE
            ]) ? SUCCESS_CODE : ERROR_CODE
        ]);
    }


    /**
     *
     * @param [type] $id
     * @return boolean
     */
    public function delete($id): bool
    {
        $user = User::find($id);

        if (!$user) {
            throw ApiException::notFound('User not found');
        }
        $user->roles()->detach();

        return $this->userRepo->deleteById($user->id);
    }

    public function listing($role, $status, $keyword, $length, $orderBy, $orderType): ?LengthAwarePaginator
    {
        return $this->userRepo->listing($role, $status, $keyword, $length, $orderBy, $orderType);
    }
}
