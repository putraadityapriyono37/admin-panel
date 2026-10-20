<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\MenuItem;

class MenuItemPolicy
{
    public function update(Admin $admin, MenuItem $menuItem): bool
    {
        return $admin->canAccessMicrosite($menuItem->microsite_id);
    }

    public function delete(Admin $admin, MenuItem $menuItem): bool
    {
        return $admin->canAccessMicrosite($menuItem->microsite_id);
    }
}
