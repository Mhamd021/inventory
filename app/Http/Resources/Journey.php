<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Journey extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {


         return [
            'id' => $this->id ,
            'headline' => $this->headline,
            'start_day' => $this->start_day,
            'last_day' => $this->last_day,
            'start_point' => $this->start_point,
            'end_point' => $this->end_point,
            'description' => $this->description,
            'journey_charg' => $this->journey_charg,
            'max_number'=> $this->max_number,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
         ];

}
}
