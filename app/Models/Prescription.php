<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'order',
        'date',
        'expiry',
        'repeat',
        'number_of_repeats',
        'interval_between_repeats',
        'further_information'
    ];



    /**
     * Get the consultation that owns the prescription.
     */
    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    /**
     * Get the instructions for the prescriptions.
     */
    public function instructions()
    {
        return $this->hasMany(Instruction::class);
    }
}
