<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FeedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'feedId' => $this->id,
            'comparment' => $this->comparment,
            'cultivar' => $this->cultivar,
            'startDate' => $this->startDate?date('Y-m-d', strtotime($this->startDate)):"",
            // 'startDate' => $this->startDate?date('d M,Y', strtotime($this->startDate)):"",
            'feedSub' => FeedSubResource::collection($this->whenLoaded('feedSub'))
        ];
    }
}
