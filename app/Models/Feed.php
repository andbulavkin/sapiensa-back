<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    use HasFactory;

    protected $fillable = [
        'userID',
        'comparment',
        'cultivar',
        'startDate'
    ];

    public function feedSub(){
        return $this->hasMany(FeedSub::class,'feedID','id');
    }
}
