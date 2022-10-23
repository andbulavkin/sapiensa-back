<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSubsrateTargetSubRequest;
use App\Http\Resources\SubsrateTargetSubResource;
use App\Models\SubstrateTargetSub;
use Exception;

class SubsrateTargetSubController extends Controller
{
    // list subsrate target sub
    public function index($subsrateTargetID)
    {
        $data = SubstrateTargetSub::where('subsrateTargetID', $subsrateTargetID)->get();
        return SubsrateTargetSubResource::collection($data);
    }

    // store subsrate target sub
    public function store(CreateSubsrateTargetSubRequest $request)
    {
        try {
            $data = $request->validated();

            $ecValue = explode("-", $request->ecMinMax);
            if (isset($ecValue)) {
                if (!isset($ecValue[0]) || empty($ecValue[0]) ) {
                    return response()->json(['message'=>"Ec min value is required."], 400);
                }
                if (!isset($ecValue[1]) || empty($ecValue[1])) {
                    return response()->json(['message'=>"Ec max value is required."], 400);
                }
                if($ecValue[0] > $ecValue[1]){
                    return response()->json(['message'=>"Ec max value is grater than Ec min."], 400);
                }
            }

            $phValue = explode("-", $request->phMinMax);
            if (isset($phValue)) {
                if (!isset($phValue[0]) || empty($phValue[0]) ) {
                    return response()->json(['message'=>"pH min value is required."], 400);
                }
                if (!isset($phValue[1]) || empty($phValue[1])) {
                    return response()->json(['message'=>"pH max value is required."], 400);
                }
                if($phValue[0] > $phValue[1]){
                    return response()->json(['message'=>"pH max value is grater than pH min."], 400);
                }
            }

            $data['ecMinMax'] = ecPhFormat($request->ecMinMax);
            $data['phMinMax'] = ecPhFormat($request->phMinMax);
            SubstrateTargetSub::create($data);
            return ['message' => 'Substrate Target Sub added successfully.'];
        } catch (Exception $e) {
            return ['message' => $e->getMessage()];
        }
    }

    // edit subsrate target sub
    public function edit(CreateSubsrateTargetSubRequest $request, $id)
    {
        try {
            $data = $request->validated();

            $ecValue = explode("-", $request->ecMinMax);
            if (isset($ecValue)) {
                if (!isset($ecValue[0]) || empty($ecValue[0]) ) {
                    return response()->json(['message'=>"Ec min value is required."], 400);
                }
                if (!isset($ecValue[1]) || empty($ecValue[1])) {
                    return response()->json(['message'=>"Ec max value is required."], 400);
                }
                if($ecValue[0] > $ecValue[1]){
                    return response()->json(['message'=>"Ec max value is grater than Ec min."], 400);
                }
            }

            $phValue = explode("-", $request->phMinMax);
            if (isset($phValue)) {
                if (!isset($phValue[0]) || empty($phValue[0]) ) {
                    return response()->json(['message'=>"pH min value is required."], 400);
                }
                if (!isset($phValue[1]) || empty($phValue[1])) {
                    return response()->json(['message'=>"pH max value is required."], 400);
                }
                if($phValue[0] > $phValue[1]){
                    return response()->json(['message'=>"pH max value is grater than pH min."], 400);
                }
            }

            $data['ecMinMax'] = ecPhFormat($request->ecMinMax);
            $data['phMinMax'] = ecPhFormat($request->phMinMax);
            SubstrateTargetSub::whereId($id)->update($data);
            return ['message' => 'Substrate Target Sub edit successfully.'];
        } catch (Exception $e) {
            return ['message' => $e->getMessage()];
        }
    }

    // delete subsrate target sub
    public function delete($id)
    {
        SubstrateTargetSub::whereId($id)->delete();
        return ['message' => 'Subsrate Target Sub deleted successfully.'];
    }
}
