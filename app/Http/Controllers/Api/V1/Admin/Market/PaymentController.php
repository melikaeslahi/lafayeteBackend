<?php

namespace App\Http\Controllers\Api\V1\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Market\PaymentResource;
use App\Models\Admin\Market\CashPayment;
use App\Models\Admin\Market\OfflinePayment;
use App\Models\Admin\Market\OnlinePayment;
use App\Models\Admin\Market\Payment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo;
 
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function all($perPage = 0, $search = '')
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
                return PaymentResource::collection( Payment::with(['user',  'paymentable'=> function (MorphTo $morphTo){
                  
                    $morphTo->constrain([
                         OnlinePayment::class => function ( Builder $query) {
                            $query->select('id' , 'amount' , 'transaction_id' ,'gateway');
                        },
                         OfflinePayment::class => function (Builder $query) {
                            $query->select('id' , 'amount' , 'transaction_id' , 'pay_date');
                        },
                        CashPayment::class => function (Builder $query) {
                            $query->select('id' , 'amount' , 'cash_receiver' , 'pay_date');
                        },
                    ]);

                }])->where('amount', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
            }
            return PaymentResource::collection(Payment::with(['user' , 'paymentable' => function (MorphTo $morphTo){
                  
                $morphTo->constrain([
                    OnlinePayment::class => function (Builder $query) {
                       $query->select('id' , 'amount' , 'transaction_id' ,'gateway');
                   },
                    OfflinePayment::class => function (Builder $query) {
                       $query->select('id' , 'amount' ,  'transaction_id' , 'pay_date');
                   },
                   CashPayment::class => function (Builder $query) {
                    $query->select('id' , 'amount' , 'cash_receiver' , 'pay_date');
                },
               ]);

            }])-> where('amount', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->paginate($paginate));
        } else if ($paginate) {
            return PaymentResource::collection(Payment:: with(['user' , 'paymentable'=> function (MorphTo $morphTo){
                  
                $morphTo->constrain([
                    OnlinePayment::class => function (Builder $query) {
                       $query->select('id' , 'amount' ,'transaction_id' ,'gateway');
                   },
                    OfflinePayment::class => function (Builder $query) {
                       $query->select('id' , 'amount' , 'transaction_id' , 'pay_date');
                   },
                   CashPayment::class => function (Builder $query) {
                    $query->select('id' , 'amount' , 'cash_receiver' , 'pay_date');
                },
               ]);

            }])->orderBy('created_at', 'desc')->paginate($paginate));
        } else if ($paginate === null) {
            return PaymentResource::collection(Payment::with(['user' , 'paymentable'=> function (MorphTo $morphTo){
                  
                $morphTo->constrain([
                    OnlinePayment::class => function (Builder $query) {
                       $query->select('id' , 'amount' ,'transaction_id' ,'gateway');
                   },
                    OfflinePayment::class => function (Builder $query) {
                       $query->select('id' , 'amount' ,  'transaction_id' , 'pay_date');
                   },
                    CashPayment::class => function (Builder $query) {
                    $query->select('id' , 'amount' , 'cash_receiver' , 'pay_date');
                },
               ]);

            }])->where('amount', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
        }
    }

    /**
     * Store a newly created resource in storage.
     */


    /**
     * Store a newly created resource in storage.
     */
    public function offline($perPage = 0, $search = '')
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
                return PaymentResource::collection(Payment::with(['user' , 'paymentable'=> function (MorphTo $morphTo){
                  
                    $morphTo->constrain([
                       
                        OfflinePayment::class => function (Builder $query) {
                           $query->select('id' , 'amount' ,  'transaction_id' , 'pay_date');
                       },
                     
                   ]);
    
                }])->where('amount', 'like',  '%' . $search . '%')->where('paymentable_type', 'App\Models\Admin\Market\OfflinePayment')->orderBy('created_at', 'desc')->get());
            }
            return PaymentResource::collection(Payment::with(['user' , 'paymentable'=> function (MorphTo $morphTo){
                  
                $morphTo->constrain([
                  
                    OfflinePayment::class => function (Builder $query) {
                       $query->select('id' , 'amount' ,  'transaction_id' , 'pay_date');
                   },
               
               ]);

            }])->where('amount', 'like',  '%' . $searchVal . '%')->where('paymentable_type', 'App\Models\Admin\Market\OfflinePayment')->orderBy('created_at', 'desc')->paginate($paginate));
        } else if ($paginate) {
            return PaymentResource::collection(Payment::with(['user' , 'paymentable'=> function (MorphTo $morphTo){
                  
                $morphTo->constrain([
               
                    OfflinePayment::class => function (Builder $query) {
                       $query->select('id' , 'amount' ,  'transaction_id' , 'pay_date');
                   },
               
               ]);

            }])->where('paymentable_type', 'App\Models\Admin\Market\OfflinePayment')->orderBy('created_at', 'desc')->paginate($paginate));
        } else if ($paginate === null) {
            return PaymentResource::collection(Payment::with('user')->where('amount', 'like',  '%' . $search . '%')->where('paymentable_type', 'App\Models\Admin\Market\OfflinePayment')->orderBy('created_at', 'desc')->get());
        }
    }
    /**
     * Display the specified resource.
     */
    public function  online($perPage = 0, $search = '')
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
                return PaymentResource::collection(Payment::with(['user' , 'paymentable'=> function (MorphTo $morphTo){
                  
                    $morphTo->constrain([
                        OnlinePayment::class => function (Builder $query) {
                           $query->select('id' , 'amount' ,'transaction_id' ,'gateway');
                       },
                  
                   ]);
    
                }])->where('amount', 'like',  '%' . $searchVal . '%')->where('paymentable_type', 'App\Models\Admin\Market\OnlinePayment')->orderBy('created_at', 'desc')->get());
            }
            return PaymentResource::collection(Payment::with(['user' , 'paymentable'=> function (MorphTo $morphTo){
                  
                $morphTo->constrain([
                    OnlinePayment::class => function (Builder $query) {
                       $query->select('id' , 'amount' ,'transaction_id' ,'gateway');
                   },
                
               ]);

            }])->where('amount', 'like',  '%' . $searchVal . '%')->where('paymentable_type', 'App\Models\Admin\Market\OnlinePayment')->orderBy('created_at', 'desc')->paginate($paginate));
        } else if ($paginate) {
            return PaymentResource::collection(Payment::with(['user' , 'paymentable'=> function (MorphTo $morphTo){
                  
                $morphTo->constrain([
                    OnlinePayment::class => function (Builder $query) {
                       $query->select('id' , 'amount' ,'transaction_id' ,'gateway');
                   },
               
               ]);

            }])->where('paymentable_type', 'App\Models\Admin\Market\OnlinePayment')->orderBy('created_at', 'desc')->paginate($paginate));
        } else if ($paginate === null) {
            return PaymentResource::collection(Payment::with(['user' , 'paymentable'=> function (MorphTo $morphTo){
                  
                $morphTo->constrain([
                    OnlinePayment::class => function (Builder $query) {
                       $query->select('id' , 'amount' ,'transaction_id' ,'gateway');
                   },
              
               ]);

            }])->where('amount', 'like',  '%' . $searchVal . '%')->where('paymentable_type', 'App\Models\Admin\Market\OnlinePayment')->orderBy('created_at', 'desc')->get());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function cash($perPage = 0, $search = '')
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
                return PaymentResource::collection(Payment:: with(['user' , 'paymentable'=> function (MorphTo $morphTo){
                  
                    $morphTo->constrain([
                       
                        CashPayment::class => function (Builder $query) {
                        $query->select('id' , 'amount' , 'cash_receiver' , 'pay_date');
                    },
                   ]);
    
                }])->where('amount', 'like',  '%' . $search . '%')->where('paymentable_type', 'App\Models\Admin\Market\CashPayment')->orderBy('created_at', 'desc')->get());
            }
            return PaymentResource::collection(Payment::with(['user' , 'paymentable'=> function (MorphTo $morphTo){
                  
                $morphTo->constrain([
                   
                    CashPayment::class => function (Builder $query) {
                    $query->select('id' , 'amount' , 'cash_receiver' , 'pay_date');
                },
               ]);

            }])->where('amount', 'like',  '%' . $searchVal . '%')->where('paymentable_type', 'App\Models\Admin\Market\CashPayment')->orderBy('created_at', 'desc')->paginate($paginate));
        } else if ($paginate) {
            return PaymentResource::collection(Payment::with(['user' , 'paymentable'=> function (MorphTo $morphTo){
                  
                $morphTo->constrain([
                  
                    CashPayment::class => function (Builder $query) {
                    $query->select('id' , 'amount' , 'cash_receiver' , 'pay_date');
                },
               ]);

            }])->where('paymentable_type', 'App\Models\Admin\Market\CashPayment')->orderBy('created_at', 'desc')->paginate($paginate));
        } else if ($paginate === null) {
            return PaymentResource::collection(Payment::with(['user' , 'paymentable'=> function (MorphTo $morphTo){
                  
                $morphTo->constrain([
                   
                    CashPayment::class => function (Builder $query) {
                    $query->select('id' , 'amount' , 'cash_receiver' , 'pay_date');
                },
               ]);

            }])->where('amount', 'like',  '%' . $searchVal . '%')->where('paymentable_type', 'App\Models\Admin\Market\CashPayment')->orderBy('created_at', 'desc')->get());
        }
    }

    public function  show(Payment $payment)
    {
        $data =  new PaymentResource ($payment->load(['user' , 'paymentable'=> function (MorphTo $morphTo){
                  
            $morphTo->constrain([
                OnlinePayment::class => function (Builder $query) {
                   $query->select('id' , 'amount' ,'transaction_id' ,'gateway');
               },
                OfflinePayment::class => function (Builder $query) {
                   $query->select('id' , 'amount' , 'transaction_id' , 'pay_date');
               },
               CashPayment::class => function (Builder $query) {
                $query->select('id' , 'amount' , 'cash_receiver' , 'pay_date');
            },
           ]);

        }]));

        if ($data) {
            return  response()->json(['status' => 200, 'data' => $data ]);
        } else {
            return response()->json(['status' => 404]);
        }
    }

    public function  canceled(Payment $payment)
    {

        $payment->status = 2;
        $status =  $payment->save();

        if ($status) {
            return  response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 404]);
        }
    }

    public function    returned(Payment $payment)
    {

        $payment->status = 3;
        $status =  $payment->save();

        if ($status) {
            return  response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 404]);
        }
    }
}
