<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = ['id_orders','id_user','price_orders','id_address','coupon_order','status_order',
    'created_at','updated_at','payment_method','orders_typ',
];
}
