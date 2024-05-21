<?php

namespace App\Models\Admin\Ticket;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketAdmin extends Model
{
    use HasFactory ,SoftDeletes;
   protected $table='ticket_admin';
    protected $fillable= ['user_id'];
    public  function user()
    {
         return $this->belongsTo( User::class , 'user_id');
    }
}
