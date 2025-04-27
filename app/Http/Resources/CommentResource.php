<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="CommentResource",
 *     description="Comment resource schema",
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         example="Jane Smith"
 *     ),
 *     @OA\Property(
 *         property="text",
 *         type="string",
 *         example="Great post!"
 *     )
 * )
 */
class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'text' => $this->text,
        ];
    }
}
