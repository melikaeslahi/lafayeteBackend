<?php

namespace App\Http\Controllers\Api\V1\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CommentRequest;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\Admin\CommentResource;
use App\Models\Admin\Comment;
use App\Models\Admin\Market\Product;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($perPage= 0 , $search = '')
    {
        $unseenComments = Comment::where('commentable_type' , 'App\Models\Admin\Market\Product')-> where('seen' , 0)->get();
        foreach($unseenComments as $unseenComment){
           
          $unseenComment->seen = 1;
          $resault = $unseenComment->save();

        }

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
              return CommentResource::collection(Comment::with(['parent.user', 'user' , 'commentable'=> function ( MorphTo $morphTo){
                  
                $morphTo->constrain([
                    Product::class => function (  Builder $query) {
                        $query->select('id' , 'name' );
                    },
                   
                ]);

            } ])->where('body', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->where('commentable_type' , 'App\Models\Admin\Market\Product')->get());
            }
          return CommentResource::collection(Comment::with(['parent.user' , 'user' , 'commentable'=> function (MorphTo $morphTo){
                  
            $morphTo->constrain([
                Product::class => function (  Builder $query) {
                    $query->select('id' , 'name' );
                },
               
            ]);

        }])->where('body', 'like',  '%' . $searchVal .'%' )->orderBy('created_at', 'desc')->where('commentable_type' , 'App\Models\Admin\Market\Product')->paginate($paginate)) ;
          
        }
        else if($paginate){
            return  CommentResource::collection(Comment::with(['parent.user' , 'user' , 'commentable'=> function ( MorphTo $morphTo){
                  
                $morphTo->constrain([
                    Product::class => function (  Builder $query) {
                        $query->select('id' , 'name' );
                    },
                   
                ]);

            }])->orderBy('created_at', 'desc')->where('commentable_type' , 'App\Models\Admin\Market\Product')->paginate($paginate));
        }else if ($paginate === null) {
            return CommentResource::collection(Comment::with(['parent.user' , 'user' , 'commentable'=> function ( MorphTo $morphTo){
                  
                $morphTo->constrain([
                       Product::class => function (  Builder $query) {
                        $query->select('id' , 'name' );
                    },
                   
                ]);

            }])->where('body', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->where('commentable_type' , 'App\Models\Admin\Market\Product')->get());
          }
    }


    public function answer(CommentRequest $request , Comment $comment)
    {
        if ($comment->parent_id == null) {
             
        
            $inputs = $request->all();
            $inputs['author_id']=2;
            $inputs['status']=1;
            $inputs['approved']=1;
            $inputs['commentable_id']=$comment->commentable_id;
            $inputs['commentable_type']=$comment->commentable_type;
            $inputs['parent_id']=$comment->id;
             
           $answer=Comment::create($inputs);
        return response()->json(['status' => 200]);
        }else{
            return response()->json(['status' => 404 ]);
        }


    }
  
   
    public function status( Comment $comment)
    {
        $comment->status =  $comment->status == 0 ? 1 : 0;
        $resault = $comment->save();

        if ($resault) {
            if ($comment->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {

            return response()->json(['status' => false]);
        }
    }

    public function  approved( Comment $comment)
    {
        $comment->approved =  $comment->approved == 0 ? 1 : 0;
        $resault = $comment->save();

        if ($resault) {
            if ($comment->approved == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {

            return response()->json(['status' => false]);
        }
    }
    public function show(Comment $comment){
        if($comment){
            return  response()->json(['status'=> 200 , 'data' =>  new CommentResource($comment->load(['user' , 'commentable'=> function ( MorphTo $morphTo){
                  
                $morphTo->constrain([
                       Product::class => function (  Builder $query) {
                        $query->select('id' , 'name' );
                    },
                   
                ]);

            } ]))]);
        }else{
            return response()->json(['status' => 404]);
        }
      
       
    }
}
