<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Soft Delete

class Test extends Model
{
    use HasFactory;
    use softDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'url',
        'name',
        'extension'
    ];

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['testable'];

    /**
     * Get the parent imageable model (Consultation, ather).
     */
    public function testable()
    {
        return $this->morphTo();
    }
}
