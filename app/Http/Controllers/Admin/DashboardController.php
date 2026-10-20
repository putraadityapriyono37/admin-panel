<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Microsite;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function superAdmin()
    {
        return view('admin.super-dashboard', [
            'microsites' => Microsite::all(),
        ]);
    }

    public function microsite(Microsite $microsite)
    {
        $admin = Auth::guard('admin')->user();

        abort_unless(
            $admin->isSuperAdmin() || $admin->microsites()->whereKey($microsite->id)->exists(),
            403
        );

        return view('admin.dashboard', compact('microsite'));
    }
}