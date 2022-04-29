<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Soft Delete
use Spatie\Permission\Traits\HasRoles; // Laravel Permission

class Consultation extends Model
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
        'age',
        'weight',
        'temperature',
        'capillary_refill_time',
        'heart_rate',
        'pulse',
        'respiratory_rate',
        'reproductive_status',
        'consciousness',
        'hydration',
        'pain',
        'body_condition',
        'problem_statement',
        'diagnosis',
        'prognosis',
        'treatment_plan',
        'consult_status',
    ];


    /**
     * Get the pet that owns the consultation.
     */
    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    /**
     * Get the user that owns the consultation.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the consultation's images.
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * Get all of the consultation's images.
     */
    public function tests()
    {
        return $this->morphMany(Test::class, 'testable');
    }
}
