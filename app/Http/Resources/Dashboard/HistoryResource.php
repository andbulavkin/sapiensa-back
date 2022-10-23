<?php

namespace App\Http\Resources\Dashboard;

use App\Http\Resources\SubsrateResource;
use App\Models\Subsrate;
use Illuminate\Http\Resources\Json\JsonResource;

class HistoryResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'userID' => $this->userID,
            'comparment' => $this->comparment,
            'comparmentNo' => $this->comparmentNo,
            'batchID' => $this->batchID,
            'cultivar' => $this->cultivar,
            'plantingDate' => $this->plantingDate?date('d M, Y', strtotime($this->plantingDate)):"",
            'triggerDate' => $this->triggerDate?date('d M, Y', strtotime($this->triggerDate)):"",
            'harvestDate' => $this->harvestDate?date('d M, Y', strtotime($this->harvestDate)):"",
            'transplantDate' => $this->transplantDate?date('d M, Y', strtotime($this->transplantDate)):"",
            'cloneDate' => $this->cloneDate?date('d M, Y', strtotime($this->cloneDate)):"",
            'cullDate' => $this->cullDate?date('d M, Y', strtotime($this->cullDate)):"",
            'subsrateData' => SubsrateResource::collection($this->whenLoaded('subsrates_data')),

        ];
    }
}
