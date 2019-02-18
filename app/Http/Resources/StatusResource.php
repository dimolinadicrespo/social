<?php

namespace App\Http\Resources;

use App\Models\Comment;
use Illuminate\Http\Resources\Json\JsonResource;
use Tests\Unit\Http\Resources\UserResourceTest;

/**
 * @property mixed comments
 */
class StatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->resource->id,
            'body'          => $this->resource->body,
            'user'          => UserResource::make($this->user),
            'ago'           => $this->resource->created_at->diffForHumans(),
            'is_liked'      => $this->resource->isLiked(),
            'count_likes'   => $this->resource->countLikes(),
            'comments'      => CommentResource::collection($this->comments)
        ];
    }
}
