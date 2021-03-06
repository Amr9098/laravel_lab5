<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return postResource::collection(Post::get());

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|max:50|unique:posts',
            'body' => 'required',
        ]);
        if ($validator->fails()) {
            return response( $validator->errors())->setStatusCode(400);
            ;
        }else{

       $post= Post::create(
           $request->all(),
        );
            return new postResource($post);
    }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post= Post::find($id);
        if ($post){
            return new postResource($post);
        }else{
            return response("post not found");
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|max:50|unique:posts',
            'body' => 'required',
        ]);
        if ($validator->fails()) {
            return response( $validator->errors())->setStatusCode(400);
            ;
        }else{

        $post= Post::find($id);
        $post->update([
            'title' => $request->title,
            'body' => $request->body,
            ]
        );
         return new postResource($post);
    }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post= Post::find($id);
        if(!$post){
            return response( "post not found")->setStatusCode(400);
        }else{
            $post->delete($id);
            return response( "post deleted successfully")->setStatusCode(200);

        }

    }
}
