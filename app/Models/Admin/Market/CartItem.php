<?php

namespace App\Models\Admin\Market;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartItem extends Model
{
    use HasFactory ,  SoftDeletes;

    protected $fillable  =['user_id','product_id' , 'color_id' , 'number'];
    protected $appends = ['cartItemProductPrice' , 'cartItemProductDiscount' ,'cartItemFinalDiscount' , 'cartItemFinalDiscount'];
    public function product(){
        return $this->belongsTo(Product::class , 'product_id');
    }
    
    public function  color(){
        return $this->belongsTo(ProductColor::class , 'color_id');
    }

    public function  user(){
        return $this->belongsTo(User::class , 'user_id');
    }
     // productPrice +colorPrice + guaranteePrice
     public function getCartItemProductPriceAttribute(){
        $colorPriceIncrease= empty($this->color_id) ? 0 : $this->color->price_increase;
        
        return $this->product->price + $colorPriceIncrease ;
    }

    //productPrice * (discountpercentage /100)
    public function getCartItemProductDiscountAttribute(){
        // dd($this->cartItemProductPrice);
        $cartItemProductPrice = $this->cartItemProductPrice;

        $productDiscount =empty($this->product->activeAmazingSales) ? 0 : $cartItemProductPrice * ($this->product->activeAmazingSales->percentage /100) ;
        return $productDiscount;
    }
    //number * (productPrice +colorPrice + guaranteePrice - productDiscount)
    
    public function getCartItemFinalPriceAttribute(){
        $cartItemProductPrice = $this->cartItemProductPrice;
        $productDiscount = $this->cartItemProductDiscount;
        return $this->number *($cartItemProductPrice - $productDiscount);
    }
 
    //number * productDiscount
    public function getCartItemFinalDiscountAttribute(){   
        $productDiscount = $this->cartItemProductDiscount;
        return $this->number * $productDiscount;
    }
}
