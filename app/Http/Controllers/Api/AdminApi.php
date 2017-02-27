<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Events\ServerInformed;
use App\User;

class AdminApi extends Controller
{
    //
    public function __construct() 
    {
        $this->middleware('admin')->except('request');
    }

    /* 
     * /admin/request (POST)
     * code(required): 他のAdminから知らされたcode
     * 
     * 比較的アナログな方法でAdminになろうとします。
     * 1.Admin権限が欲しいアリスが既存のAdminであるシノにその旨を伝える。
     * 2.シノはWebのAdminコンソールからアリスのユーザーデータ操作により、
     *   アリスに一時的なAdmin許可コードを設定し($user->type)、アリスに伝える。
     * 3.アリスが受け取った許可コードを指定してこのAPIを叩く。
     */
    public function request() 
    {
        $user = Auth::user();
        if ($request->message == $user->type) {
            $user->type = 'admin';
            $user->save();
            return response()
                 ->json(['result' => 'Yay! Now you has Admin privilege.'], 200);
        } else {
            $user->type = 'user';
            $user->save();
            return response()->json([
                'error' => 'Are you serious?', 
            ], 403);
        }
    }


    public function users() 
    {
        $users = User::all();
        return response()->json($users);
    }

    /* 
     * /admin/broadcast_server_message (POST)
     * message(required): メッセージ
     * 
     * 閲覧者に一斉にメッセージを送ります。
     */
    public function broadcastServerMessage(Request $request) 
    {
        if ($request->message == "") {
            return response()
                 ->json(['result' => 'The message was empty.'], 204);
        } else {
            event(new ServerInformed(htmlspecialchars($request->message)));
            return response()
                 ->json(['result' => 'The message has been broadcast.'], 200);
        }
    }
}
