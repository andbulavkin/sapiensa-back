<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateFeedSubRequest;
use App\Http\Resources\FeedSubResource;
use App\Models\FeedSub;
use Exception;

class FeedSubController extends Controller
{
    // feed sub list
    public function index($feedID)
    {
        $data = FeedSub::where('feedID', $feedID)->get();
        return FeedSubResource::collection($data);
    }

    // store feed sub
    public function store(CreateFeedSubRequest $request)
    {
        try {
            $data = $request->validated();
            FeedSub::create($data);
            return ['message' => 'Feed Sub added successfully.'];
        } catch (Exception $e) {
            return ['message' => 'invalid subsrateTargetID.'];
        }
    }

    // edit feed sub
    public function edit(CreateFeedSubRequest $request, $id)
    {
        try {
            $data = $request->validated();
            FeedSub::whereId($id)->update($data);
            return ['message' => 'Feed Sub edit successfully.'];
        } catch (Exception $e) {
            return ['message' => 'invalid subsrateTargetID.'];
        }
    }

    // delete feed sub
    public function delete($id)
    {
        FeedSub::whereId($id)->delete();
        return ['message' => 'Feed Sub deleted successfully.'];
    }
}
