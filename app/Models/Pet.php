<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; // Soft Delete
use Illuminate\Database\Eloquent\SoftDeletes; // Soft Delete
use Spatie\Permission\Traits\HasRoles; // Laravel Permission

class Pet extends Model
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
        'species_id',
        'code',
        'name',
        'breed',
        'sex',
        'dob',
        'neutered',
        'diseases',
        'allergies',
        'status'
    ];

    /**
     * Get the user that owns the pet.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the species of the pet.
     */
    public function species()
    {
        return $this->belongsTo(Species::class);
    }
}
