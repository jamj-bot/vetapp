<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; // Soft Delete
use Illuminate\Database\Eloquent\SoftDeletes; // Soft Delete

class Schedule extends Model
{
    use HasFactory;
    use softDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['from', 'to'];

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['from', 'to'];

    /**
     * Get the veterinarian who owns the schedule
     */
    public function veterinarian()
    {
        return $this->belongsTo(Veterinarian::class);
    }
}
