<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    use AuthorizesRequests;

    public function show(User $user)
    {
        $this->authorize('user_profile_show');
        return view('admin.users.show', compact('user'));
    }
}
