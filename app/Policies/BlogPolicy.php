<?php
namespace App\Policies;

use App\Models\Admin;

class BlogPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function checkPolicy(Admin $admin): bool
    {
        //
        return $this->hasManagePermission($admin,"manage_blogs");
    }
}
