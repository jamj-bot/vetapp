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
        'zootechnical_function',
        'sex',
        'dob',
        'desexed',
        'desexing_candidate',
        'alerts',
        'diseases',
        'allergies',
        'status'
    ];

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['dob'];

    /**
     * Get the user that owns the pet.
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the species of the pet.
     *
     */
    public function species()
    {
        return $this->belongsTo(Species::class);
    }

    /**
     * Get the Vaccinations of the pet.
     *
     */
    public function vaccinations()
    {
        return $this->hasMany(Vaccination::class);
    }

    /**
     * Get the Vaccinations of the pet.
     *
     */
    public function dewormings()
    {
        return $this->hasMany(Deworming::class);
    }


    /**
     * Get the consultation of the pet.
     *
     */
    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    /**
     *  Get all the images for the pet
     *
     **/
    public function images()
    {
        return $this->hasManyThrough(
            Image::class, # El primer argumento pasado al método es el nombre del modelo final al que deseamos acceder
            Consultation::class, # el segundo argumento es el nombre del modelo intermedio
            'pet_id', # El tercer argumento es el nombre de la clave externa en el modelo intermedio,
            'imageable_id'  #El cuarto argumento es el nombre de la clave externa en el modelo final.
        );
    }

    public function tests()
    {
        return $this->hasManyThrough(
            Test::class,
            Consultation::class,
            'pet_id',
            'testable_id'
        );
    }

}
