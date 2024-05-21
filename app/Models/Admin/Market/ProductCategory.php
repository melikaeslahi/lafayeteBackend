<?php

namespace App\Models\Admin\Market;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use HasFactory, SoftDeletes, Sluggable;
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
        'description',
        'show_in_menu',
        'slug',
        'status',
        'parent_id',
        'tags',
        'image'
    ];
    protected $casts =['image' => 'array'];

    public function parent(){
       return $this->belongsTo($this , 'parent_id')->with('parent');
    }
    public function children(){
        return $this->hasMany($this , 'parent_id')->with('children');
     }
}
