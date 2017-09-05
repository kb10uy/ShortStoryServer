<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\Http\Resources\Bookmark as BookmarkResource;
use App\Http\Resources\Post as PostResource;

class BookmarkEntry extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'order' => $this->order,
            'comment' => $this->comment,
            'post_id' => $this->post_id,
            'post' => new PostResource($this->whenLoaded('post')),
        ];
    }
}
