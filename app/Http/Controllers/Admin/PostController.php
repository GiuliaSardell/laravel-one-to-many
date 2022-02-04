<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //prendo tutti i post
        $posts = Post::all();

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate(
            [
                'title'=> 'required|max:255|min:2',
                'content' => 'required|min:2',

            ],
            [
                'title.required'=> "Questo è un campo obbligatorio",
                'title.max' => "Questo campo non può superare i :max caratteri",
                'title.min' => "Questo campo deve essere di almeno :min caratteri",
                'content.required' => "Questo campo è obbligatorio",
                'content.min' => "Questo campo deve essere di almeno :min caratteri"
            ]
        );

        $data = $request->all();

        $new_post = new Post();
        // $new_post->title = $data['title'];
        // $new_post->content = $data['content'];
        

        $data['slug'] = Post::generateSlug($data['title']);

        $new_post->fill($data);

        $new_post->save();
        return redirect()->route('admin.post.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $posts = Post::find($id);

        if($posts){
            return view('admin.posts.index', compact('posts'));
        }
        abort(404, 'Errore nella ricerca del post');


        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        // $data = $request ->all();
        // $post->update($data);

        // return redirect()->route('admin.post.index', $post);

        $request->validate(
            [
                'title'=> 'required|max:255|min:2',
                'content' => 'required|min:2',

            ],
            [
                'title.required'=> "Questo è un campo obbligatorio",
                'title.max' => "Questo campo non può superare i :max caratteri",
                'title.min' => "Questo campo deve essere di almeno :min caratteri",
                'content.required' => "Questo campo è obbligatorio",
                'content.min' => "Questo campo deve essere di almeno :min caratteri"
            ]
        );

        $data = $request->all();


        $data['slug'] = Post::generateSlug($data['title']);

        $post->update($data);



        return redirect()->route('admin.post.index', $post);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        
        return redirect()->route('admin.post.index');
    }
}
