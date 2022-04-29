<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; // Soft Delete
use Illuminate\Database\Eloquent\SoftDeletes; // Soft Delete
//use Spatie\Permission\Traits\HasRoles; // Laravel Permission

class Deworming extends Model
{
    use HasFactory;
    use softDeletes;
    //use HasRoles;

    protected $fillable = [
        'parasiticide_id',
        'type',
        'duration',
        'withdrawal_period',
        'dose_number',
        'doses_required'
    ];

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['done'];

    /**
     * Get the pet of the deworming.
     */
    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    /**
     * Get the parasiticide of the deworming.
     */
    public function parasiticide()
    {
        return $this->belongsTo(Parasiticide::class);
    }

}
