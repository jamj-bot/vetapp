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

    /**
     * The vaccines that belong to the species.
     */
    // public function species()
    // {
    //    //return $this->belongsToMany(RelatedModel, pivot_table_name, foreign_key_of_current_model_in_pivot_table, foreign_key_of_other_model_in_pivot_table);
    // return $this->belongsToMany(
    //         Species::class,
    //         'vaccines_species',
    //         'species_id',
    //         'vaccine_id');
    // }
}
