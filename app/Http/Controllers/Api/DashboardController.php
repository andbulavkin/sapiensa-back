<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BatchSubsrateResource;
use App\Http\Resources\Dashboard\CustomeGraphResource;
use App\Http\Resources\Dashboard\DashboardResource;
use App\Http\Resources\Dashboard\HistoryResource;
use App\Http\Resources\FeedResource;
use App\Http\Resources\SubsrateTargetResource;
use App\Models\Batch;
use App\Models\Feed;
use App\Models\Subsrate;
use App\Models\SubsrateTarget;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\Cultivar;

class DashboardController extends Controller
{
    use Cultivar;

    public $archivedcultivar=[];

    public function __construct()
    {
        $this->archivedcultivar = $this->archivedcultivar();
    }
    // main dashboard with comparment filter
    public function dashboard(Request $request)
    {

        $request->validate([
            'type' => 'required',
        ]);
        $type = $request->type;
        $search = $request->search;
        $comparment = 0;
        // get comparment counts
        switch ($type) {
            case 'Flower':
                $comparment = Auth::user()->flower;
                break;
            case 'Vegetative':
                $comparment = Auth::user()->vegitative;
                break;
            case 'Clone':
                $comparment = Auth::user()->clone;
                break;
            case 'Mother':
                $comparment = Auth::user()->mother;
                break;
        }
        $data = array();
        for ($i = 1; $i <= $comparment; $i++) {
            $comparmentObj['compartmentNo'] = $i;
            $comparmentObj['compartment'] = $type . " " . Auth::user()->growUnit . " " . $i;
            // min-max Ec
            $latestSamples = Batch::select('subsrates.*')
                ->whereNotIn('batches.cultivar', $this->archivedcultivar)
                ->where(function ($query) use ($type) {
                    if ($type == 'Flower') {
                        // $query->whereNull('batches.triggerDate');
                        $query->whereNull('batches.harvestDate');
                    } elseif ($type == 'Vegetative') {
                        $query->whereNull('batches.triggerDate');
                    } elseif ($type == 'Clone') {
                        $query->whereNull('batches.plantingDate');
                    } elseif ($type == 'Mother') {
                        $query->whereNull('batches.cullDate');
                    }
                })
                ->where('subsrates.userID', Auth::id())
                // ->where('subsrates.comparment', $type)
                ->whereRaw('FIND_IN_SET(?, subsrates.comparment)',[$type])
                ->where('subsrates.comparmentNo', $i)
                ->join('subsrates', 'batches.id', '=', 'subsrates.batchID')
                ->orderBy('samplingDate', 'desc')
                ->get()
                ->unique('batchID');
                // print_r($latestSamples);
                //

            // $minEc = Subsrate::whereUserid(Auth::id())
            //     ->whereComparment($request->type)
            //     ->whereComparmentno($i)
            //     ->orderby('eC', 'asc')->first();
            // $maxEc = Subsrate::whereUserid(Auth::id())
            //     ->whereComparment($request->type)
            //     ->whereComparmentno($i)
            //     ->orderby('eC', 'desc')->first();
            $minMaxEc = "-";
            if (isset($latestSamples) && $latestSamples->count() > 0) {
                $minMaxEc = $latestSamples->MIN('eC') . "-" . $latestSamples->MAX('eC');
                $minMaxEc = ecPhFormat($minMaxEc);
            }
            $comparmentObj['minMaxEc'] = $minMaxEc;

            // min-max PH
            // $minPh = Subsrate::whereUserid(Auth::id())
            //     ->whereComparment($request->type)
            //     ->whereComparmentno($i)
            //     ->orderby('pH', 'asc')->first();
            // $maxPh = Subsrate::whereUserid(Auth::id())
            //     ->whereComparment($request->type)
            //     ->whereComparmentno($i)
            //     ->orderby('pH', 'desc')->first();
            $minMaxPh = "-";
            if (isset($latestSamples) && $latestSamples->count() > 0) {
                $minMaxPh = $latestSamples->MIN('pH') . "-" . $latestSamples->MAX('pH');
                $minMaxPh = ecPhFormat($minMaxPh);
            }
            $comparmentObj['minMaxPh'] = $minMaxPh;

            // Last sample date
            $lastData = Subsrate::whereUserid(Auth::id())
                ->whereNotIn('cultivar', $this->archivedcultivar)
                ->whereComparment($request->type)
                ->whereComparmentno($i)
                ->orderby('samplingDate', 'desc')->first();
            $comparmentObj['updated_date'] = '';
            if ($lastData) {
                $comparmentObj['updated_date'] = $lastData->samplingDate ? Carbon::parse($lastData->samplingDate)->format("d M, Y") : "-";
            }

            // Get batchs for perticular comparment
            $batchs = Batch::with('subsrates')->whereUserid(Auth::id())
                // ->whereComparment($request->type)
                ->whereRaw('FIND_IN_SET(?, comparment)',[$request->type])
                ->whereNotIn('cultivar', $this->archivedcultivar)
                ->whereComparmentno($i)
                ->where(function ($query) use ($search) {
                    $query->orwhere('comparmentNo', 'LIKE', "%$search%");
                    $query->orwhere('batchID', 'LIKE', "%$search%");
                    $query->orwhere('cultivar', 'LIKE', "%$search%");
                })
                ->where(function ($query) use ($type) {
                    if ($type == 'Flower') {
                        // $query->whereNull('batches.triggerDate');
                        $query->whereNull('batches.harvestDate');
                    } elseif ($type == 'Vegetative') {
                        $query->whereNull('batches.triggerDate');
                    } elseif ($type == 'Clone') {
                        $query->whereNull('batches.plantingDate');
                    } elseif ($type == 'Mother') {
                        $query->whereNull('batches.cullDate');
                    }
                })
                ->get();

            $comparmentObj['batchs'] = DashboardResource::collection($batchs);
            $data[] = $comparmentObj;
        }

        $batchs = Batch::whereUserid(Auth::id())
            ->where(function ($query) use ($type) {

                if ($type == 'Flower') {
                    // $query->whereNull('batches.triggerDate');
                    $query->whereNull('batches.harvestDate');
                } elseif ($type == 'Vegetative') {
                    $query->whereNull('batches.triggerDate');
                } elseif ($type == 'Clone') {
                    $query->whereNull('batches.plantingDate');
                } elseif ($type == 'Mother') {
                    $query->whereNull('batches.cullDate');
                }

                // if ($type == 'Flower') {
                //     $query->whereNull('batches.triggerDate');
                //     $query->orwhereNull('batches.harvestDate');
                // } elseif ($type == 'Vegetative' || $type == 'Clone') {
                //     $query->whereNull('batches.transplantDate');
                // } elseif ($type == 'Mother') {
                //     $query->whereNull('batches.cullDate');
                // }
            })
            ->count();
        return [
            'data' => [
                'items' => $data,
                'totalData' => $batchs,
            ],
        ];
    }

    // main dashboard graph data
    public function dashboardGraph($batchId,$type,$callfrom=0)
    {

        $batch = Batch::with('subsrates')->whereId($batchId)->first();

        if (!isset($batch)) {
            return response()->json(['message' => "Batch not found."], 400);
        }
        $data = [
            'eC' => [
                'lable' => [],
                'value' => [],
            ],
            'pH' => [
                'lable' => [],
                'value' => [],
            ],
        ];

        // get all samples
        if ($batch->subsrates()->count() > 0) {

            if($type == 'Clone'){
                $firstDate = $batch->cloneDate;
            }elseif($type == 'Vegetative'){
                $firstDate = $batch->plantingDate;
            }elseif($type == 'Flower'){
                $firstDate = $batch->triggerDate;
            }elseif($type == 'Mother'){
                $firstDate = $batch->plantingDate;
            }



            $lastDate = $batch->subsrates()->orderby('samplingDate', 'desc')->first()->samplingDate;


            $days = Carbon::parse($lastDate)->diffInDays(Carbon::parse($firstDate));


            $ecMeasLable = [];
            $ecMeasValue = [];

            $ecFeedTargetsLable = [];
            $ecFeedTargetsValue = [];

            $ecSubsrateTargetMinLable = [];
            $ecSubsrateTargetMinValue = [];

            $ecSubsrateTargetMaxLable = [];
            $ecSubsrateTargetMaxValue = [];

            $pHMeasLable = [];
            $pHMeasValue = [];

            $pHFeedTargetsLable = [];
            $pHFeedTargetsValue = [];

            $pHSubsrateTargetMinLable = [];
            $pHSubsrateTargetMinValue = [];

            $pHSubsrateTargetMaxLable = [];
            $pHSubsrateTargetMaxValue = [];

            for ($i = 0; $i <= $days; $i++) {
                $date = Carbon::parse($firstDate)->addDays($i);


                $feed = Feed::where([
                    // 'comparment' => $batch->comparment,
                    'comparment' => $type,
                    'cultivar' => $batch->cultivar
                ])
                    ->whereDate("startDate", "<=", $date)
                    ->orderby("startDate", "desc")
                    ->first();

                $subsrateTarget = SubsrateTarget::where([
                    // 'comparment' => $batch->comparment,
                    'comparment' => $type,
                    'cultivar' => $batch->cultivar
                ])
                    ->whereDate("startDate", "<=", $date)
                    ->orderby("startDate", "desc")
                    ->first();


                $valueEc = $batch->subsrates()->whereDate('samplingDate', $date->format('Y-m-d'))->avg('eC') ?: 0;
                $valuePh =  $batch->subsrates()->whereDate('samplingDate', $date->format('Y-m-d'))->avg('pH') ?: 0;

                if ($valueEc > 0) {
                    $ecMeasLable[] = $i;
                    $ecMeasValue[] = round($valueEc, 1);
                }

                if ($valuePh > 0) {
                    $pHMeasLable[] = $i;
                    $pHMeasValue[] = round($valuePh, 1);
                }

                $feedTargetEcValue = 0;
                $feedTargetPhValue = 0;
                if ($feed) {
                    $feedDayDiff = Carbon::parse($firstDate)->diffInDays(Carbon::parse($date)) ?: 1;

                    $feedTargte = $feed ? $feed->feedSub()->where('fromDay', "<=", $feedDayDiff)->where('toDay', ">=", $feedDayDiff)->first() : 0;

                    $feedTargetEcValue = $feedTargte ? (float)$feedTargte->ecMinMax : 0;
                    $feedTargetPhValue = $feedTargte ? (float)$feedTargte->phMinMax : 0;
                }

                $subsrateTargetEcMinValue = 0;
                $subsrateTargetEcMaxValue = 0;
                $subsrateTargetPhMinValue = 0;
                $subsrateTargetPhMaxValue = 0;
                if ($subsrateTarget) {
                    $subsrateTargetDayDiff = Carbon::parse($firstDate)->diffInDays(Carbon::parse($date)) ?: 1;


                    $subsrateTargetSub = $subsrateTarget->subsrateTargetSub()->where('fromDay', "<=", $subsrateTargetDayDiff)->where('toDay', ">=", $subsrateTargetDayDiff)->first();
                    if ($subsrateTargetSub) {
                        $subsrateTargetEcSub = explode("-", $subsrateTargetSub->ecMinMax);
                        $subsrateTargetEcMinValue = (float)$subsrateTargetEcSub[0];
                        $subsrateTargetEcMaxValue = (float)$subsrateTargetEcSub[1];

                        $subsrateTargetPhSub = explode("-", $subsrateTargetSub->phMinMax);
                        $subsrateTargetPhMinValue = (float)$subsrateTargetPhSub[0];
                        $subsrateTargetPhMaxValue = (float)$subsrateTargetPhSub[1];
                    }
                }
                $ecFeedTargetsLable[] = $i;
                $ecFeedTargetsValue[] = $feedTargetEcValue;

                $ecSubsrateTargetMinLable[] = $i;
                $ecSubsrateTargetMinValue[] = $subsrateTargetEcMinValue;

                $ecSubsrateTargetMaxLable[] = $i;
                $ecSubsrateTargetMaxValue[] = $subsrateTargetEcMaxValue;

                $pHFeedTargetsLable[] = $i;
                $pHFeedTargetsValue[] = $feedTargetPhValue;

                $pHSubsrateTargetMinLable[] = $i;
                $pHSubsrateTargetMinValue[] = $subsrateTargetPhMinValue;

                $pHSubsrateTargetMaxLable[] = $i;
                $pHSubsrateTargetMaxValue[] = $subsrateTargetPhMaxValue;
            }

            $data = [
                'eC' => [
                    [
                        'title' => "EC meas",
                        'lable' => $ecMeasLable,
                        'value' => $ecMeasValue,
                        'color' => 'red',
                    ],
                    [
                        'title' => "Feed tar",
                        'lable' => $ecFeedTargetsLable,
                        'value' => $ecFeedTargetsValue,
                        'color' => '#28a745',
                    ],
                    [
                        'title' => "Ec min sub",
                        'lable' => $ecSubsrateTargetMinLable,
                        'value' => $ecSubsrateTargetMinValue,
                        'color' => '#ffc107',
                    ],
                    [
                        'title' => "Ec max sub",
                        'lable' => $ecSubsrateTargetMaxLable,
                        'value' => $ecSubsrateTargetMaxValue,
                        'color' => '#ffc107',
                    ]
                ],
                'pH' => [
                    [
                        'title' => "pH meas",
                        'lable' => $pHMeasLable,
                        'value' => $pHMeasValue,
                        'color' => 'blue',
                    ],
                    [
                        'title' => "Feed tar",
                        'lable' => $pHFeedTargetsLable,
                        'value' => $pHFeedTargetsValue,
                        'color' => '#28a745',
                    ],
                    [
                        'title' => "pH min sub",
                        'lable' => $pHSubsrateTargetMinLable,
                        'value' => $pHSubsrateTargetMinValue,
                        'color' => 'skyblue',
                    ],
                    [
                        'title' => "pH max sub",
                        'lable' => $pHSubsrateTargetMaxLable,
                        'value' => $pHSubsrateTargetMaxValue,
                        'color' => 'skyblue',
                    ]
                ],
            ];
        }
        if($callfrom == 1){
            return $data;
        }
        return response()->json(['data' => $data]);
    }

    // dashboard History data with comparment filter
    public function historic(Request $request)
    {
        $request->validate([
            'type' => 'required',
        ]);
        $batchselect = 2;
        $type = $request->type;
        $byDate = $request->byDate;
        $cutomDate = $request->cutomDate;
        $byBatchID = $request->byBatchID;
        $byRoomID = $request->byRoomID;
        $byCultivar = $request->byCultivar;
        $data = Batch::with('subsrates_data')
            ->with(['subsrates_data' => function ($query) use($type) {
                $query->where('comparment', $type);
            }])
            ->whereUserid(Auth::id())
            ->whereNotIn('cultivar', $this->archivedcultivar)
            // ->whereComparment($type)
            ->whereRaw('FIND_IN_SET(?, comparment)',[$type])
            ->where(function ($query) use ($type, $batchselect) {
                if ($batchselect == '2') {

                    if ($type == 'Flower') {
                        $query->where('harvestDate', '!=', null);
                    } elseif ($type == 'Vegetative') {
                        $query->where('triggerDate', '!=', null);
                    } elseif ($type == 'Clone') {
                        $query->where('plantingDate', '!=', null);
                    } elseif ($type == 'Mother') {
                        $query->where('cullDate', '!=', null);
                    }

                    // if ($type == 'Flower') {
                    //     $query->where('harvestDate', '!=', null);
                    // } elseif ($type == 'Vegetative') {
                    //     $query->where('transplantDate', '!=', null);
                    // } elseif ($type == 'Clone') {
                    //     $query->where('transplantDate', '!=', null);
                    // } elseif ($type == 'Mother') {
                    //     $query->where('cullDate', '!=', null);
                    // }
                }
            })
            ->when($byDate, function ($query, $byDate) {
                if ($byDate == 1) {
                    $query->whereMonth('created_at', '=', Carbon::now()->subMonth()->month);
                } elseif ($byDate == 2) {
                    $query->whereBetween('created_at', [Carbon::now()->startOfMonth()->subMonth(6), Carbon::now()->startOfMonth()]);
                } elseif ($byDate == 3) {
                    $query->whereBetween('created_at', [Carbon::now()->startOfMonth()->subMonth(12), Carbon::now()->startOfMonth()]);
                }
            })
            ->when($cutomDate, function ($query, $cutomDate) {
                $query->whereDate('created_at', '=', $cutomDate);
            })
            ->when($byBatchID, function ($query, $byBatchID) {
                $query->where('batchID', $byBatchID);
            })
            ->when($byRoomID, function ($query, $byRoomID) {
                $query->where('comparmentNo', $byRoomID);
            })
            ->when($byCultivar, function ($query, $byCultivar) {
                $query->where('cultivar', $byCultivar);
            })
            ->get();


        $history_count = Batch::whereUserid(Auth::id())
            ->where(function ($query) use ($type, $batchselect) {
                if ($batchselect == '2') {
                    $query->orwhere('harvestDate', '!=', null);
                    $query->orwhere('transplantDate', '!=', null);
                    $query->orwhere('transplantDate', '!=', null);
                    $query->orwhere('cullDate', '!=', null);
                }
            })
            ->count();

            $res = [];

            foreach($data as $d){
                $res[] = $this->dashboardGraph($d->id,$type,1);
            }



        return [
            'data' => [
                'items' => HistoryResource::collection($data),
                'data' => $res,
                'count' => $history_count,
            ],
        ];
    }

    // dashboard custom graph with comparment filter
    public function customGraph(Request $request)
    {
        $request->validate([
            'type' => 'required',
        ]);
        $type = $request->type;
        $byDate = $request->byDate;
        $cutomDate = $request->cutomDate;
        $byBatchID = $request->byBatchID;
        $byRoomID = $request->byRoomID;
        $byCultivar = $request->byCultivar;

        $data = Batch::with(['subsrates' => function ($query) use($type) {
                $query->where('comparment', $type);
            }])
            ->whereUserid(Auth::id())
            ->whereNotIn('cultivar', $this->archivedcultivar)
            // ->whereComparment($type)
            ->whereRaw('FIND_IN_SET(?, comparment)',[$type])
            ->when($byDate, function ($query, $byDate) {
                if ($byDate == 1) {
                    $query->whereMonth('created_at', '=', Carbon::now()->subMonth()->month);
                } elseif ($byDate == 2) {
                    $query->whereBetween('created_at', [Carbon::now()->startOfMonth()->subMonth(6), Carbon::now()->startOfMonth()]);
                } elseif ($byDate == 3) {
                    $query->whereBetween('created_at', [Carbon::now()->startOfMonth()->subMonth(12), Carbon::now()->startOfMonth()]);
                }
            })
            ->when($cutomDate, function ($query, $cutomDate) {
                $query->whereDate('created_at', '=', $cutomDate);
            })
            ->when($byBatchID, function ($query, $byBatchID) {
                $query->where('batchID', $byBatchID);
            })
            ->when($byRoomID, function ($query, $byRoomID) {
                $query->where('comparmentNo', $byRoomID);
            })
            ->when($byCultivar, function ($query, $byCultivar) {
                $query->where('cultivar', $byCultivar);
            })
            ->get();

        $batch_count = Batch::whereUserid(Auth::id())->count();

        $data->map(function($i) use($type) {
            $i->type = $type;
        });


        return [
            'data' => [
                'items' => CustomeGraphResource::collection($data),
                'count' => $batch_count,
            ],
        ];
    }

    // dashboard batch with comparment filter
    public function batch(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'batchselect' => 'required',
        ]);
        $batchselect = $request->batchselect;
        $type = $request->type;
        $byDate = $request->byDate;
        $cutomDate = $request->cutomDate;
        $byBatchID = $request->byBatchID;
        $byRoomID = $request->byRoomID;
        $byCultivar = $request->byCultivar;
        $data = Batch::with('batchData')
            ->whereUserid(Auth::id())
            ->whereNotIn('cultivar', $this->archivedcultivar)
            // ->whereComparment($type)
            ->whereRaw('FIND_IN_SET(?, comparment)',[$type])
            ->where(function ($query) use ($type, $batchselect) {
                if ($batchselect == '2') {
                    if ($type == 'Flower') {
                        // $query->where('triggerDate', '!=', null);
                        $query->where('harvestDate', '!=', null);
                    } elseif ($type == 'Vegetative') {
                        $query->where('triggerDate', '!=', null);
                    } elseif ($type == 'Clone') {
                        $query->where('plantingDate', '!=', null);
                    } elseif ($type == 'Mother') {
                        $query->where('cullDate', '!=', null);
                    }
                } else {
                    if ($type == 'Flower') {
                        // $query->whereNull('triggerDate');
                        $query->whereNull('harvestDate');
                    } elseif ($type == 'Vegetative') {
                        $query->whereNull('triggerDate');
                    } elseif ($type == 'Clone') {
                        $query->whereNull('plantingdate');
                    // } elseif ($type == 'Vegetative' || $type == 'Clone') {
                    //     $query->whereNull('transplantDate');
                    } elseif ($type == 'Mother') {
                        $query->whereNull('cullDate');
                    }
                }
            })
            ->when($byDate, function ($query, $byDate) {
                if ($byDate == 1) {
                    $query->whereMonth('created_at', '=', Carbon::now()->subMonth()->month);
                } elseif ($byDate == 2) {
                    $query->whereBetween('created_at', [Carbon::now()->startOfMonth()->subMonth(6), Carbon::now()->startOfMonth()]);
                } elseif ($byDate == 3) {
                    $query->whereBetween('created_at', [Carbon::now()->startOfMonth()->subMonth(12), Carbon::now()->startOfMonth()]);
                }
            })
            ->when($cutomDate, function ($query, $cutomDate) {
                $query->whereDate('created_at', '=', $cutomDate);
            })
            ->when($byBatchID, function ($query, $byBatchID) {
                $query->where('batchID', $byBatchID);
            })
            ->when($byRoomID, function ($query, $byRoomID) {
                $query->where('comparmentNo', $byRoomID);
            })
            ->when($byCultivar, function ($query, $byCultivar) {
                $query->where('cultivar', $byCultivar);
            })
            ->get();

        $batch_count = Batch::whereUserid(Auth::id())->count();
        $history_count = Batch::whereUserid(Auth::id())
            ->where(function ($query) use ($type, $batchselect) {
                if ($batchselect == '2') {
                    $query->orwhere('harvestDate', '!=', null);
                    $query->orwhere('transplantDate', '!=', null);
                    $query->orwhere('transplantDate', '!=', null);
                    $query->orwhere('cullDate', '!=', null);
                }
            })
            ->count();

        $data->map(function($i) use($type) {
            $i->type = $type;
        });

        return [
            'data' => [
                'items' => BatchSubsrateResource::collection($data),
                'count' => Batch::whereUserid(Auth::id())->count(),
                'batch_count' => $batch_count,
                'history_count' => $history_count,
            ],
        ];
    }

    // dashboard Ec/ph target
    public function targets(Request $request)
    {
        $request->validate([
            'type' => 'required|in:Flower,Vegetative,Clone,Mother',
            'section' => 'required|in:Feed,Subrate',
        ]);
        if ($request->section == "Feed") {
            $data = Feed::with(['feedSub'])
                ->whereUserid(Auth::id())
                ->whereNotIn('cultivar', $this->archivedcultivar)
                ->where('comparment', $request->type)
                ->get();
            $data = FeedResource::collection($data);
        } else {

            $data = SubsrateTarget::with(['subsrateTargetSub'])
                ->whereUserid(Auth::id())
                ->whereNotIn('cultivar', $this->archivedcultivar)
                ->where('comparment', $request->type)
                ->get();
            $data = SubsrateTargetResource::collection($data);
        }
        $feedCount = Feed::whereUserid(Auth::id())->count();
        $subsrateTargetCount = SubsrateTarget::whereUserid(Auth::id())->count();
        return [
            'data' => [
                'items' => $data,
                'count' => $feedCount + $subsrateTargetCount,
            ],
        ];
    }
}
