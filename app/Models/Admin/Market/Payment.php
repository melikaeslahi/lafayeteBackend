<?php

namespace App\Models\Admin\Market;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable=['amount' , 'user_id' , 'type' , 'paymentable_type' , 'paymentable_id' , 'status'];
    public function paymentable(){
        return $this->morphTo();
    }
    public function user(){
        return $this->belongsTo(User::class , 'user_id');
    }
}
