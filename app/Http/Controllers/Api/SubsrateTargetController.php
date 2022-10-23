<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSubsrateTargetRequest;
use App\Http\Resources\SubsrateTargetResource;
use App\Models\SubsrateTarget;
use App\Models\VarietyMaster;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\Cultivar;

class SubsrateTargetController extends Controller
{
    use Cultivar;

    public $archivedcultivar=[];

    public function __construct()
    {
        $this->archivedcultivar = $this->archivedcultivar();
    }
    // subsrate target list
    public function index($type, Request $request)
    {
        $limit = $request->limit ?: 10;
        $cultivar = $request->cultivar;
        $startDate = $request->startDate;
        $data = SubsrateTarget::with('subsrateTargetSub')
            ->whereUserid(Auth::id())
            ->whereNotIn('cultivar',$this->archivedcultivar)
            ->whereComparment($type);
        if ($cultivar) {
            $data = $data->where('cultivar', $cultivar);
        }
        if ($startDate) {
            $data = $data->whereDate('startDate', Carbon::parse($startDate)->format("Y-m-d"));
        }
        $data = $data->limit($limit)->get();
        return SubsrateTargetResource::collection($data);
    }

    // store subsrate target and subsrateTarget Sub
    public function store(CreateSubsrateTargetRequest $request)
    {
        $data = $request->validated();
        $data['userID'] = Auth::id();
        $data['startDate'] = date('Y-m-d', strtotime($request->startDate));
        $subsrateTarget = SubsrateTarget::create($data);
        if (isset($request->subsrateTargetSub) && count($request->subsrateTargetSub) > 0) {
            foreach ($request->subsrateTargetSub as $subsrateTargetSub) {
                $subsrateTarget->subsrateTargetSub()->create(
                    [
                        'fromDay' => $subsrateTargetSub['fromDay'],
                        'toDay' => $subsrateTargetSub['toDay'],
                        'ecMinMax' => $subsrateTargetSub['ecMinMax'],
                        'phMinMax' => $subsrateTargetSub['phMinMax'],
                    ]
                );
            }
        }
        return ['message' => 'Subsrate Target added successfully.'];
    }

    // edit subsrate target
    public function edit(CreateSubsrateTargetRequest $request, $id)
    {
        $data = $request->validated();
        $VarietyMaster = VarietyMaster::whereCultivar($request->cultivar)->first();
        if (!isset($VarietyMaster)) {
            VarietyMaster::create(['user_id' => Auth::id(), 'cultivar' => $request->cultivar]);
        }
        // $check = SubsrateTarget::where("id", "!=", $id)
        //     ->whereUserid(Auth::id())
        //     ->where('comparment', $request->comparment)
        //     ->where('cultivar', $request->cultivar)
        //     ->first();
        // if (isset($check)) {
        //     return response()->json(['message' => 'This cultivar already added.'], 400);
        // }
        $data['userID'] = Auth::id();
        $data['startDate'] = date('Y-m-d', strtotime($request->startDate));
        SubsrateTarget::whereId($id)->update($data);
        return ['message' => 'Subsrate Target edit successfully.'];
    }

    // delete subsrate target
    public function delete($id)
    {
        SubsrateTarget::whereId($id)->delete();
        return ['message' => 'Subsrate Target deleted successfully.'];
    }
}
