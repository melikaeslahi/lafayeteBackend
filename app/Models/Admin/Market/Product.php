<?php

namespace App\Models\Admin\Market;

 
use Carbon\Carbon;
use App\Models\Admin\Content\Slider;
use App\Models\User;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nagy\LaravelRating\Traits\Rateable;

class Product extends Model
{
    use HasFactory, SoftDeletes, Sluggable , Rateable;
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected $fillable = [
        'name',
        'introduction',
        'price',
        'status',
        'tags',
        'image',
        'slug',
        'marketable',
        'category_id',
        'brand_id',
        'frozen_number',
        'marketable_number',
        'sold_number',
        'length',
        'weight',
        'height',
        'published_at'
    ];

    protected $casts =['image' => 'array'];
    // protected $appends = ['activeAmazingSales'];


    public function category(){
        return $this->belongsTo(ProductCategory::class , 'category_id');
    }

    public function brand(){
        return $this->belongsTo(Brand::class , 'brand_id');
    }

    public function metas(){
        return $this->hasMany(ProductMeta::class);
    }
    public function comments(){
        return $this->morphMany('App\Models\Admin\Comment' , 'commentable');
    }
    public function  images(){
        return $this->hasMany( Gallery::class);
    }
    public  function colors(){
        return $this->hasMany(ProductColor::class);
    }
    public  function  sizes(){
        return $this->hasMany(ProductSize::class);
    }
    public function sliders(){
        return $this->belongsToMany(Slider::class);
    }
     public function values()
     {
         return $this->hasMany(CategoryValue::class);
     
     }
     public function amazingSales()
    {
        return $this->hasMany(AmazingSale::class);   
    }
    
    public function getActiveAmazingSalesAttribute(){
        return $this->amazingSales()->where('start_date' , '<' , Carbon::now())->where('end_date' , '>' , Carbon::now())->first();
    }
    public function getActiveCommentsAttribute(){
        return $this->comments()->where('approved' , 1)->whereNull('parent_id')->with('user' , 'answer')->get();
    }
    public function user(){
        return $this->belongsToMany(  User::class);
    }
    // public function getRouteKeyName()
    // {
    //     return 'slug';
    // }
  
}
