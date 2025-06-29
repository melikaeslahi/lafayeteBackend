<?php

use App\Http\Controllers\Api\V1\Admin\Content\BannerController;
use App\Http\Controllers\Api\V1\Admin\Content\CategoryController;
use App\Http\Controllers\Api\V1\Admin\Content\CommentController;
use App\Http\Controllers\Api\V1\Admin\Content\FaqController;
use App\Http\Controllers\Api\V1\Admin\Content\MenuController;
use App\Http\Controllers\Api\V1\Admin\Content\PageController;
use App\Http\Controllers\Api\V1\Admin\Content\PostController;
use App\Http\Controllers\Api\V1\Admin\Content\SliderController;
use App\Http\Controllers\Api\V1\Admin\Market\BrandController;
use App\Http\Controllers\Api\V1\Admin\Market\CategoryController as MarketCategoryController;
use App\Http\Controllers\Api\V1\Admin\Market\CommentController as MarketCommentController;
use App\Http\Controllers\Api\V1\Admin\Market\DeliveryController;
use App\Http\Controllers\Api\V1\Admin\Market\DiscountController;
use App\Http\Controllers\Api\V1\Admin\Market\GalleryController;
use App\Http\Controllers\Api\V1\Admin\Market\OrderController;
use App\Http\Controllers\Api\V1\Admin\Market\PaymentController;
use App\Http\Controllers\Api\V1\Admin\Market\ProductColorController;
use App\Http\Controllers\Api\V1\Admin\Market\ProductController;
use App\Http\Controllers\Api\V1\Admin\Market\ProductSizeController;
use App\Http\Controllers\Api\V1\Admin\Market\PropertyController;
use App\Http\Controllers\Api\V1\Admin\Market\PropertyValueController;
use App\Http\Controllers\Api\V1\Admin\Market\StoreController;
use App\Http\Controllers\Api\V1\Admin\Notify\EmailController;
use App\Http\Controllers\Api\V1\Admin\Notify\SMSController;
use App\Http\Controllers\Api\V1\Admin\Setting\SettingController;
use App\Http\Controllers\Api\V1\Admin\Ticket\TicketAdminController;
use App\Http\Controllers\Api\V1\Admin\Ticket\TicketCategoryController;
use App\Http\Controllers\Api\V1\Admin\Ticket\TicketController;
use App\Http\Controllers\Api\V1\Admin\Ticket\TicketPriorityController;
use App\Http\Controllers\Api\V1\Admin\User\AdminUserController;
use App\Http\Controllers\Api\V1\Admin\User\CustomerController;
use App\Http\Controllers\Api\V1\Admin\User\PermissionController;
use App\Http\Controllers\Api\V1\Admin\User\RoleController;
use App\Http\Controllers\Api\V1\Auth\Customer\LoginRegisterController;
use App\Http\Controllers\Api\V1\Customer\HomeController;
use App\Http\Controllers\Api\V1\Customer\Market\ProductController as MarketProductController;
use App\Http\Controllers\Api\V1\Customer\Profile\AddressController as ProfileAddressController;
use App\Http\Controllers\Api\V1\Customer\Profile\FavoriteController;
use App\Http\Controllers\Api\V1\Customer\Profile\OrderController as ProfileOrderController;
use App\Http\Controllers\Api\V1\Customer\Profile\ProfileController;
use App\Http\Controllers\Api\V1\Customer\Profile\TicketController as ProfileTicketController;
use App\Http\Controllers\Api\V1\Customer\SalesProccess\AddressController;
use App\Http\Controllers\Api\V1\Customer\SalesProccess\CartItemController;
use App\Http\Controllers\Api\V1\Customer\SalesProccess\PaymentController as SalesProccessPaymentController;
use App\Http\Controllers\Api\V1\Customer\SalesProccess\ProfileCompletionController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->auth()->user();
// });

Route::prefix('v1/admin')->namespace('Admin')->group(function () {


    //content

    Route::prefix('content')->namespace('Content')->group(function () {

        //postCategory
        Route::prefix('category')->group(function () {
            Route::get('/{perPage?}/{search?}', [CategoryController::class, 'index'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ\آ]+']);
            Route::get('/status/{postCategory}', [CategoryController::class, 'status']);
            Route::post('/store', [CategoryController::class, 'store']);
            Route::delete('/delete/{postCategory}', [CategoryController::class, 'destroy']);
            Route::put('/update/{postCategory}', [CategoryController::class, 'update']);
            Route::get('/category/{postCategory}', [CategoryController::class, 'show']);
            Route::get('/parentId', [CategoryController::class, 'parentId']);
        });

        //posts
        Route::prefix('posts')->group(function () {
            Route::get('/{perPage?}/{search?}', [PostController::class, 'index'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ\آ]+']);
            Route::get('/status/{post}', [PostController::class, 'status']);
            Route::get('/commentable/{post}', [PostController::class, 'commentable']);
            Route::post('/store', [PostController::class, 'store']);
            Route::delete('/delete/{post}', [PostController::class, 'destroy']);
            Route::put('/update/{post}', [PostController::class, 'update']);
            Route::get('/post/{post}', [PostController::class, 'show']);
            Route::get('/category', [PostController::class, 'category']);
        });

        //banner
        Route::prefix('banner')->group(function () {
            Route::get('/{perPage?}/{search?}', [BannerController::class, 'index'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ\آ]+']);
            Route::get('/status/{banner}', [BannerController::class, 'status']);
            Route::get('/position', [BannerController::class, 'position']);
            Route::post('/store', [BannerController::class, 'store']);
            Route::delete('/delete/{banner}', [BannerController::class, 'destroy']);
            Route::get('/banner/{banner}', [BannerController::class, 'show']);
            Route::put('/update/{banner}', [BannerController::class, 'update']);
            Route::get('/parentId', [CategoryController::class, 'parentId']);
        });

        //menu
        Route::prefix('menus')->group(function () {
            Route::get('/{perPage?}/{search?}', [MenuController::class, 'index'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ]+']);
            Route::get('/status/{menu}', [MenuController::class, 'status']);
            Route::post('/store', [MenuController::class, 'store']);
            Route::delete('/delete/{menu}', [MenuController::class, 'destroy']);
            Route::put('/update/{menu}', [MenuController::class, 'update']);
            Route::get('/menu/{menu}', [MenuController::class, 'show']);
            Route::get('/parentId', [MenuController::class, 'parentId']);
        });

        //faq
        Route::prefix('faq')->group(function () {
            Route::get('/{perPage?}/{search?}', [FaqController::class, 'index'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ]+']);
            Route::get('/status/{faq}', [FaqController::class, 'status']);
            Route::post('/store', [FaqController::class, 'store']);
            Route::delete('/delete/{faq}', [FaqController::class, 'destroy']);
            Route::put('/update/{faq}', [FaqController::class, 'update']);
            Route::get('/faq/{faq}', [FaqController::class, 'show']);
        });

        //pages
        Route::prefix('page')->group(function () {
            Route::get('/{perPage?}/{search?}', [PageController::class, 'index'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ]+']);
            Route::get('/status/{page}', [PageController::class, 'status']);
            Route::post('/store', [PageController::class, 'store']);
            Route::delete('/delete/{page}', [PageController::class, 'destroy']);
            Route::put('/update/{page}', [PageController::class, 'update']);
            Route::get('/page/{page}', [PageController::class, 'show']);
        });

        //comment
        Route::prefix('comment')->group(function () {
            Route::get('/{perPage?}/{search?}', [CommentController::class, 'index'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ]+']);
            Route::get('/comment/{comment}', [CommentController::class, 'show']);

            Route::get('/status/{comment}', [CommentController::class, 'status']);
            Route::get('/approved/{comment}', [CommentController::class, 'approved']);
            Route::post('/answer/{comment}', [CommentController::class, 'answer']);
        });

        Route::prefix('slider')->group(function () {
            Route::get('/{perPage?}/{search?}', [SliderController::class, 'index'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ]+']);
            Route::get('/status/{slider}', [SliderController::class, 'status']);
            Route::post('/store', [SliderController::class, 'store']);
            Route::delete('/delete/{slider}', [SliderController::class, 'destroy']);
            Route::put('/update/{slider}', [SliderController::class, 'update']);
            Route::get('/show/{slider}', [SliderController::class, 'show']);
            Route::get('/products/{slider}', [SliderController::class, 'products']);
            Route::post('/products/store/{slider}', [SliderController::class, 'productsStore']);
            Route::get('/parentId', [SliderController::class, 'parentId']);
        });
    });

    //market

    Route::prefix('market')->namespace('Market')->group(function () {

        //productCategory
        Route::prefix('category')->group(function () {
            Route::get('/{perPage?}/{search?}', [MarketCategoryController::class, 'index'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ]+']);
            Route::get('/status/{productCategory}', [MarketCategoryController::class, 'status']);
            Route::get('/showInMenu/{productCategory}', [MarketCategoryController::class, 'showInMenu']);
            Route::post('/store', [MarketCategoryController::class, 'store']);
            Route::delete('/delete/{productCategory}', [MarketCategoryController::class, 'destroy']);
            Route::put('/update/{productCategory}', [MarketCategoryController::class, 'update']);
            Route::get('/category/{productCategory}', [MarketCategoryController::class, 'show']);
            Route::get('/parentId', [MarketCategoryController::class, 'parentId']);
        });

        //brands
        Route::prefix('brand')->group(function () {
            Route::get('/{perPage?}/{search?}', [BrandController::class, 'index'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ\آ]+']);
            Route::get('/status/{brand}', [BrandController::class, 'status']);
            Route::post('/store', [BrandController::class, 'store']);
            Route::delete('/delete/{brand}', [BrandController::class, 'destroy']);
            Route::put('/update/{brand}', [BrandController::class, 'update']);
            Route::get('/brand/{brand}', [BrandController::class, 'show']);
        });

        //comment
        Route::prefix('comment')->group(function () {
            Route::get('/{perPage?}/{search?}', [MarketCommentController::class, 'index'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ]+']);
            Route::get('/comment/{comment}', [MarketCommentController::class, 'show']);

            Route::get('/status/{comment}', [MarketCommentController::class, 'status']);
            Route::get('/approved/{comment}', [MarketCommentController::class, 'approved']);
            Route::post('/answer/{comment}', [MarketCommentController::class, 'answer']);
        });

        //products  
        Route::prefix('product')->group(function () {
            Route::get('/{perPage?}/{search?}', [ProductController::class, 'index'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ]+']);
            Route::get('/status/{product}', [ProductController::class, 'status']);
            Route::get('/marketable/{product}', [ProductController::class, 'marketable']);
            Route::post('/store', [ProductController::class, 'store']);
            Route::delete('/delete/{product}', [ProductController::class, 'destroy']);
            Route::put('/update/{product}', [ProductController::class, 'update']);
            Route::get('/product/{product}', [ProductController::class, 'show']);
            Route::get('/categoryAndBrand', [ProductController::class, 'categoryAndBrand']);

            //gallery  
            Route::prefix('gallery')->group(function () {
                Route::get('/{perPage?}/{product}', [GalleryController::class, 'index'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ]+']);

                Route::post('/store/{product}', [GalleryController::class, 'store']);
                Route::delete('/delete/{gallery}', [GalleryController::class, 'destroy']);
            });
            //colors  
            Route::prefix('colors')->group(function () {
                Route::get('/{perPage?}/{product}/{search?}', [ProductColorController::class, 'index'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ]+']);

                Route::post('/store/{product}', [ProductColorController::class, 'store']);
                Route::delete('/delete/{product}', [ProductColorController::class, 'destroy']);
            });
            //sizes 
            Route::prefix('sizes')->group(function () {
                Route::get('/{perPage?}/{product}/{search?}', [ProductSizeController::class, 'index'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ]+']);

                Route::post('/store/{product}', [ProductSizeController::class, 'store']);
                Route::delete('/delete/{product}', [ProductSizeController::class, 'destroy']);
            });
        });
        //property
        Route::prefix('property')->group(function () {
            Route::get('/{perPage?}/{search?}', [PropertyController::class, 'index'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ]+']);
            Route::post('/store', [PropertyController::class, 'store']);
            Route::delete('/delete/{categoryAttribute}', [PropertyController::class, 'destroy']);
            Route::put('/update/{categoryAttribute}', [PropertyController::class, 'update']);
            Route::get('/category', [PropertyController::class, 'category']);
            Route::get('/attribute/{categoryAttribute}', [PropertyController::class, 'show']);

            //propertyValue 
            Route::prefix('value')->group(function () {
                Route::get('/{perPage?}/{categoryAttribute}', [PropertyValueController::class, 'index'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ]+']);
                Route::post('/store/{categoryAttribute}', [PropertyValueController::class, 'store']);
                Route::delete('/delete/{categoryValue}', [PropertyValueController::class, 'destroy']);
                Route::put('/update/{categoryAttribute}/{categoryValue}', [PropertyValueController::class, 'update']);
                Route::get('/value/{categoryValue}', [PropertyValueController::class, 'show']);
                Route::get('/productsAndAttributes', [PropertyValueController::class, 'productsAndAttributes']);
            });
        });

        //store 
        Route::prefix('store')->group(function () {
            Route::get('/{perPage?}/{search?}', [StoreController::class, 'index'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ]+']);
            Route::post('/store/{product}', [StoreController::class, 'store']);
            Route::get('/product/{product}', [StoreController::class, 'show']);
            Route::put('/update/{product}', [StoreController::class, 'update']);
        });


        //disCount
        Route::prefix('discount')->group(function () {

            //copans
            Route::prefix('copan')->group(function () {
                Route::get('/{perPage?}/{search?}', [DiscountController::class, 'copans'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ\-۰-۹-0-9-آ]+']);
                Route::post('/store', [DiscountController::class, 'copanStore']);
                Route::delete('/delete/{copan}', [DiscountController::class, 'copanDestroy']);
                Route::put('/update/{copan}', [DiscountController::class, 'copanUpdate']);
                Route::get('/copan/{copan}', [DiscountController::class, 'copan']);
                Route::get('/users', [DiscountController::class, 'users']);
            });

            //commonDiscount
            Route::prefix('commonDiscount')->group(function () {
                Route::get('/{perPage?}/{search?}', [DiscountController::class, 'commonDiscounts'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ]+']);
                Route::post('/store', [DiscountController::class, 'commonDiscountStore']);
                Route::delete('/delete/{copan}', [DiscountController::class, 'commonDiscountDestroy']);
                Route::put('/update/{copan}', [DiscountController::class, 'commonDiscountUpdate']);
                Route::get('/commonDiscount/{commonDiscount}', [DiscountController::class, 'commonDiscount']);
            });

            //amazingSale
            Route::prefix('amazingSale')->group(function () {
                Route::get('/{perPage?}/{search?}', [DiscountController::class, 'amazingSales'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ]+']);
                Route::post('/store', [DiscountController::class, 'amazingSaleStore']);
                Route::delete('/delete/{copan}', [DiscountController::class, 'amazingSaleDestroy']);
                Route::put('/update/{copan}', [DiscountController::class, 'amazingSaleUpdate']);
                Route::get('/amazingSale/{amazingSale}', [DiscountController::class, 'amazingSale']);
                Route::get('/product', [DiscountController::class, 'products']);
            });
        });
        //delivery
        Route::prefix('delivery')->group(function () {
            Route::get('/{perPage?}/{search?}', [DeliveryController::class, 'index'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ]+']);
            Route::post('/store', [DeliveryController::class, 'store']);
            Route::delete('/delete/{delivery}', [DeliveryController::class, 'destroy']);
            Route::put('/update/{delivery}', [DeliveryController::class, 'update']);
            Route::get('/delivery/{delivery}', [DeliveryController::class, 'show']);
        });

        //payments
        Route::prefix('payment')->group(function () {
            Route::get('/all/{perPage?}/{search?}', [PaymentController::class, 'all'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ]+']);
            Route::get('/online/{perPage?}/{search?}', [PaymentController::class, 'online'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ]+']);
            Route::get('/offline/{perPage?}/{search?}', [PaymentController::class, 'offline'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ]+']);
            Route::get('/cash/{perPage?}/{search?}', [PaymentController::class, 'cash'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ]+']);
            Route::get('/canceled/{payment}', [PaymentController::class, 'canceled']);
            Route::get('/returned/{payment}', [PaymentController::class, 'returned']);
            Route::get('/show/{payment}', [PaymentController::class, 'show']);
        });

        //orders
        Route::prefix('order')->group(function () {
            Route::get('/all/{perPage?}/{search?}', [OrderController::class, 'all'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ]+']);
            Route::get('/newOrders/{perPage?}/{search?}', [OrderController::class, 'newOrders'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ]+']);
            Route::get('/sending/{perPage?}/{search?}', [OrderController::class, 'sending'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ]+']);
            Route::get('/unpaind/{perPage?}/{search?}', [OrderController::class, 'unpaind'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ]+']);
            Route::get('/canceled/{perPage?}/{search?}', [OrderController::class, 'canceled'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ]+']);
            Route::get('/returned/{perPage?}/{search?}', [OrderController::class, 'returned'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ]+']);
            Route::get('/changeSendStatus/{order}', [OrderController::class, 'changeSendStatus']);
            Route::get('/changeOrderStatus/{order}', [OrderController::class, 'changeOrderStatus']);
            Route::get('/cancelOrder/{order}', [OrderController::class, 'cancelOrder']);
            Route::get('/show/{order}', [OrderController::class, 'show']);
            Route::get('/detailOrder/{id}', [OrderController::class, 'detailOrder']);
        });
    });

    //tickets
    Route::prefix('ticket')->namespace('Ticket')->group(function () {
        Route::get('/newTickets/{perPage?}/{search?}', [TicketController::class, 'newTickets'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ]+']);
        Route::get('/openTickets/{perPage?}/{search?}', [TicketController::class, 'openTickets'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ]+']);
        Route::get('/all/{perPage?}/{search?}', [TicketController::class, 'index'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ]+']);
        Route::get('/closeTickets/{perPage?}/{search?}', [TicketController::class, 'closeTickets'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ]+']);
        Route::post('/answer/{ticket}', [TicketController::class, 'answer']);
        Route::get('/show/{ticket}', [TicketController::class, 'show']);
        Route::get('/change/{ticket}', [TicketController::class, 'change']);

        //ticketCategory
        Route::prefix('category')->group(function () {
            Route::get('/{perPage?}/{search?}', [TicketCategoryController::class, 'index'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ]+']);
            Route::get('/status/{ticketCategory}', [TicketCategoryController::class, 'status']);

            Route::post('/store', [TicketCategoryController::class, 'store']);
            Route::delete('/delete/{ticketCategory}', [TicketCategoryController::class, 'destroy']);
            Route::put('/update/{ticketCategory}', [TicketCategoryController::class, 'update']);
            Route::get('/ticketCategory/{ticketCategory}', [TicketCategoryController::class, 'show']);
        });

        //ticketPriority         
        Route::prefix('priority')->group(function () {
            Route::get('/{perPage?}/{search?}', [TicketPriorityController::class, 'index'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ]+']);
            Route::get('/status/{ticketPriority}', [TicketPriorityController::class, 'status']);
            Route::post('/store', [TicketPriorityController::class, 'store']);
            Route::delete('/delete/{ticketPriority}', [TicketPriorityController::class, 'destroy']);
            Route::put('/update/{ticketPriority}', [TicketPriorityController::class, 'update']);
            Route::get('/ticketPriority/{ticketPriority}', [TicketPriorityController::class, 'show']);
        });

        Route::prefix('admin')->group(function () {
            Route::get('/{perPage?}/{search?}', [TicketAdminController::class, 'index'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ]+']);
            Route::get('/set/{admin}', [TicketPriorityController::class, 'set']);
        });
    });


    //setting
    Route::prefix('setting')->namespace('Setting')->group(function () {
        Route::get('/{perPage?}/{search?}', [SettingController::class, 'index'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ]+']);
        Route::put('/update/{setting}', [SettingController::class, 'update']);
        Route::get('/setting/{setting}', [SettingController::class, 'show']);
    });


    //notify
    Route::prefix('notify')->namespace('Notify')->group(function () {
        //email
        Route::prefix('email')->group(function () {
            Route::get('/{perPage?}/{search?}', [EmailController::class, 'index'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ]+']);
            Route::get('/status/{email}', [EmailController::class, 'status']);
            Route::post('/store', [EmailController::class, 'store']);
            Route::delete('/delete/{email}', [EmailController::class, 'destroy']);
            Route::put('/update/{email}', [EmailController::class, 'update']);
            Route::get('/email/{email}', [EmailController::class, 'show']);
        });
        //sms
        Route::prefix('sms')->group(function () {
            Route::get('/{perPage?}/{search?}', [SMSController::class, 'index'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ]+']);
            Route::get('/status/{sms}', [SMSController::class, 'status']);
            Route::post('/store', [SMSController::class, 'store']);
            Route::delete('/delete/{sms}', [SMSController::class, 'destroy']);
            Route::put('/update/{sms}', [SMSController::class, 'update']);
            Route::get('/sms/{sms}', [SMSController::class, 'show']);
        });
        //emailFile
        Route::prefix('emailFile')->group(function () {
            Route::get('/{perPage?}/{search?}', [MarketCategoryController::class, 'index'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ]+']);
            Route::get('/status/{productCategory}', [MarketCategoryController::class, 'status']);
            Route::get('/showInMenu/{productCategory}', [MarketCategoryController::class, 'showInMenu']);
            Route::post('/store', [MarketCategoryController::class, 'store']);
            Route::delete('/delete/{productCategory}', [MarketCategoryController::class, 'destroy']);
            Route::put('/update/{productCategory}', [MarketCategoryController::class, 'update']);
            Route::get('/category/{id}', [MarketCategoryController::class, 'category']);
            Route::get('/parentId', [MarketCategoryController::class, 'parentId']);
        });
    });


    //users

    Route::prefix('user')->namespace('User')->group(function () {
        //adminUser
        Route::prefix('adminUser')->group(function () {
            Route::get('/{perPage?}/{search?}', [AdminUserController::class, 'index'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ]+']);
            Route::get('/status/{admin}', [AdminUserController::class, 'status']);
            Route::get('/activation/{admin}', [AdminUserController::class, 'activation']);
            Route::post('/store', [AdminUserController::class, 'store']);
            Route::delete('/delete/{admin}', [AdminUserController::class, 'destroy']);
            Route::put('/update/{admin}', [AdminUserController::class, 'update']);
            Route::get('/admin/{admin}', [AdminUserController::class, 'show']);
            Route::get('/roles/{admin}', [AdminUserController::class, 'roles']);
            Route::get('/permissions/{admin}', [AdminUserController::class, 'permissions']);
            Route::post('/rolesStore/{admin}', [AdminUserController::class, 'rolesStore']);
            Route::post('/permissionsStore/{admin}', [AdminUserController::class, 'permissionsStore']);
        });
        //customer
        Route::prefix('customer')->group(function () {
            Route::get('/{perPage?}/{search?}', [CustomerController::class, 'index'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ]+']);
            Route::get('/status/{customer}', [CustomerController::class, 'status']);
            Route::get('/activation/{customer}', [CustomerController::class, 'activation']);
            Route::post('/store', [CustomerController::class, 'store']);
            Route::delete('/delete/{customer}', [CustomerController::class, 'destroy']);
            Route::put('/update/{customer}', [CustomerController::class, 'update']);
            Route::get('/customer/{user}', [CustomerController::class, 'show']);
        });

        //permissoins
        Route::prefix('permission')->group(function () {
            Route::get('/{perPage?}/{search?}', [PermissionController::class, 'index'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ]+']);
            Route::post('/store', [PermissionController::class, 'store']);
            Route::delete('/delete/{permission}', [PermissionController::class, 'destroy']);
            Route::put('/update/{permission}', [PermissionController::class, 'update']);
            Route::get('/permission/{permission}', [PermissionController::class, 'show']);
        });
        //roles
        Route::prefix('role')->group(function () {
            Route::get('/{perPage?}/{search?}', [RoleController::class, 'index'])->where(['perPage' => '[0-2]+', 'search' => '[ا-یa-zA-Z\آ]+']);
            Route::post('/store', [RoleController::class, 'store']);
            Route::delete('/delete/{role}', [RoleController::class, 'destroy']);
            Route::put('/update/{role}', [RoleController::class, 'update']);
            Route::get('/role/{role}', [RoleController::class, 'show']);
        });
    });
});
Route::post('/login-register', [  LoginRegisterController::class, 'loginRegister']);
Route::get('/login-confirm-form/{token}', [LoginRegisterController::class, 'loginConfirmForm'])->where(['token' => '[a-zA-Z0-9]+']);
Route::get('/login-confirm/{token}', [LoginRegisterController::class, 'loginConfirmForm']);
Route::post('/login-confirm/{token}', [LoginRegisterController::class, 'loginConfirm'])->where(['token' => '[a-zA-Z0-9]+']);
Route::get('/login-resend-otp/{token}', [LoginRegisterController::class, 'loginResendOtp']);
Route::get('/logout', [LoginRegisterController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/user', function () {
    
    // return auth()->user();
    if(auth()->user()){
    return response()->json(['status'=>200 , 'user'=>new UserResource(auth()->user()) ]);
 }else{
    return response()->json(['status'=>404 ]);

 }
});


Route::prefix('v1/customer')->namespace('Customer')->group(function () {
     
    Route::get('/', [HomeController::class, 'home']);
    Route::get('/products/{category?}',  [HomeController::class, 'products']);
    Route::get('/page/{page:slug}', [HomeController::class, 'page']);
    Route::get('/faqs', [HomeController::class, 'faqs']);
    Route::get('/pages', [HomeController::class, 'pages']);
    Route::get('/menus', [HomeController::class, 'menus']);


     



    Route::prefix('profile')->group(function () {
      Route::put('/profile/update' , [ProfileController::class , 'update'] );
      Route::get('/province' , [ProfileAddressController::class , 'index'] );
      Route::get('/orders' , [ProfileOrderController::class , 'index'] );
      Route::get('orders/detail/{order}' , [ProfileOrderController::class , 'details'] );
      Route::get('orders/show/{order}' , [ProfileOrderController::class , 'show'] );
      Route::delete('/favorite/delete/{product}', [ FavoriteController::class, 'delete']);
      Route::get('/my-tickets' , [ ProfileTicketController::class , 'index'] ); 
      Route::get('/my-tickets/show/{ticket}' , [ ProfileTicketController::class , 'show'] );
      Route::get('/my-tickets/change/{ticket}' , [ ProfileTicketController::class , 'change'] );
      Route::post('/my-tickets/answer/{ticket}' , [ ProfileTicketController::class , 'awnser'] );
      Route::get('/my-tickets/create' , [ ProfileTicketController::class , 'create'] );
      Route::post('/my-tickets/store' , [ ProfileTicketController::class , 'store'] );

    });

    
    Route::prefix('market')->group(function () {
        Route::get('/product/{product:slug}' , [ MarketProductController::class , 'product'] );
        Route::get('/add-to-favorite/product/{product}' , [MarketProductController::class , 'addToFavorite'] );
        Route::post('/add-comment/product/{product}' , [MarketProductController::class , 'addComment'] );
        Route::post('/add-rate/prodcut/{product:slug}', [MarketProductController::class, 'addRate']);
        Route::get('/add-to-compare/prodcut/{product:slug}', [MarketProductController::class, 'addToCompare']);
  
      });
  
    Route::prefix('salesProccess')->group(function () {
        //cart item
        Route::get('/cart' , [CartItemController::class , 'cart'] );
        Route::post('/add-to-cart/{product}' , [CartItemController::class , 'addToCart'] );
        Route::put('/update-cart' , [CartItemController::class , 'updateCart'] );
        Route::delete('/remove-from-cart/{cartItem}' , [CartItemController::class , 'removeFromCart'] );
       

        
        //profileCompletion is middlewere =>should write
        // Route::middleware('profileCompletion')->group(function () {
            
        //address
        Route::get('/address-and-delivery' , [AddressController::class , 'addressAndDelivery'] );
        Route::post('/add-address' , [AddressController::class , 'addAddress'] );
        Route::put('/update-address/{address}' , [AddressController::class , 'updateAddress'] );
        Route::get('/get-cities/{province}' , [AddressController::class , 'getCities'] );
        Route::post('/choose-address-and-delivery' , [AddressController::class , 'chooseAddressAndDelivery'] );
        //payment
        Route::get('/payment' , [SalesProccessPaymentController::class , 'payment'] );
        Route::post('/copan-discount', [SalesProccessPaymentController::class, 'copanDiscount']) ;
        Route::post('/payment-submit', [SalesProccessPaymentController::class, 'paymentSubmit']) ;
        Route::any('/payment-callback/{order}/{onlinePayment}', [SalesProccessPaymentController::class, 'paymentCallback'])->name('customer.sales-proccess.payment-callback');

        // });

        //profile completion
        Route::get('/profile-completion' , [ ProfileCompletionController::class , 'profileCompletion'] );
        Route::post('/profile-completion/update' , [ ProfileCompletionController::class , 'update'] );


      });

   
});
