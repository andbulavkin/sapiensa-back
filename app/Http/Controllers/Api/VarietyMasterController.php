<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VarietyMasterResource;
use App\Models\VarietyMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VarietyMasterController extends Controller
{
    // Cultivar list
    public function index(Request $request)
    {
        $lists = VarietyMaster::whereUserId(Auth::id());
        if (isset($request->status)) {
            $lists = $lists->where('archive', $request->status);
        }
        return VarietyMasterResource::collection($lists->get());
    }

    // Add Cultivar
    public function store(Request $request)
    {
        $request->validate([
            'cultivar' => 'required',
        ]);
        $checkUser = VarietyMaster::whereUserId(Auth::id())
            ->where('cultivar', $request->cultivar)
            ->first();
        if (isset($checkUser)) {
            return response()->json(['message' => 'Already added this cultivar'], 400);
        }
        $data['user_id'] = Auth::id();
        $data['cultivar'] = $request->cultivar;
        $data['archive'] = $request->archive;
        VarietyMaster::create($data);
        return ['message' => 'Cultivar master added successfuly.'];
    }

    // Update cultivar
    public function update(Request $request, $id)
    {
        $checkUser = VarietyMaster::whereUserId(Auth::id())
            ->where('id', '!=', $id)
            ->where('cultivar', $request->cultivar)
            ->first();
        if (isset($checkUser)) {
            return response()->json(['message' => 'Already added this cultivar'], 400);
        }
        $data['cultivar'] = $request->cultivar;
        $data['archive'] = $request->archive;
        VarietyMaster::whereId($id)->update($data);
        return ['message' => 'Variety master edit successfully.'];
    }

    // delete cultivar
    public function delete($id)
    {
        VarietyMaster::whereId($id)->delete();
        return ['message' => 'Variety master delete successfully.'];
    }
}
