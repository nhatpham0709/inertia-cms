<?php

namespace App\Transformers\Admin;

use App\Transformers\SuccessResource;
use Illuminate\Http\Request;

class PermissionResource extends SuccessResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request
     * @return array
     */
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
