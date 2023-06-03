<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; // Soft Delete
use Illuminate\Database\Eloquent\SoftDeletes; // Soft Delete

class Veterinarian extends Model
{
    use HasFactory;
    use softDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['dgp'];

    /**
     * Get the user related to the veterinarian.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the schedules of the veterinarian.
     *
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Get the appointments for the veterinarian.
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

}
