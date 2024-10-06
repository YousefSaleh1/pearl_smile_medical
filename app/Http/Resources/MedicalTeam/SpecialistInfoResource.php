<?php

namespace App\Http\Resources\MedicalTeam;

use App\Http\Resources\ImageResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Service\ServiceSliderResource;
use App\Http\Resources\VideoResource;

class SpecialistInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'name'            => $this->{'name_'.app()->getLocale()},
            'specializations' => $this->{'specializations_'.app()->getLocale()},
            'resume'          => $this->{'resume_'.app()->getLocale()},
            'image'           => new ImageResource($this->images->first()),
            'video'           => new VideoResource($this->videos->first()),
            'services'        => ServiceSliderResource::collection($this->services)
        ];
    }
}
