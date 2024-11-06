<?php

namespace App\Policies;

use App\Models\Admin;

class BasePolicy
{
    protected function hasManagePermission(Admin $admin, string $permission): bool
    {
        return $admin->hasPermission($permission) || $admin->hasPermission("manage_all");
    }
}

