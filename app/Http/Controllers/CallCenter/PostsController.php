<?php

namespace App\Http\Controllers\CallCenter;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Redirect;
use Carbon\Carbon;

class PostsController extends Controller
{
    public function index()
    {
        $data['posts'] = Post::all();
        return view('call-center.posts.index')->with(compact('data'));
    }

    //createPost
    public function createPost(Request $request)
    {
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'title' => 'required',
                'detail' => 'required',
            ]);

            if ($request->hasFile('image')) {
                $uniqueid = uniqid();
                $original_name = $request->file('image')->getClientOriginalName();
                $size = $request->file('image')->getSize();
                $extension = $request->file('image')->getClientOriginalExtension();
                $name = Carbon::now()->format('Ymd') . '_' . $uniqueid . '.' . $extension;
                $imagepath = url('/storage/uploads/social-posts/' . $name);
                $path = $request->file('image')->storeAs('public/uploads/social-posts/', $name);
                 }

                $post = new Post();
                $post->title = $request->title;
                $post->desc = $request->detail;
                $post->image = $name;

                if ($post->save()) {
                    return response()->json(['success' => 'Post created successfully']);
                }

        }
        return view('call-center.posts.create-post');
    }
}
