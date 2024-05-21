<?php

namespace App\Http\Controllers\Api\V1\Customer\Profile;

use App\Http\Controllers\Controller;
use App\Models\Admin\Market\Product;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    
        public function delete(Product $product){
            
     $user= auth()->user();
     $user->products()->detach($product->id);
     return response()->json(['status' => 200]);
    }
}
