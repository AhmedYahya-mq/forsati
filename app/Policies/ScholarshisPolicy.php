<?php

namespace App\Policies;

use App\Models\Admin;

class ScholarshisPolicy extends BasePolicy
{
    public function checkPolicy(Admin $admin): bool
    {
        //
        return $this->hasManagePermission($admin,"manage_scholarships");
    }
}
