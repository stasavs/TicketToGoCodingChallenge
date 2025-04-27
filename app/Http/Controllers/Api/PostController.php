<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostFilterRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/posts",
     *     operationId="getPostsList",
     *     tags={"Posts"},
     *     summary="Get list of posts",
     *     description="Returns paginated list of posts with authors and comments",
     *     @OA\Parameter(
     *         name="author_id",
     *         in="query",
     *         description="Filter posts by author id",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="title",
     *         in="query",
     *         description="Filter posts by title",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number for pagination",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Number of results per page",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/PostResource")),
     *             @OA\Property(property="meta", type="object"),
     *             @OA\Property(property="links", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="The given data was invalid."),
     *              @OA\Property(
     *                  property="errors",
     *                  type="object",
     *                  @OA\Property(
     *                      property="author_id",
     *                      type="array",
     *                      @OA\Items(type="string", example="The selected author id is invalid.")
     *                  ),
     *                  @OA\Property(
     *                      property="title",
     *                      type="array",
     *                      @OA\Items(type="string", example="The title may not be greater than 255 characters.")
     *                  ),
     *                  @OA\Property(
     *                      property="page",
     *                      type="array",
     *                      @OA\Items(type="string", example="The page must be an integer.")
     *                  ),
     *                  @OA\Property(
     *                      property="per_page",
     *                      type="array",
     *                      @OA\Items(type="string", example="The per page may not be greater than 100.")
     *                  )
     *       )
     * )
     * )
     * )
     */

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
