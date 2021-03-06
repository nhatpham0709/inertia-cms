<?php

namespace App\Transformers\Admin;

use Illuminate\Http\Resources\Json\ResourceCollection;


class RolePaginationResource extends ResourceCollection
{
    /**
     * @var array
     */
    private array $pagination;

    public function __construct($resource)
    {
        $this->pagination = [
            'total' => $resource->total(),
            'count' => $resource->count(),
            'per_page' => $resource->perPage(),
            'current_page' => $resource->currentPage(),
            'total_pages' => $resource->lastPage()
        ];

        $resource = $resource->getCollection();

        parent::__construct($resource);
    }


    /**
     * Transform the resource into an array.
     *
     * @param  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'data' => RoleResource::collection($this->collection),
            'meta' => [
                'code' => 200,
                'message' => 'Successful',
                'pagination' => $this->pagination,
            ],
        ];
    }
}
