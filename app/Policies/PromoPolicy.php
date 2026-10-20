<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Promo;

class PromoPolicy
{
    public function update(Admin $admin, Promo $promo): bool
    {
        return $admin->canAccessMicrosite($promo->microsite_id);
    }

    public function delete(Admin $admin, Promo $promo): bool
    {
        return $admin->canAccessMicrosite($promo->microsite_id);
    }
}
