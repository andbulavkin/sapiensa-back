<?php

namespace App\Http\Resources\Dashboard;

use App\Http\Resources\Dashboard\SubsrateResource;
use App\Models\Subsrate;
use App\Models\SubsrateTarget;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class DashboardResource extends JsonResource
{
    public function toArray($request)
    {
        $plantingDate = Carbon::parse($this->plantingDate);
        $lastSubsrate = Subsrate::where('batchID', $this->id)->orderby('samplingDate', 'desc')->first();
        $dayOfCycle = '-';
        $ecMeasured = '-';
        $phMeasured = '-';
        $DayOfKeyword = '';
        if ($this->comparment == 'Flower') {
            $DayOfKeyword = 'F';
        } else if ($this->comparment == 'Vegetative') {
            $DayOfKeyword = 'V';
        } else if ($this->comparment == 'Clone') {
            $DayOfKeyword = 'C';
        } else if ($this->comparment == 'Mother') {
            $DayOfKeyword = 'M';
        }
        // $feeds = Feed::whereUserid(Auth::id())
        //     ->whereComparment($this->comparment)
        //     ->whereCultivar($this->cultivar)
        //     ->first();
        $SubsrateTarget = SubsrateTarget::whereUserid(Auth::id())
            ->whereComparment($this->comparment)
            ->whereCultivar($this->cultivar)
            ->first();
        // if (isset($feeds)) {
        //     $feedSub = $feeds->feedSub()->orderby('id', 'desc')->first();
        // }
        if (isset($SubsrateTarget)) {
            $subsrateTargetSub = $SubsrateTarget->subsrateTargetSub()->orderby('id', 'desc')->first();
        }
        if ($lastSubsrate) {
            $ecMeasured = "";
            $phMeasured = "";
            $dayOfCycle = $DayOfKeyword . $plantingDate->diffInDays(Carbon::parse($lastSubsrate->samplingDate));

            $ecMeasured .= number_format($lastSubsrate->eC, 1, '.', '');
            $phMeasured .= number_format($lastSubsrate->pH, 1, '.', '');

            if (isset($subsrateTargetSub)) {
                $ecMeasured .= " (" . ecPhFormat($subsrateTargetSub->ecMinMax) . ")";
                $phMeasured .= " (" . ecPhFormat($subsrateTargetSub->phMinMax) . ")";
            }
        }
        $lastUpdatedData = Subsrate::where('batchID', $this->id)->orderby('updated_at', 'desc')->first();
        $updated_date = '-';
        if ($lastUpdatedData) {
            $updated_date = $lastUpdatedData->samplingDate ? date('d M, Y', strtotime($lastUpdatedData->samplingDate)) : "";
        }
        return [
            'id' => $this->id,
            'userID' => $this->userID,
            'comparment' => $this->comparment,
            'comparmentNo' => $this->comparmentNo,
            'batchID' => $this->batchID,
            'cultivar' => $this->cultivar,
            'plantingDate' => $this->plantingDate ? date('d M, Y', strtotime($this->plantingDate)) : "",
            'triggerDate' => $this->triggerDate ? date('d M, Y', strtotime($this->triggerDate)) : "",
            'harvestDate' => $this->harvestDate ? date('d M, Y', strtotime($this->harvestDate)) : "",
            'transplantDate' => $this->transplantDate ? date('d M, Y', strtotime($this->transplantDate)) : "",
            'cloneDate' => $this->cloneDate ? date('d M, Y', strtotime($this->cloneDate)) : "",
            'cullDate' => $this->cullDate ? date('d M, Y', strtotime($this->cullDate)) : "",
            'dayOfCycle' => $dayOfCycle,
            'ecMeasured' => $ecMeasured,
            'phMeasured' => $phMeasured,
            'updated_date' => $updated_date,
            'subsrateData' => SubsrateResource::collection($this->whenLoaded('subsrates', function () {
                return $this->subsrates()->orderby('samplingDate', 'asc')->get();
            })),
        ];
    }
}
