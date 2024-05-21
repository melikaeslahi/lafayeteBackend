<?php

namespace App\Http\Controllers\Api\V1\Admin\Ticket;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Ticket\TicketAdminResource;
use App\Models\Admin\Ticket\TicketAdmin;
use App\Models\User;
use Illuminate\Http\Request;

class TicketAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($perPage= 0 , $search = '')
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
              return  User::where('first_name', 'like',  '%' . $searchVal . '%')->where('user_type' , 1)->orderBy('created_at', 'desc')->get();
            }
          return  User:: where('first_name', 'like',  '%'. $searchVal .'%')->where('user_type' , 1)->orderBy('created_at', 'desc')->paginate($paginate);
          
        }
        else if($paginate){
            return  User::where('user_type' , 1)->orderBy('created_at', 'desc')->paginate($paginate);
        }else if ($paginate === null) {
            return User::where('first_name', 'like',  '%' . $searchVal . '%')->where('user_type' , 1)->orderBy('created_at', 'desc')->get();
          }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function set(User $admin)
    {
        TicketAdmin::where('user_id' , $admin->id )->first() ?  TicketAdmin::where('user_id' , $admin->id )->forceDelete()  :  TicketAdmin::create(['user_id' => $admin->id]);
        return response()->json(['status' => 200]);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
