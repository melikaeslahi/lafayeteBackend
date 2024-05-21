<?php

namespace App\Models\Admin\Content;

 
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nagy\LaravelRating\Traits\Rateable;

class Post extends Model
{
    use HasFactory, Sluggable , SoftDeletes ,Rateable;
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    protected $casts = ['image' => 'array'];
    protected $fillable = [
        'title',
        'body',
        'summary',
        'tags',
        'status',
        'slug',
        'published_at',
        'commentable',
        'category_id',
        'author_id' ,
        'image'
    ];

    public function postCategory(){
        return $this->belongsTo(PostCategory::class , 'category_id');
    }

    public function comments(){
        return $this->morphMany('App\Models\Admin\Comment', 'commentable');
    }
}
