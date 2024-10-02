<?php

namespace App\Http\Resources\MedicalTeam;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Service\ServiceSliderResource;

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
            'id'                 => $this->id,
            'name'               => $this->{'name_'.app()->getLocale()},
            'specializations'    => $this->{'specializations_'.app()->getLocale()},
            'resume'             => $this->{'resume_'.app()->getLocale()},
            'phone_number'       => $this->phone_number,
            'services'           => ServiceSliderResource::collection($this->services)
        ];
    }
}
