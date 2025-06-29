<?php

namespace App\Models\Admin\Market;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Compare extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
   

    public function user()
    {
        return $this->belongsTo( User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
