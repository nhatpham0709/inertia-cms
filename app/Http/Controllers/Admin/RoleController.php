<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\CreateRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Http\Services\RoleService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoleController extends Controller
{
    private $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index()
    {
        return Inertia::render('Admin/Role');
    }

    public function add(CreateRoleRequest $request)
    {

        return $this->roleService->add(
            $request->input('name'),
            $request->input('description'),
            $request->input('default_redirect'),
            $request->input('permissions')
        );
    }

    public function update(UpdateRoleRequest $request)
    {
        return $this->roleService->update(
            $request->input('id'),
            $request->input('name'),
            $request->input('description'),
            $request->input('default_redirect'),
            $request->input('permissions')
        );
    }

    public function deleteById($id)
    {
        return $this->roleService->delete($id);
    }

    public function listing(Request $request)
    {
        $start = $request->input('start');
        $length = $request->input('length');
        $keyword = $request->input('search');
        $orderBy = $request->input('order_by');
        $orderType = $request->input('order_type');

        return $this->roleService->listing($start, $length, $keyword, $orderBy, $orderType);
    }

    public function listingAll(Request $request)
    {
        return $this->roleService->listingAll();
    }
}
