<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\ImageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'title'        => $this->{'title_'. app()->getLocale()},
            'description'  => $this->{'description_'. app()->getLocale()},
            'tags'         => $this->{'tags_'. app()->getLocale()},
            'image'        => new ImageResource($this->images->first())
        ];
    }
}
