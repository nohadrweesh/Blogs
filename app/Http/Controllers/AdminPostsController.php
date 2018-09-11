<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\PostsCreateRequest;
use App\Photo;
use App\Post;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class AdminPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $posts=Post::all();

        return view('admin.posts.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories=Category::lists('name','id');
        return view('admin.posts.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostsCreateRequest $request)
    {
        //
        $user=Auth::User();

        $input=$request->all();
        $input['user_id']=$user->id;
        if($file=$request->file('photo_id')){

            $name=time().$file->getClientOriginalName();
            $photo=Photo::create(['file'=>$name]);
            $file->move('images',$name);
            //dd($photo->id);
            $input['photo_id']=$photo->id;
        }
        //dd($input);
        Post::create($input);
        //$user->posts->create($input); //withot user_id
        //dd($input);
        return redirect('/admin/posts');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

        $post=Post::findOrFail($id);
        $categories=Category::lists('name','id');

    return view('admin.posts.edit',compact('post','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostsCreateRequest $request, $id)
    {
        //


        $input=$request->all();
        if($photo_id=Post::findOrFail($id)->photo_id){
            $input['photo_id']=$photo_id;
        }

        if($file=$request->file('photo_id')){

            $name=time().$file->getClientOriginalName();
            $photo=Photo::create(['file'=>$name]);
            $file->move('images',$name);
            //dd($photo->id);
            $input['photo_id']=$photo->id;
        }
        //dd($input);
       Auth::User()->posts()->whereId($id)->first()->update($input);
        //$user->posts->create($input); //withot user_id
        //dd($input);
        return redirect('/admin/posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $post=Post::findOrFail($id);

        if($photo_id=$post->photo_id){
            //del photo
            unlink(public_path().$post->photo->file);
        }
        $post->delete();
        return redirect('/admin/posts');

    }
}
