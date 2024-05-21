<?php

namespace App\Models\Admin\Market;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Copan extends Model
{
    use HasFactory , SoftDeletes;
    protected $fillable =[
        'code' ,
        'amount',
        'amount_type',
        'type',
        'user_id',
        'discount_ceiling',
        'status',
        'start_date',
        'end_date'
];
public function user(){
    return $this->belongsTo(User::class , 'user_id');
}
}
