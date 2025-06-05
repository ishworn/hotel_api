<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Employee extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'status',
        'hire_date',
        'schedule',
        'position_id',
        'status',

       
    ];

    // 🔗 Employee belongs to Position
    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function department()
{
    return $this->position?->department();
}


  
}
