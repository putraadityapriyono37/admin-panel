<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Order;

class OrderPolicy
{
    public function view(Admin $admin, Order $order): bool
    {
        return $admin->canAccessMicrosite($order->microsite_id);
    }

    public function update(Admin $admin, Order $order): bool
    {
        return $admin->canAccessMicrosite($order->microsite_id);
    }
}
