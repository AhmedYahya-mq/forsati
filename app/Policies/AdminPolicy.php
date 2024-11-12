<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;

class AdminPolicy extends BasePolicy
{

    public function checkPolicy(Admin $admin): bool
    {
        return $this->hasManagePermission($admin,"manage_users");
    }

    public function manager(Admin $admin): bool{
        return  $admin->hasPermission("manage_all");
    }
    /**
     * Determine whether the user can view the model.
     */
    public function view(Model $admin, Model $model): bool
    {
        // التحقق من صلاحية عرض مستخدم فردي
        return $admin->id === $model->id;
    }


    /**
     * Determine whether the user can update the model.
     */
    public function update(Model $admin, Model $model): bool
    {
        // التحقق من صلاحية تعديل المستخدمين
        return  $admin->id === $model->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Model $admin, Model $model): bool
    {
        // التحقق من صلاحية حذف المستخدمين
        return  $admin->id === $model->id;
    }

}
