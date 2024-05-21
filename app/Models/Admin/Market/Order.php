<?php

namespace App\Models\Admin\Market;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory ;
    protected $guarded=[
        'id'
    ];
    public function user(){
        return $this->belongsTo(User::class , 'user_id');
    }
    public function payment(){
        return $this->belongsTo(Payment::class , 'payment_id');
    }
    public function address(){
        return $this->belongsTo(Address::class , 'address_id');
    }
    public function delivery(){
        return $this->belongsTo(Delivery::class , 'delivery_id');
    }
    public function copan(){
        return $this->belongsTo(Copan::class , 'copan_id');
    }
    public function commonDiscount(){
        return $this->belongsTo(CommonDiscount::class , 'common_discount_id');
    }
    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }
    public function getPaymentStatusValueAttribute()
   {

      switch ($this->payment_status) {
         case 0:
            $result  = 'پرداخت نشده';
            break;
         case 1:
            $result  = 'پرداخت شده';
            break;
         case 2:
            $result  = 'باطل شده';
            break;
         default:
            $result  = 'بازگشت داده شده';
      }
      return $result;
   }

   public function getPaymentTypeValueAttribute()
   {

      switch ($this->payment_type) {
         case 0:
            $result  = ' آنلاین';
            break;
         case 1:
            $result  = 'آفلاین ';
            break;
         default:
            $result  = 'درمحل ';
      }
      return $result;
   }

   public function getdeliveryStatusValueAttribute()
   {

      switch ($this->delivery_status) {
         case 0:
            $result  = ' ارسال نشده  ';
            break;
         case 1:
            $result  = ' درحال ارسال';
            break;
         case 2:
            $result  = ' ارسال شده';
            break;
         default:
            $result  = ' تحویل داده شده';
      }
      return $result;
   }
   public function getorderStatusValueAttribute()
   {

      switch ($this->order_status) {
         case 0:
            $result  = 'بررسی نشده';
            break;
         case 1:
            $result  = 'در انتظار تایید';
            break;
         case 2:
            $result  = 'تایید شده';
            break;
         case 3:
            $result  = 'تایید نشده';
            break;
         case 4:
            $result  = 'مرجوع شده';
            break;

         default:
            $result  = 'باطل شده';
      }
      return $result;
   }

}
