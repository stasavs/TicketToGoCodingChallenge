<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="PostResource",
 *     description="Post resource schema",
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         example="TicketGo Rules"
 *     ),
 *     @OA\Property(
 *         property="author",
 *         type="string",
 *         example="John Doe"
 *     ),
 *     @OA\Property(
 *         property="comments",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/CommentResource")
 *     )
 * )
 */

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'author' => $this->author->name,
            'comments' => CommentResource::collection($this->comments),
        ];
    }


}
