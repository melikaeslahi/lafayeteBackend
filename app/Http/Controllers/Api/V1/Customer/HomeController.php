<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Content\MenuResource;
use App\Http\Resources\Admin\Content\PostResource;
use App\Http\Resources\Admin\Content\SliderResource;
use App\Http\Resources\Admin\Market\BrandResource;
use App\Http\Resources\Admin\Market\ProductCategoryResource;
use App\Http\Resources\Admin\Market\ProductResource as MarketProductResource;
use App\Http\Resources\Customer\Market\ProductCollection;
use App\Http\Resources\Customer\Market\ProductResource;
use App\Models\Admin\Content\Banner;
use App\Models\Admin\Content\Faq;
use App\Models\Admin\Content\Menu;
use App\Models\Admin\Content\Page;
use App\Models\Admin\Content\Post;
use App\Models\Admin\Content\Slider;
use App\Models\Admin\Market\Brand;
use App\Models\Admin\Market\Product;
use App\Models\Admin\Market\ProductCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $bannerSlideShow =  Banner::where('position', 0)->where('status', 1)->get();
        $middleBanner =  Banner::where('position', 1)->where('status', 1)->take(2)->get();
        $bottomBanner =  Banner::where('position', 2)->take(1)->get();
        $collections =  Banner::where('position', 3)->take(3)->get();

        $brands =  Brand::all();
        $sliders = SliderResource::collection(Slider::with(['children.products', 'products'])->where('parent_id', null)->get());
        $newBlog =    PostResource::collection(Post::orderBy('created_at', 'desc')->where('status', 1)->take(3)->get());

        return response()->json([
            'status' => 200,
            'bannerSlideShow' => $bannerSlideShow,
            'middleBanner' => $middleBanner,
            'bottomBanner' => $bottomBanner,
            'brands' => $brands,
            'sliders' => $sliders,
            'newBlogs' => $newBlog,
            'collections'=>$collections
        ]);
    }
    public function products(Request $request, ProductCategory $category = null)
    {
        // dd($request->all());
        $brands = Brand::all();

        $categories = ProductCategory::whereNull('parent_id')->with('children')->get();

        if ($category)
            $productModel = $category->products();
        else
            $productModel = new  Product();

        switch ($request->sort) {
            case '1':
                $column = 'created_at';
                $direction = 'DESC';
                break;
            case '2':
                $column = 'price';
                $direction = 'DESC';
                break;
            case '3':
                $column = 'price';
                $direction = 'ASC';
                break;
            case '4':
                $column = 'created_at';
                $direction = 'DESC';
                break;
            case '5':
                $column = 'sold_number';
                $direction = 'DESC';
                break;
            default:
                $column = 'created_at';
                $direction = 'ASC';
        }

        if ($request->search) {
            $query = $productModel->where('name', 'LIKE', '%' . $request->search . '%')->orderBy($column, $direction);
        } else {
            $query = $productModel->orderBy($column, $direction);
        }
        $products = $request->min_price && $request->max_price ? $query->whereBetween('price', [$request->min_price, $request->max_price]) :
            $query->when($request->min_price, function ($query) use ($request) {
                $query->where('price', '>=', $request->min_price)->get();
            })->when($request->max_price, function ($query) use ($request) {
                $query->where('price', '<=', $request->max_price)->get();
            })->when(!($request->min_price && $request->max_price), function ($query) {

                $query->get();
            });

        $products = $products->paginate(20);
        $products->appends($request->query());
        // dd($products);

        $selectedBrandArray = [];
        if ($request->brand) {
            $selectedBrands = Brand::find($request->brand);
            foreach ($selectedBrands as $selectedBrand) {
                array_push($selectedBrandArray, $selectedBrand->original_name);
            }
        }
        return response()->json([
            'status' => 200,
            'products' =>  MarketProductResource::collection($products->load('metas', 'colors' ,'values')),
            'brands' => BrandResource::collection($brands),
            'selectedBrandArray' => BrandResource::collection($selectedBrandArray),
            'categories' =>  ProductCategoryResource::collection($categories)
        ]);
    }

    public function pages(){

    $pages = Page::where('status' , 1)->get();
    return response()->json(['pages'=>$pages]);

    }

    public function page(Page $page){

    return response()->json(['page' => $page]);

    }

     public function  faqs(){

$faqs =  Faq::where('status' , 1)->get();
return response()->json(['faqs'=>$faqs]);

}

public function menus(){
   $menus = Menu::with( 'postCategory' ,'children'  , 'productCategory')->where('status' , 1 )->where('parent_id' , null)->get();
   return response()->json(['status'=>  200  , 'menus'=> MenuResource::collection($menus)]);

}
}
