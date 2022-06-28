<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Permission\CreatePermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;
use App\Http\Services\PermissionService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PermissionController extends Controller
{
    private PermissionService $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function index()
    {
        return Inertia::render('Admin/Permission');
    }

    public function listing(Request $request)
    {
        $start = $request->input('start');
        $length = $request->input('length');
        $keyword = $request->input('search');
        $orderBy = $request->input('order_by');
        $orderType = $request->input('order_type');

        return $this->permissionService->listing($start, $length, $keyword, $orderBy, $orderType);
    }

    public function listingAll(Request $request)
    {
        return $this->permissionService->listingAll($request);
    }

    public function add(CreatePermissionRequest $request)
    {
        return $this->permissionService->add(
            $request->input('name'),
            $request->input('description')
        );
    }

    public function update(UpdatePermissionRequest $request)
    {
        return $this->permissionService->update(
            $request->input('id'),
            $request->input('name'),
            $request->input('description')
        );
    }

    public function deteleById($id)
    {
        return $this->permissionService->delete($id);
    }
}
