<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $mainImage = $this->images->first();
        $subImage  = $this->images->skip(1)->first();

        return [
            'id'         => $this->id,
            'main_image' => new ImageResource($mainImage),
            'sub_image'  => new ImageResource($subImage),
        ];
    }
}
