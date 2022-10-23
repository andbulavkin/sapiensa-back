<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'userID',
        'comparment',
        'comparmentNo',
        'batchID',
        'cultivar',
        'plantingDate',
        'triggerDate',
        'harvestDate',
        'transplantDate',
        'cloneDate',
        'cullDate',
    ];

    public function batchData()
    {
        return $this->belongsTo(Subsrate::class, 'id', 'batchID');
    }

    /**
     * Get all of the subsrates for the Batch
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subsrates()
    {
        return $this->hasMany(Subsrate::class, 'batchID')->orderBy('samplingDate', 'ASC');
        //maybe orderby make issue on other pages!!!
    }


    /**
     * Get all of the subsrates for the Batch for historic data
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function subsrates_data()
    {
        return $this->hasMany(Subsrate::class, 'batchID')->orderBy('samplingDate', 'ASC');
    }
}
