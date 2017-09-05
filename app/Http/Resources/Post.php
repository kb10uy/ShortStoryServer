<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\Tag as TagResource;

class Post extends Resource
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
            'title' => $this->title,
            'text' => $this->text,
            'view_count' => $this->view_count,
            'nice_count' => $this->nice_count,
            'bad_count' => $this->bad_count,
            'created_at' => $this->created_at,
            'updated_at' => $this->modified_at,
            'user' => new UserResource($this->user),
            'tags' => TagResource::collection($this->tags),
        ];
    }
}
