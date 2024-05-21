<?php

namespace App\Models\Admin\Content;

use App\Models\Admin\Market\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable= ['name' , 'status' , 'parent_id' ];
    public function products(){
        return $this->belongsToMany(Product::class);
    }
  
    public function parent(){
        return $this->belongsTo($this , 'parent_id')->with('parent');
    }
    public function children(){
        return $this->hasMany(self::class , 'parent_id' );
       }


}
