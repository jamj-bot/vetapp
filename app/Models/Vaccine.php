<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; // Soft Delete
use Illuminate\Database\Eloquent\SoftDeletes; // Soft Delete
use Spatie\Permission\Traits\HasRoles; // Laravel Permission

class Vaccine extends Model
{
    use HasFactory;
    use softDeletes;
    use HasRoles;

    protected $fillable = [
        'target_species',
        'name',
        'type',
        'manufacturer',
        'description',
        'dose',
        'administration',
        'primary_vaccination',
        'primary_doses',
        'revaccination_interval',
        'revaccination_doses'
    ];

    /**
     * Get the Vaccine doses of the vaccine.
     */
    public function vaccinations()
    {
        return $this->hasMany(VacCination::class);
    }

     /**
     * The species that belong to the vaccine.
     */

    public function species()
    {
       //return $this->belongsToMany(RelatedModel, pivot_table_name, foreign_key_of_current_model_in_pivot_table, foreign_key_of_other_model_in_pivot_table);
       return $this->belongsToMany(
            Species::class,
            'vaccines_species',
            'vaccine_id',
            'species_id');
    }
}
