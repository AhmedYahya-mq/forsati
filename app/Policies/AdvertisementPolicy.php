<?php

namespace App\Policies;

use App\Models\Admin;

class AdvertisementPolicy extends BasePolicy
{
    public function checkPolicy(Admin $admin): bool
    {
        //
        return $this->hasManagePermission($admin,"manage_content");
    }
}
