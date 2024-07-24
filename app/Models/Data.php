<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    use HasFactory;

    protected $table = 'datas'; // Confirm this matches your database table name
    protected $fillable = ['ecg', 'coreTemp']; // Ensure columns match
}

