<?php

namespace App\Models\Admin\Content;

use App\Models\Admin\Market\ProductCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'menus';
    protected $fillable = [
        'name',
        'url',
        'status',
        'parent_id',
        'post_category_id',
        'product_category_id',

    ];
    public function parent(){
        return $this->belongsTo($this , 'parent_id')->with('parent');
    }
    public function children(){
        return $this->hasMany($this , 'parent_id')->with('children' , 'postCategory' , 'productCategory');
    }

    public function  postCategory(){
        return $this->belongsTo(PostCategory::class , 'post_category_id')->with('children');
    }
    public function  productCategory(){
        return $this->belongsTo(ProductCategory::class , 'product_category_id')->with('children');
    }

  
}
