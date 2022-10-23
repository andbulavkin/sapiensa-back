<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBatchRequest;
use App\Http\Requests\UpdateBatchRequest;
use App\Http\Resources\BatchResource;
use App\Models\Batch;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\Cultivar;

class BatchController extends Controller
{
    use Cultivar;

    public $archivedcultivar=[];

    public function __construct()
    {
        $this->archivedcultivar = $this->archivedcultivar();
    }

    // Batch list with comparment, searching filter
    public function index($type, Request $request)
    {
        $search = $request->search;
        $data = Batch::whereUserid(Auth::id())

            // ->whereComparment($type)
            ->whereNotIn('cultivar',$this->archivedcultivar)
            ->whereRaw('FIND_IN_SET(?, comparment)',[$type])
            ->where(function ($query) use ($search) {
                $query->orwhere('comparment', 'like', "%$search%");
                $query->orwhere('comparmentNo', 'like', "%$search%");
                $query->orwhere('batchID', 'like', "%$search%");
                $query->orwhere('cultivar', 'like', "%$search%");
                $query->orwhere('plantingDate', 'like', "%$search%");
                $query->orwhere('triggerDate', 'like', "%$search%");
                $query->orwhere('harvestDate', 'like', "%$search%");
                $query->orwhere('transplantDate', 'like', "%$search%");
                $query->orwhere('cloneDate', 'like', "%$search%");
                $query->orwhere('cullDate', 'like', "%$search%");
            })
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

        return BatchResource::collection($data);
    }

    // Batch detail
    public function details($id)
    {
        try {
            $data = Batch::whereId($id)->firstOrFail();
            return new BatchResource($data);
        } catch (Exception $e) {
            return ['message' => 'invalid batchID.'];
        }
    }

    // Store batch
    public function store(CreateBatchRequest $request)
    {

        $data = $request->validated();
        $data['batchID'] = str_replace(" ", "",  $request->batchID);
        $checkBatchId = Batch::where('userId', Auth::id())->where('batchID', $data['batchID'])->whereComparment($request->comparment)->first();
        if (isset($checkBatchId)) {
            return response()->json(['message' => 'The batch id has already been taken.'], 400);
        }
        $data['userID'] = Auth::id();
        $data['plantingDate'] = (!empty($request->plantingDate)) ? date('Y-m-d', strtotime($request->plantingDate)) : null;
        $data['triggerDate'] = (!empty($request->triggerDate)) ? date('Y-m-d', strtotime($request->triggerDate)) : null;
        $data['harvestDate'] = (!empty($request->harvestDate)) ? date('Y-m-d', strtotime($request->harvestDate)) : null;
        $data['transplantDate'] = (!empty($request->transplantDate)) ? date('Y-m-d', strtotime($request->transplantDate)) : null;
        $data['cloneDate'] = (!empty($request->cloneDate)) ? date('Y-m-d', strtotime($request->cloneDate)) : null;
        $data['cullDate'] = (!empty($request->cullDate)) ? date('Y-m-d', strtotime($request->cullDate)) : null;
        Batch::create($data);

        return ['message' => 'Batch added successfully.'];
    }

    // edit batch
    public function edit(UpdateBatchRequest $request, $id)
    {


        $datas = $request->validated();


        $type = explode(',', $request->comparment);
        $type = end($type);

        $data['userID'] = Auth::id();
        if($type == 'Clone' && !empty($request->transplantDate)){
            $data['comparment'] = $request->comparment.",Vegetative";
            $data['plantingDate'] = date('Y-m-d', strtotime($request->transplantDate));
        }

        if($type == 'Vegetative' && !empty($request->transplantDate)){
            $data['comparment'] =  $request->comparment.",Flower";
            $data['triggerDate'] = date('Y-m-d', strtotime($request->transplantDate));
        }

        if($type == 'Flower' && !empty($request->harvestDate)){
            $data['harvestDate'] = date('Y-m-d', strtotime($request->harvestDate));
        }


        Batch::whereId($id)->update($data);



        // $data['plantingDate'] = date('Y-m-d', strtotime($request->plantingDate));
        // $data['triggerDate'] = (!empty($request->triggerDate)) ? date('Y-m-d', strtotime($request->triggerDate)) : null;
        // $data['harvestDate'] = (!empty($request->harvestDate)) ? date('Y-m-d', strtotime($request->harvestDate)) : null;
        // $data['transplantDate'] = (!empty($request->transplantDate)) ? date('Y-m-d', strtotime($request->transplantDate)) : null;
        // $data['cloneDate'] = (!empty($request->cloneDate)) ? date('Y-m-d', strtotime($request->cloneDate)) : null;
        // $data['cullDate'] = (!empty($request->cullDate)) ? date('Y-m-d', strtotime($request->cullDate)) : null;
        Batch::whereId($id)->update($data);
        return ['message' => 'Batch edit successfully.'];
    }

    // delete batch
    public function delete($id)
    {
        Batch::whereId($id)->delete();
        return ['message' => 'Batch deleted successfully.'];
    }

    public function suggestion(Request $request)
    {
        try {
            $comparment = explode(',', str_replace(' ', '', $request->comparment));
            $batch = Batch::where('batchID', $request->search)
                ->whereIn('comparment', $comparment)
                ->where('userID', Auth::id())
                ->whereNotIn('cultivar',$this->archivedcultivar)
                ->get();

            // $batch = Batch::where('batchID', $request->search)->where('userID', Auth::id())->first();
            if (isset($batch)) {
                return BatchResource::collection($batch);
            } else {
                return ['data' => (object) []];
            }
        } catch (\Exception $e) {
            return ['message' => $e->getMessage()];
        }
    }
}
