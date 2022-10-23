<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BatchResource extends JsonResource
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
            'id' => $this->id,
            'userID' => $this->userID,
            'comparment' => $this->comparment,
            'comparmentNo' => $this->comparmentNo,
            'batchID' => $this->batchID,
            'cultivar' => $this->cultivar,
            // 'plantingDate' => $this->plantingDate?date('d M, Y', strtotime($this->plantingDate)):"",
            // 'triggerDate' => $this->triggerDate?date('d M, Y', strtotime($this->triggerDate)):"",
            // 'harvestDate' => $this->harvestDate?date('d M, Y', strtotime($this->harvestDate)):"",
            // 'transplantDate' => $this->transplantDate?date('d M, Y', strtotime($this->transplantDate)):"",
            // 'cloneDate' => $this->cloneDate?date('d M, Y', strtotime($this->cloneDate)):"",
            // 'cullDate' => $this->cullDate?date('d M, Y', strtotime($this->cullDate)):"",
            'plantingDate' => $this->plantingDate?date('Y-m-d', strtotime($this->plantingDate)):"",
            'triggerDate' => $this->triggerDate?date('Y-m-d', strtotime($this->triggerDate)):"",
            'harvestDate' => $this->harvestDate?date('Y-m-d', strtotime($this->harvestDate)):"",
            'transplantDate' => $this->transplantDate?date('Y-m-d', strtotime($this->transplantDate)):"",
            'cloneDate' => $this->cloneDate?date('Y-m-d', strtotime($this->cloneDate)):"",
            'cullDate' => $this->cullDate?date('Y-m-d', strtotime($this->cullDate)):"",
        ];
    }
}
