<?php

namespace App\Models\Admin\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $guarded=[
        'id'
    ];
    public function order(){
        return $this->belongsTo(Order::class , 'order_item');
    }
    public function singleProduct(){
        return $this->belongsTo(Product::class , 'product_id');
     }
     public function amazingSale(){
        return $this->belongsTo(AmazingSale::class , 'amazing_sale_id');
     }
     public function color(){
        return $this->belongsTo(ProductColor::class , 'color_id');
     }
  
     public function orderItemsAttributes(){
        return $this->hasMany(OrderItemSelectedAttribute::class);
     }
}
