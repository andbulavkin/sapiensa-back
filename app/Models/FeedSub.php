<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedSub extends Model
{
    use HasFactory;

    protected $fillable = [
        'feedID',
        'fromDay',
        'toDay',
        'ecMinMax',
        'phMinMax'
    ];
}
