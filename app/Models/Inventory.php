<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventories';

    protected $fillable = [
        'inventory_code',
        'name',
        'category_id',
        'quantity',
        'unit',
        'min_stock',
        'supplier',
        'location',
        'last_updated',
    ];

    /**
     * Relationship to Category.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
