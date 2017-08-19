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

    public function get() 
    {
        $validator = Validator::make($this->request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) return response()->json(['error' => 'You should set id.'], 400);

        $user = User::find((int)$this->request->input('id'));
        if (!$user) return response()->json([ 'error' => 'The user doesn\'t exist.'], 404);
        return response()->json($user, 200);
    }

    public function query()
    {
        $validator = Validator::make($this->request->all(), [
            'query' => 'nullable|string',
            'full' => 'nullable|boolean',
        ]);
        if ($validator->fails()) return response()->json(['error' => 'You should set query string.'], 400);

        $users = User::queryString($this->request->input('query'));
        if (!$this->request->input('full') ?? true) {
            $users = $users->select('id', 'name');
        }
        return response()->json($users->get(), 200);
    }

    public function listBookmarks() {
        $bookmarks = Auth::user()->bookmarks;

        return $bookmarks->toJson();
    }
}
