<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebSocketLogs extends Model
{
    use HasFactory;


    protected $table = 'WebSocketLog'; 
    protected $guarded = [];

}
