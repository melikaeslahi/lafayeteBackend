<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Admin\Market\Compare;
use App\Models\Admin\Market\Order;
use App\Models\Admin\Market\Payment;
use App\Models\Admin\Market\Product;
use App\Models\Admin\Ticket\Ticket;
use App\Models\Admin\Ticket\TicketAdmin;
use App\Models\Admin\User\Permission;
use App\Models\Admin\User\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Nagy\LaravelRating\Traits\CanRate;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable ,CanRate;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'mobile',
        'profile_photo_path',
        'national_code',
        'email',
         
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public  function ticketAdmin()
    {
        return $this->hasOne(TicketAdmin::class);
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
   
    public  function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function  orders()
    {
        return $this->hasMany( Order::class);
    }

    public function products()
    {
        return $this->belongsToMany( Product::class);
    }
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
    public function isUserPurchedProduct($product_id)
    {
        $productIds = collect();
        foreach ($this->orderItems()->where('product_id', $product_id)->get() as $item) {
            $productIds->push($item->product_id);
        }
        $productIds = $productIds->unique();
        return $productIds;
    }

    public function compare()
    {
        return $this->hasOne(Compare::class);
    }

}
