<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;


    protected $table = 'departments';
    protected $fillable = ['name',
    'created_at', 'updated_at'];




    // 🔗 Department has many Positions
    public function positions()
    {
        return $this->hasMany(Position::class);
    }

    // 🔗 Department has many Employees
   
}
