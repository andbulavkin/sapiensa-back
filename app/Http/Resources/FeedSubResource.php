<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FeedSubResource extends JsonResource
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
            'feedSubId' => $this->id,
            'feedID' => $this->feedID,
            'fromDay' => $this->fromDay,
            'toDay' => $this->toDay,
            'ecMinMax' => number_format($this->ecMinMax, 1, '.', ''),
            'phMinMax' => number_format($this->phMinMax, 1, '.', ''),
        ];
    }
}
