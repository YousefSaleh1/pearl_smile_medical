<?php

namespace App\Http\Resources\Service;

use App\Http\Resources\ImageResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceSliderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this->id,
            'title' => $this->{'title_'.app()->getLocale()},
            'image' => new ImageResource($this->service_images->first()),
        ];
    }
}
