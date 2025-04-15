<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use App\Http\Resources\V1\CardResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CardCollection extends ResourceCollection
{
    public $collect = CardResource::class;
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
