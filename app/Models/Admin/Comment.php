<?php

namespace App\Models\Admin;

use App\Models\Admin\Content\Post;
use App\Models\Admin\Market\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'body',
        'status',
        'seen',
        'approved',
        'commentable_type',
        'commentable_id',
        'author_id',
        'parent_id'
    ];
    public function commentable(){
      return  $this->morphTo();
    }

    public function user(){
        return $this->belongsTo(User::class , 'author_id');
    }

    public function parent(){
        return $this->belongsTo($this , 'parent_id');
    }
    public function answer(){
        return $this->hasMany( $this , 'parent_id')->with('user');
    }
}
