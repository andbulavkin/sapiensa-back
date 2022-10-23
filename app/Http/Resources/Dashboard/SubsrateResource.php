<?php

namespace App\Http\Resources\Dashboard;

use App\Models\Feed;
use App\Models\SubsrateTarget;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class SubsrateResource extends JsonResource
{
    public function toArray($request)
    {
        $ecMeasured = '-';
        $phMeasured = '-';
        $SubsrateTarget = SubsrateTarget::whereUserid(Auth::id())
            ->whereComparment($this->comparment)
            ->whereCultivar($this->cultivar)
            ->first();
        if ($SubsrateTarget) {
            $subsrateTargetSub = $SubsrateTarget->subsrateTargetSub()->orderby('id', 'desc')->first();
            if ($subsrateTargetSub) {
                $ecMeasured = ecPhFormat($subsrateTargetSub->ecMinMax);
                $phMeasured = ecPhFormat($subsrateTargetSub->phMinMax);
            }
        }

        $dayAfterTrigger = "-";
        $plantingDate = Carbon::parse($this->batchData->plantingDate);
        if($this->comparment == "Clone"){
            $plantingDate = Carbon::parse($this->batchData->cloneDate);
        }
        $dayAfterTrigger = $plantingDate->diffInDays(Carbon::parse($this->samplingDate));
        return [
            'subsrateID' => $this->id,
            'userID' => $this->userID,
            'comparment' => $this->comparment,
            'comparmentNo' => $this->comparmentNo,
            'batchData' => $this->batchData->batchID,
            'cultivar' => $this->cultivar,
            'batchID' => $this->batchData->id,
            'batchName' => $this->batchData->batchID,
            'samplingDate' => date('d M, Y', strtotime($this->samplingDate)),
            'eC' => number_format($this->eC,1,'.',''),
            'pH' => number_format($this->pH,1,'.',''),
            'ecMeasured' => number_format($this->eC,1,'.','') . " (" . $ecMeasured . ")",
            'phMeasured' => number_format($this->pH,1,'.','') . " (" . $phMeasured . ")",
            'dayAfterTrigger' => $dayAfterTrigger,
        ];
    }
}
