<?php

namespace App\Models\Admin\Ticket;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketFile extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo( User::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
