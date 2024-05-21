<?php

namespace App\Models\Admin\Content;

use App\Http\Resources\Admin\Content\PostCategoryResource;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostCategory extends Model
{
    use HasFactory,SoftDeletes , Sluggable;
    protected $table= 'post_categories';
    public function sluggable(): array
    {
        return [
            'slug' =>[
                'source'=>'name'
            ] 
        ];
    }
    protected $casts=['image'=>'array'];
    protected $fillable=[
        'name',
        'description',
        'image',
        'tags',
        'slug',
        'status',
        'parent_id'
    ];
    public function parent(){
        return $this->belongsTo($this , 'parent_id')->with('parent');
    }
    public  function children(){
          return $this->hasMany(static::class , 'parent_id');

    }
    public  function  menus(){
        return $this->hasMany( Menu::class );

  }
    
}
