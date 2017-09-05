<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class User extends Resource
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
            'name' => $this->name,
            'display_name' => $this->display_name,
            'created_at' => $this->created_at,
            'description' => $this->description,
            'url' => $this->url,
            'birthday' => $this->birthday,
            'twitter_name' => $this->twitter_name,
            'github_name' => $this->github_name,
        ];
    }
}
