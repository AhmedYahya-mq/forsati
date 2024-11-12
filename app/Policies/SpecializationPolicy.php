<?php

namespace App\Policies;


use App\Models\Admin;

class SpecializationPolicy extends BasePolicy
{
    public function checkPolicy(Admin $admin): bool
    {
        return $this->hasManagePermission($admin,"manage_specializations");
    }
}
