<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\Tag;
use App\Models\Category;
use App\Http\Requests\Posts\CreatePostsRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use Illuminate\Support\Facades\Storage;


class PostsController extends Controller
{

    public function __construct(){

        $this->middleware('verifyCategoriesCount')->only(['create', 'store']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('posts.index')->with('posts', Post::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create')->with('categories', Category::all())->with('tags', Tag::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostsRequest $request)

    {
        // dd($request->all());
        $image = $request->image->store('posts');

        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'category_id' => $request->category,
            'published_at' => $request->published_at,
            'image' => $image
        ]);

            if($request->tags){
                $post->tags()->attach($request->tags);
            }

        session()->flash('success', 'Post has been created successfully');

        return redirect(route('posts.index'));
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
    public function edit(Post $post)
    {
        return view('posts.create')->withPost($post)->withCategories(Category::all())->withTags(Tag::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        // dd($request);
        $data = $request->only(['title', 'description', 'content', 'published_at']);

        if($request->hasFile('image')){
            $image = $request->image->store('posts');

            Storage::delete($post->image);

            $data['image'] = $image;
        }

        if($request->tags){
            $post->tags()->sync($request->tags);
        }

        $post->update($data);

        session()->flash('success', 'Post updated successfully');

        return redirect(route('posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::withTrashed($id)->where('id', $id)->firstOrFail();

        if($post->trashed()){
            Storage::delete($post->image);
            $post->forceDelete();
        }else{
            $post->delete();
        }

        session()->flash('success', 'Post has been deleted successfully');

        return redirect(route('posts.index'));

    }

    public function trashed()
    {
        $trashed = Post::onlyTrashed()->get();

        return view('posts.index')->withPosts($trashed);

    }

    public function restore($id)
    {
        $post = Post::withTrashed()->where('id', $id)->firstOrFail();

        $post->restore();

        session()->flash('success', 'Post has been restored successfully');

        return redirect()->back();
    }
}