<?php

namespace App\Models\Admin\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlinePayment extends Model
{
    use HasFactory;
     protected $fillable=['amount' , 'user_id' , 'transaction_id' , 'gateway' ,'bank_first_response' ,'bank_second_response'];
    public function payments(){
        return $this->morphMany(Payment::class , 'paymentable');
    }
}
