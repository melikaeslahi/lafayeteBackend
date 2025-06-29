<?php

namespace App\Models\Admin\Content;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use HasFactory , SoftDeletes , Sluggable;
    protected $table ='faqs';
    public function sluggable(): array
    {
        return[
            'slug'=>[
                'source'=>'question'
            ]
        ];
    }
    protected $fillable = ['slug' , 'tag' , 'answer' , 'question' , 'status'];
}
