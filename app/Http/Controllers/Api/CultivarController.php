<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use Illuminate\Support\Facades\Auth;

class CultivarController extends Controller
{
    // Cultivar name
    public function index($type)
    {
        $data = Batch::select('cultivar')
            ->whereUserid(Auth::id());
        if ($type != 'all') {
            $data = $data->whereComparment($type);
        }
        $data = $data->groupby('cultivar')
            ->get();
        return ['data' => $data];
    }
}
