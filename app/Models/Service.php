<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    /**
     * Appointments related to the service.
     *
     */
    public function vaccines()
    {
        return $this->belongsToMany(Vaccine::class);
    }

    /**
     * Get the service_bookeds for the service.
     */
    // public function serviceBookeds()
    // {
    //     return $this->hasMany(ServiceBooked::class);
    // }

}
