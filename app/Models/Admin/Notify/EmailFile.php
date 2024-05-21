<?php

namespace App\Models\Admin\Notify;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailFile extends Model
{
    use HasFactory , SoftDeletes;
    protected $table ='public_mail_files';
    protected $fillable = ['public_mail_id' , 'file_path' , 'file_size' ,'type' ,'status'];

    public function mail(){
        return $this->belongsTo(Email::class ,'public_mail_files' );
    }
}
