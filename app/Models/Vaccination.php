<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; // Soft Delete
use Illuminate\Database\Eloquent\SoftDeletes; // Soft Delete
use Spatie\Permission\Traits\HasRoles; // Laravel Permission

class Vaccination extends Model
{
    use HasFactory;
    use softDeletes;
    use HasRoles;

    protected $fillable = [
        'vaccine_id',
        'type',
        'batch_number',
        'dose_number',
        'doses_required',
        'done',
        'applied'
    ];

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['done'];

    /**
     * Get the species of the pet.
     */
    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    /**
     * Get the vaccine of the vaccineDoses.
     */
    public function vaccine()
    {
        return $this->belongsTo(Vaccine::class);
    }


}
