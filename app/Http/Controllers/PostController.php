<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth as Auth;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Http\Requests\StorePostRequest;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index()
    {
        $posts = PostResource::collection(Post::paginate(10));
        $isAdmin = $this->isAdmin();
        return Inertia::render('Posts/Index', [
            'posts' => $posts,
            'isAdmin' => $isAdmin,
        ]);
    }

    public function create()
    {
        $user = UserResource::make(Auth::user());
        if (!$user) {
            return redirect()->route('login');
        }
        return Inertia::render('Posts/Create', [
            'user' => $user,
        ]);
    }

    public function store(StorePostRequest $request)
    {
        $storage_path = 'app/public/uploads/';
        $post = new Post();
        $post->user_id = $request->userId;
        $post->caption = $request->caption;

        // Handle file upload if an image is provided
        if ($request->hasFile('image')) {
            $imageName = time() . $request->image->getClientOriginalName();
            $request->image->move(storage_path($storage_path . 'images'), $imageName);
            $post->image = $imageName;
            $post->image_type = $request->image->getClientOriginalExtension(); // Get the image type
        }

        // Handle media if provided
        if ($request->hasFile('media')) {
            $mediaName = time() . $request->media->getClientOriginalName();
            $request->media->move(storage_path($storage_path . 'media'), $mediaName);
            $post->media = $mediaName;
            $post->media_type = $request->media->getClientOriginalExtension(); // Get the media type
        }

        $post->save();

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');

        // return Inertia::location(route('posts.index'));
    }

    public function show($id)
    {
        return Inertia::render('post', [
            'post' => Post::find($id)
        ]);
    }

    public function edit($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return redirect()->route('posts.index')->with('error', 'Post not found.');
        }
        $post->id = $id;
        $user = UserResource::make(Auth::user());
        return Inertia::render('Posts/Edit', [
            'post' => $post,
            'user' => $user,
        ]);
    }
    public function update(Request $request)
    {
        Post::whereId($request->id)->update([
            'user_id' => $request->userId,
            'caption' => $request->caption,
            'image' => $request->image,
            'media' => $request->media,
        ]);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        $postImagePath = storage_path('app/public/uploads/images/' . $post->image);
        $postMediaPath = storage_path('app/public/uploads/media/' . $post->media);

        // Delete the post record from the database
        if (!$post) {
            return redirect()->route('posts.index')->with('error', 'Post not found.');
        }
        // Delete the image file if it exists
        if (file_exists($postImagePath)) {
            unlink($postImagePath);
        }
        // Delete the media file if it exists
        if (file_exists($postMediaPath)) {
            unlink($postMediaPath);
        }
        // Delete the post
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
    
    private function isAdmin()
    {
        if (!Auth::user()) {
            return false;
        }
        $loggedInUserId = Auth::user()->id;
        $loggedInUser = User::find($loggedInUserId);
        return $loggedInUser->level_id > 1;
    }

}
