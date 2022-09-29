<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Soft Delete
use Spatie\Permission\Traits\HasRoles; // Laravel Permission

class Species extends Model
{
    use HasFactory;
    use softDeletes;
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'scientific_name',
    ];


    /**
     * Get the pets for the species.
     */
    public function pets()
    {
        return $this->hasMany(Pet::class);
    }


    // public function vaccines()
    // {
    //    return $this->belongsToMany(
    //         Vaccine::class,
    //         'vaccines_species',
    //         'vaccine_id',
    //         'species_id'
    //     );
    // }

    /**
     * Get the vaccines for the species
     *
     */
    public function vaccines()
    {
        return $this->belongsToMany(Vaccine::class);
    }

    /**
     * Get the parasiticides for the species
     *
     */
    public function parasiticides()
    {
        return $this->belongsToMany(Parasiticide::class);
    }
}
