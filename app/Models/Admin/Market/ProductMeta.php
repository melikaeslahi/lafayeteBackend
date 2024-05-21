<?php

namespace App\Models\Admin\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductMeta extends Model
{
    use HasFactory , SoftDeletes;
    protected $table = 'product_meta';
    protected $fillable = ['meta_value' , 'meta_key' , 'product_id'];
    public function product(){
        return $this->belongsTo(Product::class);
    }
    protected $casts=['meta_key' => 'array' , 'meta_value'=>'array'];
}
