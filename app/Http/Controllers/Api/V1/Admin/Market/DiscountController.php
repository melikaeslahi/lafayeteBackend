<?php

namespace App\Http\Controllers\Api\V1\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\AmazingSaleRequest;
use App\Http\Requests\Admin\Market\CommonDiscountRequest;
use App\Http\Requests\Admin\Market\CopanRequest;
use App\Http\Resources\Admin\Market\AmazingSaleResource;
use App\Http\Resources\Admin\Market\CommonDiscountResource;
use App\Http\Resources\Admin\Market\CopanResource;
use App\Http\Resources\Admin\Market\ProductResource;
use App\Models\Admin\Market\AmazingSale;
use App\Models\Admin\Market\CommonDiscount;
use App\Models\Admin\Market\Copan;
use App\Models\Admin\Market\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     *  copan
     */
    public function  copans($perPage = 0, $search = '')
    {
        switch ($perPage && $search || $perPage) {
            case  $perPage == 0:
                $paginate = 20;
                $searchVal = $search ? $search : null;
                break;
            case  $perPage == 1:
                $paginate = 30;
                $searchVal = $search ? $search : null;
                break;
            case  $perPage == 2:
                $paginate =  null;
                $searchVal = $search ? $search : null;
                break;
            default:
                $paginate =  20;
                break;
        }
        if ($paginate && $searchVal) {
            if ($paginate === null) {
                return CopanResource::collection(Copan::where('code', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
            }
            return CopanResource::collection(Copan::where('code', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->paginate($paginate));
        } else if ($paginate) {
            return CopanResource::collection(Copan::orderBy('created_at', 'desc')->paginate($paginate));
        } else if ($paginate === null) {
            return CopanResource::collection(Copan::where('code', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function copanStore(CopanRequest $request)
    {
        $inputs = $request->all();
        $realTimestampStart = substr($request->start_date, 0, 10);
        $inputs['start_date'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
        $realTimestampEnd = substr($request->end_date, 0, 10);
        $inputs['end_date'] = date("Y-m-d H:i:s", (int)$realTimestampEnd);
        if ($inputs['type'] == 0) {
            $inputs['user_id'] = null;
        }
        $copan =   Copan::create($inputs);
        if ($copan) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 404]);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function copanUpdate(CopanRequest $request,  Copan $copan)
    {
        $inputs = $request->all();
        $realTimestampStart = substr($request->start_date, 0, 10);
        $inputs['start_date'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
        $realTimestampEnd = substr($request->end_date, 0, 10);
        $inputs['end_date'] = date("Y-m-d H:i:s", (int)$realTimestampEnd);
        if ($inputs['type'] == 0) {
            $inputs['user_id'] = null;
        }
        $copans = $copan->update($inputs);
        if ($copans) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 404]);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function copanDestroy(Copan $copan)
    {
        $copan->delete();
        return response(['status' => 200]);
    }
    public function  users()
    {
        $users =   User::all();
        if ($users) {
            return response()->json(['status' => 200, 'users' => $users]);
        } else {
            return response()->json(['status' => 404]);
        }
    }
    public function copan(Copan $copan)
    {
        if ($copan) {
            return  response()->json(['status' => 200, 'data' => new CopanResource($copan)]);
        } else {
            return response()->json(['status' => 404]);
        }
    }
    public function commonDiscounts($perPage = 0, $search = '')
    {
        switch ($perPage && $search || $perPage) {
            case  $perPage == 0:
                $paginate = 20;
                $searchVal = $search ? $search : null;
                break;
            case  $perPage == 1:
                $paginate = 30;
                $searchVal = $search ? $search : null;
                break;
            case  $perPage == 2:
                $paginate =  null;
                $searchVal = $search ? $search : null;
                break;
            default:
                $paginate =  20;
                break;
        }
        if ($paginate && $searchVal) {
            if ($paginate === null) {
                return CommonDiscountResource::collection(CommonDiscount::where('title', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
            }
            return CommonDiscountResource::collection(CommonDiscount::where('title', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->paginate($paginate));
        } else if ($paginate) {
            return CommonDiscountResource::collection(CommonDiscount::orderBy('created_at', 'desc')->paginate($paginate));
        } else if ($paginate === null) {
            return CommonDiscountResource::collection(CommonDiscount::where('title', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function commonDiscountStore(CommonDiscountRequest $request)
    {
        $inputs = $request->all();
        $realTimestampStart = substr($request->start_date, 0, 10);
        $inputs['start_date'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
        $realTimestampEnd = substr($request->end_date, 0, 10);
        $inputs['end_date'] = date("Y-m-d H:i:s", (int)$realTimestampEnd);
        $commonDiscount =  CommonDiscount::create($inputs);
        if ($commonDiscount) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 404]);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function commonDiscountUpdate(CommonDiscountRequest $request,  CommonDiscount $commonDiscount)
    {
        $inputs = $request->all();
        $realTimestampStart = substr($request->start_date, 0, 10);
        $inputs['start_date'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
        $realTimestampEnd = substr($request->end_date, 0, 10);
        $inputs['end_date'] = date("Y-m-d H:i:s", (int)$realTimestampEnd);
        $common =  $commonDiscount->update($inputs);
        return response()->json(['status' => 200]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function commonDiscountDestroy(CommonDiscount $commonDiscount)
    {
        $commonDiscount->delete();
        return response(['status' => 200]);
    }
    public function commonDiscount(CommonDiscount $commonDiscount)
    {
        if ($commonDiscount) {
            return  response()->json(['status' => 200, 'data' => new CommonDiscountResource($commonDiscount)]);
        } else {
            return response()->json(['status' => 404]);
        }
    }
    /**
     * amazingSale
     */
    public function amazingSales($perPage = 0, $search = '')
    {
        switch ($perPage && $search || $perPage) {
            case  $perPage == 0:
                $paginate = 20;
                $searchVal = $search ? $search : null;
                break;
            case  $perPage == 1:
                $paginate = 30;
                $searchVal = $search ? $search : null;
                break;
            case  $perPage == 2:
                $paginate =  null;
                $searchVal = $search ? $search : null;
                break;
            default:
                $paginate =  20;
                break;
        }
        if ($paginate && $searchVal) {
            if ($paginate === null) {
                return AmazingSaleResource::collection(AmazingSale::where('percentage', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
            }
            return AmazingSaleResource::collection(AmazingSale::where('percentage', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->paginate($paginate));
        } else if ($paginate) {
            return AmazingSaleResource::collection(AmazingSale::orderBy('created_at', 'desc')->paginate($paginate));
        } else if ($paginate === null) {
            return AmazingSaleResource::collection(AmazingSale::where('percentage', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function amazingSaleStore(AmazingSaleRequest $request)
    {
        $inputs = $request->all();
        $realTimestampStart = substr($request->start_date, 0, 10);
        $inputs['start_date'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
        $realTimestampEnd = substr($request->end_date, 0, 10);
        $inputs['end_date'] = date("Y-m-d H:i:s", (int)$realTimestampEnd);
        $amazingSales = AmazingSale::create($inputs);
        if ($amazingSales) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 404]);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function amazingSaleUpdate(AmazingSaleRequest $request,  AmazingSale $amazingSale)
    {
        $inputs = $request->all();
        $realTimestampStart = substr($request->start_date, 0, 10);
        $inputs['start_date'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
        $realTimestampEnd = substr($request->end_date, 0, 10);
        $inputs['end_date'] = date("Y-m-d H:i:s", (int)$realTimestampEnd);
        $amazingSales =  $amazingSale->update($inputs);
        return response()->json(['status' => 200]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function amazingSaleDestroy(AmazingSale $amazingSale)
    {
        $amazingSale->delete();
        return response(['status' => 200]);
    }
    public function products()
    {
        $products =     ProductResource::collection(Product::all());
        if ($products) {
            return response()->json(['status' => 200, 'products' => $products]);
        } else {
            return response()->json(['status' => 404]);
        }
    }
    public function  amazingSale(AmazingSale $amazingSale)
    {
        if ($amazingSale) {
            return  response()->json(['status' => 200, 'data' => new AmazingSaleResource($amazingSale)]);
        } else {
            return response()->json(['status' => 404]);
        }
    }
}
