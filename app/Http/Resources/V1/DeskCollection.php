<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use App\Http\Resources\V1\DeskResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DeskCollection extends ResourceCollection
{
    protected $collect = DeskResource::class;
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
