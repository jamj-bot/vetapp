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

    /**
     * Get the Vaccine doses of the vaccine.
     */
    public function vaccinations()
    {
        return $this->hasMany(Vacination::class);
    }
}
