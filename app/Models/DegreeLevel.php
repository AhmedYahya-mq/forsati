<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DegreeLevel extends Model
{
    use HasFactory;

    protected $fillable = ['name',"id"];

    public function scholarships()
    {
        return $this->belongsToMany(Scholarship::class, 'degree_level_scholarship');
    }
}
