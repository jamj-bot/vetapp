<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; // Soft Delete
use Illuminate\Database\Eloquent\SoftDeletes; // Soft Delete

class Disease extends Model
{
    use HasFactory;
    use softDeletes;

    // protected $fillable = ['name', 'alternative_name', 'description'];
    protected $fillable = ['name'];

    public function consultations()
    {
        return $this->belongsToMany(Consultation::class);
    }

    public function vaccines()
    {
        return $this->belongsToMany(Vaccine::class);
    }
}
