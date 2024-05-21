<?php

namespace App\Models;

use App\Models\Admin\Market\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory ,SoftDeletes;
    protected $guarded=['id'];
    public function orders(){
        return $this->hasMany(Order::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function city(){
        return $this->belongsTo( City::class);

    }
}
