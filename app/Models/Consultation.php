<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

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
}
