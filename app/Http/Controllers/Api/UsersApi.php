<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use Auth;
use Validator;

class UsersApi extends Controller
{
    public $request = null;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function show()
    {
        $validator = Validator::make($this->request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => 'You should set id.'], 400);
        }

        $user = User::find((int)$this->request->input('id'));
        if (!$user) {
            return response()->json([ 'error' => 'The user doesn\'t exist.'], 404);
        }
        return $user->toArray();
    }

    public function bookmarks()
    {
        $validator = Validator::make($this->request->all(), [
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => 'You should set id.'], 400);
        }
        $user = User::find((int)$this->request->input('user_id'));
        if (!$user) {
            return response()->json([ 'error' => 'The user doesn\'t exist.'], 404);
        }

        $bookmarks = $user->bookmarks;
        return $bookmarks->toArray();
    }

    public function posts()
    {
        $validator = Validator::make($this->request->all(), [
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => 'You should set id.'], 400);
        }
        $user = User::find((int)$this->request->input('user_id'));
        if (!$user) {
            return response()->json([ 'error' => 'The user doesn\'t exist.'], 404);
        }

        $posts = $user->posts;
        return $posts->toArray();
    }

    /*
    public function query()
    {
        $validator = Validator::make($this->request->all(), [
            'query' => 'nullable|string',
            'full' => 'nullable|boolean',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => 'You should set query string.'], 400);
        }

        $users = User::queryString($this->request->input('query'));
        if (!$this->request->input('full') ?? true) {
            $users = $users->select('id', 'name');
        }
        return response()->json($users->get(), 200);
    }
    */
}
