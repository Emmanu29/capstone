<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlarmData extends Model
{
    protected $table = 'alarms_log'; // Assuming your table is named 'alarms_log'

    protected $fillable = [
        'animal_id',
        'name',
        'type',
        'value',
        'timestamp',
    ];

    // If you don't want timestamps in your table, you can set this to false
    public $timestamps = true;
}
