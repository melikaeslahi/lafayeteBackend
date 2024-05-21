<?php

namespace App\Models\Admin\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfflinePayment extends Model
{
    use HasFactory;
    protected $fillable=['amount' , 'user_id' , 'transaction_id' , 'pay_date'];
    public function payments(){
        return $this->morphMany(Payment::class , 'paymentable');
    }
}
