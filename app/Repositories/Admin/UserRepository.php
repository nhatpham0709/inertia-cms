<?php

namespace App\Repositories\Admin;

use App\Models\Role;
use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class UserRepository extends BaseRepository
{
    /**
     * Specify Model class name.
     *
     * @return mixed
     */
    public function model()
    {
        return User::class;
    }

    public function listing($role, $status, $keyword, $length, $orderBy, $orderType): ?LengthAwarePaginator
    {
        $query = $this->model
            ->with(['roles', 'user' => function ($q) {
                $q->select('id', 'name');
            }]);
        if ($role) {
            $query->whereHas('roles', function ($q) use ($role) {
                $q->where('name', $role);
            });
        }
        if ($status) {
            $query->where('status', $status);
        }

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('username', 'LIKE', "%$keyword%")
                    ->orWhere('email', 'LIKE', "%$keyword%")
                    ->orWhere('name', 'LIKE', "%$keyword%");
            });
        }

        if ($orderBy) {
            $query->orderBy($orderBy, $orderType);
        }

        return $query->paginate($length);
    }


    public function add($username, $email, $password, $name, $status, $role)
    {
        $user = $this->create([
            'username' => $username,
            'email' => $email,
            'password' => bcrypt($password),
            'name' => $name,
            'created_by' => Auth::user()->id,
            'status' => $status
        ]);

        $user->roles()->attach($role);
        return true;
    }

    public function edit($id, $email, $password, $name, $roleId)
    {
        $user = User::find($id);
        $user->roles()->detach();
        $user->roles()->attach(intval($roleId));
        if ($password) {
            $user->password = bcrypt($password);
        }
        $user->email = $email;
        $user->name = $name;
        $user->updated_at = date('Y-m-d H:i:s');
        return $user->save();
    }
}
