<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Services\UserService;
use App\Transformers\Admin\UserPaginationResource;
use App\Transformers\SuccessResource;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return Inertia::render('Admin/User');
    }

    public function add(CreateUserRequest $request)
    {
        return $this->userService->add(
            $request->input('username'),
            $request->input('email'),
            $request->input('password'),
            $request->input('name'),
            $request->input('status'),
            $request->input('role')
        );
    }

    public function update(UpdateUserRequest $request)
    {
        return $this->userService->update(
            $request->input('role'),
            $request->input('id'),
            $request->input('email'),
            $request->input('password'),
            $request->input('name'),
        );
    }

    public function status($id)
    {
        return $this->userService->status($id);
    }

    public function delete($id)
    {
        $this->userService->delete($id);

        return new SuccessResource('User deleted');
    }

    public function listing(Request $request): UserPaginationResource
    {
        $role = $request->input('role');
        $status = $request->input('status');
        $length = $request->input('length');
        $keyword = $request->input('search');
        $orderBy = $request->input('order_by');
        $orderType = $request->input('order_type');

        $users = $this->userService->listing($role, $status, $keyword, $length, $orderBy, $orderType);

        return UserPaginationResource::make($users);
    }
}
