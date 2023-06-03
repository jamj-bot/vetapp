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
        'further_information',
        'voided'
    ];


    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {


            $year = now()->format('Y');
            $maxOrder = Prescription::where('order', 'like', "$year%")->max('order');
            $model->order = $maxOrder ? $maxOrder + 1 : $year . '00001';
        });
    }

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
