<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubDepartment extends Model
{
    use HasFactory;

    protected $fillable = ['department_id', 'name', 'code', 'status'];

    // A sub-department belongs to a department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
