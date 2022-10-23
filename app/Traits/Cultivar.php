<?php

namespace App\Traits;

use App\Models\VarietyMaster;

trait Cultivar
{

    public function archivedcultivar(){
        return VarietyMaster::where('archive',1)->get()->pluck('cultivar');
    }


}
