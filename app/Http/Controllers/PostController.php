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
use Illuminate\Support\Facades\Log;
use stdClass;

class PostController extends Controller
{
    public function index()
    {
        // try {
            $posts = PostResource::collection(Post::paginate(10));
            $isAdmin = $this->isAdmin();
            return Inertia::render('Posts/Index', [
                'posts' => $posts,
                'isAdmin' => $isAdmin,
            ]);
        // }
        // catch(\Exception $e) {
        //     Log::error('Post error: ' . $e->getMessage());
        // }
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

    public function upload(StorePostRequest $request)
    {
        $post = new Post();
        $post->user_id = $request->userId;
        $post->caption = $request->caption;

        if ($data = $this->uploadFile($request)) {
            $post->media = $data->media;
            $post->media_type = $data->media_type;

            if (isset($data->image)) {
                $post->image = $data->image;
                $post->image_type = $data->image_type;
            }

            $post->save();
            return response()->json([
                'message' => 'Post created successfully.'
            ]);
        }

        return response()->json([
            'message' => 'Post creation unsuccessful.'
        ]);
    }

    private function uploadFile($request, $imageOnly = false)
    {
        $storage_path = 'app/public/uploads/';
        $data = new stdClass;

        // Handle file upload if an image is provided
        if ($request->hasFile('image')) {
            $imageName = time() . $request->image->getClientOriginalName();
            $request->image->move(storage_path($storage_path . 'images'), $imageName);
            $data->image = $imageName;
            $data->image_type = $request->image->getClientOriginalExtension(); // Get the image type
        }

        // Handle media if provided
        if ($request->hasFile('media') && !$imageOnly) {
            $mediaName = time() . $request->media->getClientOriginalName();
            $request->media->move(storage_path($storage_path . 'media'), $mediaName);
            $data->media = $mediaName;
            $data->media_type = $request->media->getClientOriginalExtension(); // Get the media type
        }

        return $data;
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
        $post = Post::find($request->id);
        $image_name = null;
        $image_type = null;


        if ($request->image && !$request->removeImage) {
            if ($post->image) {
                $this->unlinkImage($post->image);
            }
            $data = $this->uploadFile($request, true);

            if (isset($data->image)) {
                $image_name = $data->image;
                $image_type = $data->image_type;
            }

        }

        if ($request->removeImage && $post->image) {
            $this->unlinkImage($post->image);

        }


        Post::whereId($request->id)->update([
            'user_id' => $request->userId,
            'caption' => $request->caption,
            'image' => $image_name,
            'image_type' => $image_type
        ]);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy($id)
    {
        $post = Post::find($id);

        // Delete the post record from the database
        if (!$post) {
            return redirect()->route('posts.index')->with('error', 'Post not found.');
        }

        // Delete the image file if it exists
        if ($post->image) {
            $this->unlinkImage($post->image);
        }

        // Delete the media file if it exists

        $postMediaPath = storage_path('app/public/uploads/media/' . $post->media);
        if (file_exists($postMediaPath)) {
            unlink($postMediaPath);
        }
        // Delete the post
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }

    private function unlinkImage($imageName) {
        $postImagePath = storage_path('app/public/uploads/images/' . $imageName);

        if (file_exists($postImagePath)) {
            unlink($postImagePath);
        }
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
