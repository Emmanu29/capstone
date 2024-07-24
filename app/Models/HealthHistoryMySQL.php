<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthHistoryMySQL extends Model
{
    use HasFactory;

    protected $table = 'healthhistories';

    protected $guarded = [];
    
}
