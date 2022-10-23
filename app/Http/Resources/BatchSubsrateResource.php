<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BatchSubsrateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $dayAfter = '0 Days';
        $period = '0 Days';


        if ($this->type == 'Flower') {
            if ($this->triggerDate) {
                $startDate = Carbon::parse($this->triggerDate);
                $dayAfter = $startDate->diffInDays(Carbon::now()) . " Days";
            }

            $period = Carbon::parse($this->harvestDate)->diffInDays(Carbon::parse($this->triggerDate)) . " Days";
        } else if ($this->type == "Vegetative") {
            $startDate = Carbon::parse($this->plantingDate);
            $dayAfter = $startDate->diffInDays(Carbon::now()) . " Days";

            $period = Carbon::parse($this->triggerDate)->diffInDays(Carbon::parse($this->plantingDate)) . " Days";
        } else if ($this->type == "Clone") {
            $startDate = Carbon::parse($this->cloneDate);
            $dayAfter = $startDate->diffInDays(Carbon::now()) . " Days";

            $period = Carbon::parse($this->plantingDate)->diffInDays(Carbon::parse($this->cloneDate)) . " Days";
        } else if ($this->type == "Mother") {
            $startDate = Carbon::parse($this->plantingDate);
            $dayAfter = $startDate->diffInDays(Carbon::now()) . " Days";

            $period = Carbon::parse($this->cullDate)->diffInDays(Carbon::parse($this->plantingDate)) . " Days";
        }

        return [
            'id' => $this->id,
            'userID' => $this->userID,
            'comparment' => $this->comparment,
            'comparmentNo' => $this->comparmentNo,
            'batchID' => $this->batchID,
            'subsrateData' => new SubsrateResource($this->whenLoaded('batchData')),
            'cultivar' => $this->cultivar,
            'plantingDate' => $this->plantingDate, // ? date('d M, Y', strtotime($this->plantingDate)) : "-",
            'triggerDate' => $this->triggerDate, // ? date('d M, Y', strtotime($this->triggerDate)) : "-",
            'harvestDate' => $this->harvestDate, // ? date('d M, Y', strtotime($this->harvestDate)) : "-",
            'transplantDate' => $this->transplantDate, // ? date('d M, Y', strtotime($this->transplantDate)) : "-",
            'cloneDate' => $this->cloneDate, // ? date('d M, Y', strtotime($this->cloneDate)) : "-",
            'cullDate' => $this->cullDate, // ? date('d M, Y', strtotime($this->cullDate)) : "-",
            'dayAfter' => $dayAfter,
            'period' => $period,
        ];
    }
}
