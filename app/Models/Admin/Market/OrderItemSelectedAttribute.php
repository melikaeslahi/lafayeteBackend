<?php

namespace App\Models\Admin\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItemSelectedAttribute extends Model
{
    use HasFactory;
    public function categoryAttribute(){
        return $this->belongsTo(CategoryAttribute::class , 'category_attribute_id');
     }
     public function categoryAttributeValue(){
        return $this->belongsTo(CategoryValue::class , 'category_value_id');
     }
}
