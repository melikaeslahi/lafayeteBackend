<?php

namespace App\Models\Admin\Content;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable =['title' , 'status' , 'url' , 'image' , 'position'];
    protected $casts = ['image' =>'array'];
    public static $position = [
        '0'=>'اسلایدر',
        '1'=>'دو بنر تبلیغاتی بین دو اسلایدر ',
        '2' =>' بنر تبلیغاتی پایین اسلایدر',
        '3' =>'کالکشن ها'

    ];
}
