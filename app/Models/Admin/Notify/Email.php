<?php

namespace App\Models\Admin\Notify;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Email extends Model
{
    use HasFactory ,SoftDeletes;
    protected $table = 'public_mails';
    protected $fillable=['subject' ,'body' , 'published_at' , 'status' ];
}
