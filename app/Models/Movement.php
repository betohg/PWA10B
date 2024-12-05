<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    use HasFactory;

    protected $table = 'movements';

    protected $primaryKey = 'movement_id';

    protected $fillable = [
        'product_id',
        'movement_type_id', 
        'quantity',
        'movement_date',
        'user_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }


    public function movementType()
{
    return $this->belongsTo(TypeMovement::class, 'movement_type_id');
}

    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}
}
