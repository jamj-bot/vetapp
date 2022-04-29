<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; // Soft Delete
use Illuminate\Database\Eloquent\SoftDeletes; // Soft Delete
//use Spatie\Permission\Traits\HasRoles; // Laravel Permission

class Parasiticide extends Model
{
    use HasFactory;
    use softDeletes;
    // use HasRoles;

    protected $fillable = [
        'name',
        'type',
        'manufacturer',
        'description',
        'dose',
        'administration',
        'primary_application',
        'primary_doses',
        'reapplication_interval',
        'reapplication_doses'
    ];

    /**
     * Get the dewormings for the parasiticide.
     *
     */
    public function dewormings()
    {
        return $this->hasMany(Deworming::class);
    }

    /**
     * The species that belong to the parasiticide.
     *
     **/
    public function species()
    {
        return $this->belongsToMany(
            Species::class,
            'parasiticides_species',
            'parasiticide_id',
            'species_id'
        );
    }
}
