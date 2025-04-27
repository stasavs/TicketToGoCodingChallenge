<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostFilterRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(PostFilterRequest $request)
    {
        $query = Post::with(['author', 'comments']);

        if ($request->filled('author_id'))
        {
            $query->where('author_id', $request->get('author_id'));
        }

        if ($request->filled('title'))
        {
            $query->where('title', 'like', '%' . $request->get('title') . '%');
        }


        $posts = $query->paginate($request->per_page);

        return PostResource::collection($posts);

    }
}
