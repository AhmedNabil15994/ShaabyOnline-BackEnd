<?php

namespace Modules\Catalog\Transformers\WebService;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PaginatedResource extends ResourceCollection
{
    protected $mapInto;

    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->mapInto($this->mapInto),
            'links' => [
                "first" => $this->buildUrlQuery(['page' => 1]),
                "last" => $this->buildUrlQuery(['page' => $this->lastPage()]),
                "prev" => $this->previousPageUrl(),
                "next" => $this->nextPageUrl(),
            ],
            'meta' => [
                'current_page' => $this->currentPage(),
                'from' => $this->firstItem(),
                'last_page' => $this->lastPage(),
                'path' => url()->current(),
                'per_page' => $this->perPage(),
                'to' => $this->lastItem(),
                'total' => $this->total(),
            ],
        ];

        /*return [
            'items' => $this->collection->mapInto($this->mapInto),
            'pagination' => [
                'count' => $this->count(),
                'current_page' => $this->currentPage(),
                'next_page_url' => $this->nextPageUrl(),
                'previous_page_url' => $this->previousPageUrl(),
                'last_page' => $this->lastPage()
            ]
        ];*/
    }

    public function mapInto($resourceClass)
    {
        $this->mapInto = $resourceClass;
        return $this;
    }

    public function buildUrlQuery($paramsArray = [])
    {
        return url()->current() . '?' . http_build_query(array_merge(request()->query(), $paramsArray));
    }

}
