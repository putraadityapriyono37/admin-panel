<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Category;

class CategoryPolicy
{
    public function update(Admin $admin, Category $category): bool
    {
        return $admin->canAccessMicrosite($category->microsite_id);
    }

    public function delete(Admin $admin, Category $category): bool
    {
        return $admin->canAccessMicrosite($category->microsite_id);
    }
}
