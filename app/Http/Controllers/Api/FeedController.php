<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateFeedRequest;
use App\Http\Resources\FeedResource;
use App\Models\Feed;
use App\Models\VarietyMaster;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\Cultivar;

class FeedController extends Controller
{
    use Cultivar;

    public $archivedcultivar=[];

    public function __construct()
    {
        $this->archivedcultivar = $this->archivedcultivar();
    }
    // Feed list
    public function index($type, Request $request)
    {
        $limit = $request->limit ?: 10;
        $cultivar = $request->cultivar;
        $startDate = $request->startDate;
        $data = Feed::with('feedSub')
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
        return FeedResource::collection($data);
    }

    // store feed & sub feed
    public function store(CreateFeedRequest $request)
    {
        $data = $request->validated();
        $data['userID'] = Auth::id();
        $data['startDate'] = date('Y-m-d', strtotime($request->startDate));
        $feed = Feed::create($data);
        if (isset($request->feedSub) && count($request->feedSub) > 0) {
            foreach ($request->feedSub as $feedSub) {
                $feed->feedSub()->create(
                    [
                        'fromDay' => $feedSub['fromDay'],
                        'toDay' => $feedSub['toDay'],
                        'ecMinMax' => $feedSub['ecMinMax'],
                        'phMinMax' => $feedSub['phMinMax'],
                    ]
                );
            }
        }
        return ['message' => 'Feed added successfully.'];
    }

    // edit feed & sub feed
    public function edit(CreateFeedRequest $request, $id)
    {
        $data = $request->validated();
        $VarietyMaster = VarietyMaster::whereCultivar($request->cultivar)->first();
        if (!isset($VarietyMaster)) {
            VarietyMaster::create(['user_id' => Auth::id(), 'cultivar' => $request->cultivar]);
        }
        // $check = Feed::where("id", "!=", $id)
        //     ->whereUserid(Auth::id())
        //     ->where('comparment', $request->comparment)
        //     ->where('cultivar', $request->cultivar)
        //     ->first();
        // if (isset($check)) {
        //     return response()->json(['message' => 'This cultivar already added.'], 400);
        // }
        $data['userID'] = Auth::id();
        $data['startDate'] = date('Y-m-d', strtotime($request->startDate));
        Feed::whereId($id)->update($data);
        return ['message' => 'Feed edit successfully.'];
    }

    // delete feed
    public function delete($id)
    {
        Feed::whereId($id)->delete();
        return ['message' => 'Feed deleted successfully.'];
    }
}
