<?php

namespace App\Models\Admin\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use HasFactory , SoftDeletes;
    protected $fillable=['name' , 'description' , 'status'];

    public function roles(){
        return $this->belongsToMany(Role::class);
    }
    public function users(){
        return $this->belongsToMany(User::class);
    }
}
