<?php

namespace App\Http\Resources\Service;

use Illuminate\Http\Request;
use App\Http\Resources\FAQResource;
use App\Http\Resources\OfferResource;
use App\Http\Resources\SectionResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\MedicalTeam\MedicalTeamSliderResource;

class ServiceDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'title'         => $this->{'title_' . app()->getLocale()},
            'description'   => $this->{'description_' . app()->getLocale()},
            'sections'      => SectionResource::collection($this->sections),
            'faqs'          => FAQResource::collection($this->faqs),
            'offers'        => OfferResource::collection($this->offers),
            'medical_teams' => MedicalTeamSliderResource::collection($this->medical_teams),
        ];
    }
}
