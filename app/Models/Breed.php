<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Breed extends Model
{
    use HasFactory;

    protected $table = 'breeds';

    protected $guarded = [];

    public function species()
    {
        return $this->belongsTo(Species::class);
    }
    public function animals()
{
    return $this->hasMany(Animal::class);
}
}

