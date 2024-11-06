<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * التحويل إلى مصفوفة.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->status,
            'email_verified_at' => $this->email_verified_at,
            'permissions' => $this->permissions, // إذا كنت تريد إرجاع صلاحيات المستخدم
            // يمكنك إضافة المزيد من الخصائص حسب الحاجة
        ];
    }
}
