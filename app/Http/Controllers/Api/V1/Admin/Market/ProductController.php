<?php

namespace App\Http\Controllers\Api\V1\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\ProductStoreRequest;
use App\Http\Requests\Admin\Market\ProductUpdateRequest;
use App\Http\Resources\Admin\Market\ProductResource;
use App\Http\Services\Image\ImageService;
use App\Models\Admin\Market\Brand;
use App\Models\Admin\Market\Product;
use App\Models\Admin\Market\ProductCategory;
use App\Models\Admin\Market\ProductMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($perPage = 0, $search = '')
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
              return ProductResource::collection(Product::with('category' , 'brand')->where('name', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
            }
          return ProductResource::collection(Product::with('category' , 'brand')->where('name', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->paginate($paginate));
          
        }
        else if($paginate){
            return ProductResource::collection(Product::with('category' , 'brand')->orderBy('created_at', 'desc')->paginate($paginate));
        }else if ($paginate === null) {
            return ProductResource::collection(Product::with('category' , 'brand')->where('name', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
          }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request,  ImageService $imageService)
    {
        $inputs = $request->all();
        //date fixed
        $realTimestampStart = substr($request->published_at, 0, 10);
        $inputs['published_at'] = date("Y-m-d H:i:s", (int)$realTimestampStart);

        if ($request->hasFile('image')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'products');
            $result = $imageService->createIndexAndSave($request->file('image'));
            if ($result ===  false) {
                return response()->json(['status' => 'تصویری دریافت نشد']);
            }
            $inputs['image'] = $result;
        }

        $var = DB::transaction(function () use ($request, $inputs) {

            $product = Product::create($inputs);
            $keys =   explode(',', $request->meta_key);

            $values=  explode(',', $request->meta_value);
           
            $metas = array_combine( $keys, $values);
            foreach ($metas as $key => $value) {
                $meta =  ProductMeta::create([
                    'meta_key' => $key,
                    'meta_value' => $value,
                    'product_id' => $product->id
                ]);
            }
            if ($product) {
            
                return response()->json(['status' => 200]);
            } else {
                return response()->json(['status' => 404]);
            }
    
        });
      return $var;
    
    }
    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
         if ($product) {
             return  response()->json(['status' => 200, 'data' => new ProductResource($product)]);
         } else {
             return response()->json(['status' => 404]);
         }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request,  Product $product , ImageService $imageService)
    {
        $inputs = $request->all();
        //date fixed
        $realTimestampStart = substr($request->published_at, 0, 10);
        $inputs['published_at'] = date("Y-m-d H:i:s", (int)$realTimestampStart);

        if ($request->hasFile('image')) {
            if (!empty($product->image)) {
                $imageService->deleteDirectoryAndFiles($product->image['directory']);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'product');
            $result = $imageService->createIndexAndSave($request->file('image'));
            if ($result === false) {
                return redirect()->route('admin.market.product.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['image'] = $result;
        } else {
            if (isset($inputs['currentImage']) && !empty($product->image)) {
                $image = $product->image;
                $image['currentImage'] = $inputs['currentImage'];
                $inputs['image'] = $image;
            }
        }
        $product->update($inputs);
        if (  $request->meta_key != null) {
            
       
        $meta_keys = $request->meta_key;
        $meta_values = $request->meta_value;
        $meta_ids = array_keys($request->meta_key);
        $metas = array_map(function ($meta_id, $meta_key, $meta_value){
            return array_combine(
                ['meta_id', 'meta_key', 'meta_value'],
                [$meta_id, $meta_key, $meta_value]
            );
        }, $meta_ids, $meta_keys, $meta_values);
        foreach($metas as $meta){
            ProductMeta::where('id', $meta['meta_id'])->update([
                'meta_key' => $meta['meta_key'], 'meta_value' => $meta['meta_value']
            ]);
        }
    }
    return response()->json(['status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     */ 
    public function destroy(Product $product)
    {
        $product->delete();
        return response(['status' => 200]);
    }

    public function status(Product $product)
    {

        $product->status =  $product->status == 0 ? 1 : 0;
        $result = $product->save();

        if ($result) {
            if ($product->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {

            return response()->json(['status' => false]);
        }
    }
    public function marketable(Product $product)
    {

        $product-> marketable =  $product->marketable == 0 ? 1 : 0;
        $result = $product->save();

        if ($result) {
            if ($product->marketable == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {

            return response()->json(['status' => false]);
        }
    }
  

    

    public function categoryAndBrand(){
        $categories = ProductCategory::all();
        $brands = Brand::all();
        if($categories && $brands ){
            return response()->json(['status'=>200 , 'categories' =>$categories , 'brands' =>$brands ]);
          }else{
            return response()->json(['status'=>404 ]);
            
          }
    }
}
