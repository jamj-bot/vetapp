<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; // Soft Delete
use Illuminate\Database\Eloquent\SoftDeletes; // Soft Delete
use Illuminate\Support\Str;

class Appointment extends Model
{
    use HasFactory;
    use softDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'veterinarian_id',
        'start_time',
        'end_time_expected'
    ];


    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['start_time', 'end_time_expected'];


    /**
     * Set the user's first name.
     *
     * @param  string  $value
     * @return void
     */

    /**
     * Get the veterinarian related to the appointment.
     */
    public function veterinarian()
    {
        return $this->belongsTo(veterinarian::class);
    }

    /**
     * Get the user related to the appointment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Services related to the appointment.
     */
    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    /**
     * Get the string of all diseases.
     *
     * @return string
     */
    public function getAllServicesAttribute()
    {
        $stringServices = Str::ucfirst($this->services->implode('service_name', ', '));
        return "$stringServices.";
    }

    public function getPriceExpectedAttribute()
    {
        $price = 0;
        foreach ($this->services as $service) {
            $price += $service->price;
        }
        return $price;
    }

    public function getPassAttribute()
    {
        return $this->start_time->lt(now());
    }

    public function getPriceFinalAttribute()
    {
        $price = 0;
        foreach ($this->services as $service) {
            $price += $service->price;
        }
        return $price - $this->discount;
    }

    function getColorAttribute()
    {
        // Declare an associative array
        $arr = array(
            "a"=>"#6695ba",
            "b"=>"#00a1c3",
            "c"=>"#00acb4",
            "d"=>"#00b289",
            "e"=>"#01b44a",
            "f"=>"#a0a200",
            "g"=>"#e98226",
            "h"=>"#ff6177",
            "i"=>"#ff6177",
        );

        // Use shuffle function to randomly assign numeric
        // key to all elements of array.
        shuffle($arr);
        $arr[0];
        return $arr[0];
    }
}
