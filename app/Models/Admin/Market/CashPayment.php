<?php

namespace App\Models\Admin\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashPayment extends Model
{
    use HasFactory;
    protected $fillable=['amount' , 'user_id' , 'cash_receiver' ,'pay_date'];
    public function payments(){
        return $this->morphMany(Payment::class , 'paymentable');
    }
}
