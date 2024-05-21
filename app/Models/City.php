<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory , SoftDeletes;

    public function addressess(){
        return $this->hasMany(Address::class ,'address_id');
    }
}
