<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'status'];

    // A department has many sub-departments
    public function subDepartments()
    {
        return $this->hasMany(SubDepartment::class);
    }

    // A department has many stores
    public function stores()
    {
        return $this->hasMany(Store::class);
    }
}
