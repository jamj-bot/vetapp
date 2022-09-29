<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instruction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'medicine_id',
        'quantity',
        'indications_for_owner'
    ];


    /**
     * Get the medicine that owns the instruction.
     */
    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
