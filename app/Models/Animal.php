<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the species associated with the animal.
     */
    public function species()
    {
        return $this->belongsTo(Species::class, 'species_id');
    }

    public function consultations()
    {
        return $this->belongsTo(Consultation::class, 'animal_id');
    }
public function breed()
{
    return $this->belongsTo(Breed::class);
}
}
