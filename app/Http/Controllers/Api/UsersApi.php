<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use Auth;
use Session;
use Validator;

class UsersApi extends Controller
{
    /* 
     * /users/get (GET)
     * id(required): 調べたいユーザーのid
     * 
     * 指定したidを持つユーザーの全ての情報を取得します。
     */
    public function get(Requset $request) 
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) return response()->json(['error' => 'You should set id.'], 400);

        $user = User::find((int)$request->input('id'));
        if (!$user) return response()->json([ 'error' => 'The user doesn\'t exist.'], 404);
        return response()->json($user, 200);
    }

    /* 
     * /users/query (GET)
     * ・クエリ文字列のオプション
     *   max, min: ユーザーのid範囲
     *   from, to: ユーザーの登録日付の範囲
     *   count: 取得件数(~200, デフォルトは10)
     *
     * full: 全情報を取得するかのフラグ(デフォルトはfalse)
     * 
     * 複数のユーザーの概略を取得します。
     */
    public function query(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'query' => 'nullable|string',
            'full' => 'nullable|boolean',
        ]);
        if ($validator->fails()) return response()->json(['error' => 'You should set query string.'], 400);

        $users = User::queryString($request->input('query'));
        if (!$request->input('full') ?? true) {
            $users = $users->select('id', 'name');
        }
        return response()->json($users->get(), 200);
    }
}
