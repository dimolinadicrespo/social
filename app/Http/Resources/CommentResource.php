<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'user_name'     => $this->resource->user->name,
            'user_avatar'   => 'https://i0.wp.com/aprendible.com/images/default-avatar.jpg?ssl=1',
            'status_id'     => $this->resource->status_id,
            'is_liked'      => $this->resource->isLiked(),
            'count_likes'   => $this->resource->countLikes(),
        ];
    }
}
