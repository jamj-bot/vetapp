<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    use AuthorizesRequests;

    public function show(User $user, Appointment $appointment = null)
    {
        $this->authorize('user_profile_show');

        if ($appointment) {
            // Abort si el usuario no tiene una appointment con el id del appointment que se quiere ver
            //abort_if(!$user->appointments->where('id', $appointment->id)->where('start_time', '>', Carbon::now())->count(), 404);
            abort_if(!$user->appointments->where('id', $appointment->id), 404);
        }

        abort_if(! $user->hasRole('Client'), 404);

        return view('admin.users.show', compact('user', 'appointment'));
    }
}
