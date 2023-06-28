<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'administrator_user_id',
        'customer_user_id',
        'product_id',
        'date',
        'price',
        'quantity',
    ];

    public function Product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function Administrator()
    {
        return $this->belongsTo(User::class, 'administrator_user_id', 'id');
    }

    public function Customer()
    {
        return $this->belongsTo(User::class, 'customer_user_id', 'id');
    }
}
