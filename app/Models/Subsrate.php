<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subsrate extends Model
{
    use HasFactory;

    protected $fillable = [
        'userID',
        'comparment',
        'comparmentNo',
        'batchID',
        'cultivar',
        'samplingDate',
        'eC',
        'pH'
    ];

    public function batchData(){
        return $this->belongsTo(Batch::class,'batchID','id');
    }
}
