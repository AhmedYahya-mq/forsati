<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserPolicy extends BasePolicy
{


    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Model $model): bool
    {
        // التحقق من صلاحية عرض مستخدم فردي
        return $user->id === $model->id;
    }


    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Model $model): bool
    {
        // التحقق من صلاحية تعديل المستخدمين
        return  $user->id === $model->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Model $model): bool
    {
        // التحقق من صلاحية حذف المستخدمين
        return  $user->id === $model->id;
    }

}
