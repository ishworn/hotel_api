<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Position extends Model
{
    use HasFactory;

    protected $fillable = ['name',  'title', 'access_sections', 'department_id' , 'role_id'];

    // 🔗 Position belongs to a Department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // 🔗 Position has many Employees
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
    public function role()
{
    return $this->belongsTo(Role::class);
}
}
