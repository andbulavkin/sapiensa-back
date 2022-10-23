<?php

namespace App\Http\Resources\Dashboard;

use App\Models\Feed;
use App\Models\SubsrateTarget;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomeGraphResource extends JsonResource
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
            'plantingDate' => $this->plantingDate ? date('d M, Y', strtotime($this->plantingDate)) : "",
            'triggerDate' => $this->triggerDate ? date('d M, Y', strtotime($this->triggerDate)) : "",
            'harvestDate' => $this->harvestDate ? date('d M, Y', strtotime($this->harvestDate)) : "",
            'transplantDate' => $this->transplantDate ? date('d M, Y', strtotime($this->transplantDate)) : "",
            'cloneDate' => $this->cloneDate ? date('d M, Y', strtotime($this->cloneDate)) : "",
            'cullDate' => $this->cullDate ? date('d M, Y', strtotime($this->cullDate)) : "",
            // 'subsrateData' => $this->whenLoaded('subsrates', function () {
            //     $subsrates = array();
            //     $plantingDate = Carbon::parse($this->plantingDate);
            //     foreach ($this->subsrates as $subsrate) {
            //         $subsrateObj = [
            //             'subsrateID' => $subsrate->id,
            //             'userID' => $subsrate->userID,
            //             'comparment' => $subsrate->comparment,
            //             'comparmentNo' => $subsrate->comparmentNo,
            //             'batchData' => $subsrate->batchData->batchID,
            //             'cultivar' => $subsrate->cultivar,
            //             'batchID' => $subsrate->batchData->id,
            //             'batchName' => $subsrate->batchData->batchID,
            //             'samplingDate' => date('d M, Y', strtotime($subsrate->samplingDate)),
            //             'samplingDay' => $plantingDate->diffInDays(Carbon::parse($subsrate->samplingDate)),
            //             'eC' => number_format($subsrate->eC, 1, '.', ''),
            //             'pH' => number_format($subsrate->pH, 1, '.', ''),
            //         ];
            //         $subsrates[] = $subsrateObj;
            //     }
            //     return $subsrates;
            // }),
            'subsrateData' => $this->whenLoaded('subsrates', function () {


                $subsrates = array();
                // if ($this->comparment == "Clone") {
                //     $plantingDate = Carbon::parse($this->cloneDate);
                // } else {
                //     $plantingDate = Carbon::parse($this->plantingDate);
                // }


                if ($this->type == "Clone") {
                    $plantingDate = Carbon::parse($this->cloneDate);
                }else if ($this->type == "Vegetative") {
                    $plantingDate = Carbon::parse($this->plantingDate);
                }else if ($this->type == "Flower") {
                    $plantingDate = Carbon::parse($this->triggerDate);
                }else if ($this->type == "Mother") {
                    $plantingDate = Carbon::parse($this->plantingDate);
                }

                $firstDate = $plantingDate;
                $lastDate='';
                $samplingDateArr=[];
                foreach ($this->subsrates as $subsrate) {
                    $lastDate = $subsrate->samplingDate;
                    $samplingDateArr[strval($lastDate)]=$subsrate;
                }

                $days = Carbon::parse($lastDate)->diffInDays(Carbon::parse($firstDate));

                for ($i = 0; $i <= $days; $i++) {
                    $subsrate = [];
                    $date = Carbon::parse($firstDate)->addDays($i);

                    // foreach ($this->subsrates as $subsrate) {
                    $ecTargetMin = 0;
                    $ecTargetMax = 0;
                    $phTargetMin = 0;
                    $phTargetMax = 0;

                    SubsrateTarget::whereCultivar($this->cultivar)->first();
                    $subsrateTarget = SubsrateTarget::where([
                        'comparment' => $this->type,
                        'cultivar' => $this->cultivar
                    ])
                        ->whereDate("startDate", "<=", Carbon::parse($date)->format('Y-m-d'))
                        ->orderby("id", "desc")
                        ->first();
                    if ($subsrateTarget) {
                        $subsrateTargetDayDiff = Carbon::parse($firstDate)->diffInDays(Carbon::parse($date)) ?: 1;

                        $subsrateTargetSub = $subsrateTarget->subsrateTargetSub()->where('fromDay', "<=", $subsrateTargetDayDiff)->where('toDay', ">=", $subsrateTargetDayDiff)->first();
                        if ($subsrateTargetSub) {
                            $subsrateTargetEcSub = explode("-", $subsrateTargetSub->ecMinMax);
                            $ecTargetMin = (float)$subsrateTargetEcSub[0];
                            $ecTargetMax = (float)$subsrateTargetEcSub[1];

                            $subsrateTargetPhSub = explode("-", $subsrateTargetSub->phMinMax);
                            $phTargetMin = (float)$subsrateTargetPhSub[0];
                            $phTargetMax = (float)$subsrateTargetPhSub[1];
                        }
                    }

                    $feed = Feed::where([
                        'comparment' => $this->type,
                        'cultivar' => $this->cultivar
                    ])
                        ->whereDate("startDate", "<=", $date)
                        ->orderby("id", "desc")
                        ->first();

                    $ecFeedTarget = 0;
                    $phFeedTarget = 0;
                    if ($feed) {
                        $feedDayDiff = Carbon::parse($firstDate)->diffInDays(Carbon::parse($date)) ?: 1;

                        $feedTargte = $feed ? $feed->feedSub()->where('fromDay', "<=", $feedDayDiff)->where('toDay', ">=", $feedDayDiff)->first() : 0;
                        $ecFeedTarget = $feedTargte ? (float)$feedTargte->ecMinMax : 0;
                        $phFeedTarget = $feedTargte ? (float)$feedTargte->phMinMax : 0;
                    }



                    $subsrateObj = [
                        'lastdate'=> $lastDate,
                        // 'subsrateID' => $subsrate->id,
                        // 'userID' => $subsrate->userID,
                        // 'comparment' => $type,
                        // 'comparmentNo' => $subsrate->comparmentNo,
                        // 'batchData' => $subsrate->batchData->batchID,
                        // 'cultivar' => $subsrate->cultivar,
                        // 'batchID' => $subsrate->batchData->id,
                        // 'batchName' => $subsrate->batchData->batchID,
                        'samplingDate' => date('d M, Y', strtotime($date)),
                        'samplingDay' => $plantingDate->diffInDays(Carbon::parse($date)),

                        // 'eC' => ($subsrate) ? number_format($subsrate->eC, 1, '.', '') : '',
                        // 'pH' => ($subsrate) ? number_format($subsrate->pH, 1, '.', '') : '',
                        // 'eC' => number_format($subsrate->eC, 1, '.', ''),
                        // 'pH' => number_format($subsrate->pH, 1, '.', ''),
                        'ecTargetMin' => $ecTargetMin,
                        'ecTargetMax' => $ecTargetMax,
                        'phTargetMin' => $phTargetMin,
                        'phTargetMax' => $phTargetMax,
                        'ecFeedTarget' => $ecFeedTarget,
                        'phFeedTarget' => $phFeedTarget,
                    ];

                     //samplingDateArr
                     $dates = Carbon::parse($date)->format('Y-m-d');
                     if(array_key_exists($dates, $samplingDateArr)){
                        $subsrate = $samplingDateArr[$dates];
                        $arr = [
                            'eC' => ($subsrate) ? number_format($subsrate->eC, 1, '.', '') : '',
                            'pH' => ($subsrate) ? number_format($subsrate->pH, 1, '.', '') : '',
                        ];
                        $subsrateObj['eC'] = number_format($subsrate->eC, 1, '.', '');
                        $subsrateObj['pH'] = number_format($subsrate->pH, 1, '.', '');

                     }

                    $subsrates[] = $subsrateObj;
                }
                return $subsrates;
            }),
        ];
    }
}
