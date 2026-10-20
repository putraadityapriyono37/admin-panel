<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Gallery;

class GalleryPolicy
{
    public function update(Admin $admin, Gallery $gallery): bool
    {
        return $admin->canAccessMicrosite($gallery->microsite_id);
    }

    public function delete(Admin $admin, Gallery $gallery): bool
    {
        return $admin->canAccessMicrosite($gallery->microsite_id);
    }
}
