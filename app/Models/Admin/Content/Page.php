<?php

namespace App\Models\Admin\Content;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use HasFactory , SoftDeletes , Sluggable;
    public function sluggable(): array
    {
        return[
            'slug'=>[
                'source'=>'name'
            ]
        ];
    }
    protected $fillable=['name','title' , 'body' , 'status' , 'slug' , 'tags'];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
