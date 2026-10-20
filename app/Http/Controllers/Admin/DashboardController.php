<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Microsite;

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
        return view('admin.dashboard', [
            'microsite' => $microsite,
            'currentMicrosite' => $microsite,
        ]);
    }
}
