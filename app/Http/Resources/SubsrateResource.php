<?php

namespace App\Http\Resources;

use App\Models\Feed;
use Illuminate\Http\Resources\Json\JsonResource;
use PhpParser\Node\Expr\Cast\Double;
use Ramsey\Uuid\Type\Decimal;

class SubsrateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $feed = Feed::where('cultivar', $this->cultivar)->where('comparment', $this->comparment)->latest()->first();
        $feedSub = array();
        if ($feed) {
            $feedSub = $feed->feedSub()->oldest()->get();
        }

        return [
            'subsrateID' => $this->id,
            'userID' => $this->userID,
            'comparment' => $this->comparment,
            'comparmentNo' => $this->comparmentNo,
            'batchData' => $this->batchData->batchID,
            'cultivar' => $this->cultivar,
            'batchID' => $this->batchData->id,
            'batchName' => $this->batchData->batchID,
            // 'samplingDate' => date('d M, Y', strtotime($this->samplingDate)),
            'samplingDate' => date('Y-m-d', strtotime($this->samplingDate)),
            'eC' => number_format($this->eC,1,'.',''),
            'pH' => number_format($this->pH,1,'.',''),
            'targets' => FeedSubResource::collection($feedSub),
        ];
    }
}
