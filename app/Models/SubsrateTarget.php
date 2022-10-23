<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubsrateTarget extends Model
{
    use HasFactory;

    protected $fillable = [
        'userID',
        'comparment',
        'cultivar',
        'startDate'
    ];

    public function subsrateTargetSub(){
        return $this->hasMany(SubstrateTargetSub::class,'subsrateTargetID','id');
    }
}
