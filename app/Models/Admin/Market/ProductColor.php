<?php

namespace App\Models\Admin\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductColor extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'color_name',
        'color',
        'product_id',
        'price_increase',
        'marketable_number',
        'sold_number',
        'frozen_number',
        'status'
    ];
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
