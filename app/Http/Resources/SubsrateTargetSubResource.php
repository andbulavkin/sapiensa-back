<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubsrateTargetSubResource extends JsonResource
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
            'subsrateTargetSubId' => $this->id,
            'subsrateTargetId' => $this->subsrateTargetID,
            'fromDay' => $this->fromDay,
            'toDay' => $this->toDay,
            'ecMinMax' => $this->ecMinMax,
            'phMinMax' => $this->phMinMax
        ];
    }
}
