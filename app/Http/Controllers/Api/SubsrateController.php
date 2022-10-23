<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSubsrateRequest;
use App\Http\Requests\UpdateSubsrateRequest;
use App\Http\Resources\BatchIDResource;
use App\Http\Resources\SubsrateResource;
use App\Models\Batch;
use App\Models\Subsrate;
use App\Models\SubsrateTarget;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\Cultivar;

class SubsrateController extends Controller
{
    use Cultivar;

    public $archivedcultivar=[];

    public function __construct()
    {
        $this->archivedcultivar = $this->archivedcultivar();
    }

    // subsrate list
    public function index($type, Request $request)
    {


        $search = $request->search;
        $samplingDate = $request->samplingDate;
        $byBatchID = $request->byBatchID;
        $byRoomID = $request->byRoomID;
        $byCultivar = $request->byCultivar;
        $limit = $request->limit ?: 10;

        $data = Subsrate::with(['batchData'])
            ->whereUserid(Auth::id())
            ->whereNotIn('cultivar',$this->archivedcultivar)
            ->whereComparment($type);
        if ($request->samplingDate) {
            $data = $data->whereDate('samplingDate', Carbon::parse($samplingDate)->format("Y-m-d"));
        }
        if ($request->byRoomID) {
            $data = $data->where('comparmentNo', $byRoomID);
        }
        if ($request->byCultivar) {
            $data = $data->where('cultivar', "LIKE", "%$byCultivar%");
        }
        if ($request->byBatchID) {
            $data = $data->whereHas('batchData', function ($query) use ($byBatchID) {
                $query->where('batchID', $byBatchID);
            });
        }
        if ($search) {
            $data = $data->whereHas('batchData', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('batchID', 'like', "%$search%");
                    $subQuery->orwhere('comparment', 'like', "%$search%");
                    $subQuery->orwhere('comparmentNo', 'like', "%$search%");
                    $subQuery->orwhere('cultivar', 'like', "%$search%");
                });
            });
        }
        //$data = $data->limit($limit)->orderby('samplingDate','asc')->get();
        $data = $data->limit($limit)->orderby('created_at','desc')->get();
        return SubsrateResource::collection($data);
    }

    // Batch id list
    public function batchIDList($type, $comparmentNo)
    {
        $data = Batch::whereUserid(Auth::id())
                        // ->whereComparment($type)
                        ->whereRaw('FIND_IN_SET(?, comparment)',[$type])
                        ->whereNotIn('cultivar',$this->archivedcultivar)
                        ->where('comparmentNo', $comparmentNo)
                        ->where(function ($query) use ($type) {
                            if ($type == 'Flower') {
                                $query->whereNull('triggerDate');
                                $query->orwhereNull('harvestDate');
                            } elseif ($type == 'Vegetative') {
                                $query->whereNull('triggerDate');
                            } elseif ($type == 'Clone') {
                                $query->whereNull('plantingDate');
                            } elseif ($type == 'Mother') {
                                $query->whereNull('cullDate');
                            }
                        })
                        ->get();
        return BatchIDResource::collection($data);
    }

    // store subsrate
    public function store(CreateSubsrateRequest $request)
    {
        try {
            Batch::whereid($request->batchID)->firstOrFail();
            $data = $request->validated();
            $data['userID'] = Auth::id();
            $data['samplingDate'] = date('Y-m-d', strtotime($request->samplingDate));
            Subsrate::create($data);
            return ['message' => 'Subsrate added successfully.'];
        } catch (Exception $e) {
            return ['message' => 'invalid batchID.'];
        }
    }

    // edit subsrate
    public function edit(CreateSubsrateRequest $request, $id)
    {
        try {
            Batch::whereid($request->batchID)->firstOrFail();
            $data = $request->validated();
            $data['userID'] = Auth::id();
            $data['samplingDate'] = date('Y-m-d', strtotime($request->samplingDate));
            Subsrate::whereId($id)->update($data);
            return ['message' => 'Subsrate edit successfully.'];
        } catch (Exception $e) {
            return ['message' => 'invalid batchID.'];
        }
    }

    // delete subsrate
    public function delete($id)
    {
        Subsrate::whereId($id)->delete();
        return ['message' => 'Subsrate deleted successfully.'];
    }

    // update subsrate from dashboard and retrun some value
    public function dashboardUpdate(UpdateSubsrateRequest $request)
    {
        $id = $request->subsrateID;
        $ecMeasured = '-';
        $phMeasured = '-';
        try {
            $data['eC'] = $request->eC;
            $data['pH'] = $request->pH;
            Subsrate::whereId($id)->update($data);
            $subsrate = Subsrate::whereId($id)->first();

            $SubsrateTarget = SubsrateTarget::whereUserid(Auth::id())
                ->whereComparment($subsrate->comparment)
                ->whereCultivar($subsrate->cultivar)
                ->first();
            if ($SubsrateTarget) {
                $subsrateTargetSub = $SubsrateTarget->subsrateTargetSub()->orderby('id', 'desc')->first();
                if ($subsrateTargetSub) {
                    $ecMeasured = ecPhFormat($subsrateTargetSub->ecMinMax);
                    $phMeasured = ecPhFormat($subsrateTargetSub->phMinMax);
                }
            }

            return [
                'message' => 'Subsrate edit successfully.',
                'data' => [
                    'ecMeasured' => number_format($subsrate->eC, 1, '.', '') . "(" . $ecMeasured . ")",
                    'phMeasured' => number_format($subsrate->pH, 1, '.', '') . "(" . $phMeasured . ")",
                ],
            ];
        } catch (Exception $e) {
            return ['message' => $e->getMessage()];
        }
    }
}
