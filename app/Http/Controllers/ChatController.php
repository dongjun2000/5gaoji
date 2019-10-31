<?php

namespace App\Http\Controllers;

use App\Category;
use App\Chat;
use App\User;
use GatewayClient\Gateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // 房间 session key
    private $room_key = 'chat-room';

    public function __construct()
    {
        $this->middleware('auth');

        Gateway::$registerAddress = '127.0.0.1:1238';
    }

    public function room($room)
    {
        $categories = Category::all();

        // 设置房间
        session()->put($this->room_key, $room);

        return view('chat.room', compact('categories'));
    }

    public function init(Request $request)
    {
        // 绑定用户
        $this->bind($request);

        // 在线用户
        $this->users();

        // 历史记录
        $this->history();

        // 进入聊天室
        $this->login();
    }

    public function say(Request $request, Chat $chat)
    {
        $data = [
            'type' => 'say',
            'data' => [
                'avatar'     => Auth::user()->avatar,
                'name'       => Auth::user()->name,
                'to_name'    => '所有人',
                'content'    => $request->get('content'),
                'time'       => date('Y-m-d H:i:s', time()),
                'is_private' => 0,
            ]
        ];

        // 私聊
        if ($request->to_user_id) {
            $data['data']['is_private'] = 1;
            $data['data']['to_name']    = User::where('id', $request->to_user_id)->value('name');
            Gateway::sendToUid($request->to_user_id, json_encode($data));
            Gateway::sendToUid(Auth::id(), json_encode($data));
        } else {
            Gateway::sendToGroup(session($this->room_key), json_encode($data));
        }

        // 存入数据库，以后可以查询聊天记录
        $chat->fill($request->all());
        $chat->room_id = session($this->room_key);
        $chat->user_id = Auth::id();
        $chat->save();
    }

    private function bind($request)
    {
        $id        = Auth::id();
        $client_id = $request->client_id;

        // client_id 与 user_id 绑定
        Gateway::bindUid($client_id, $id);

        // 加入组
        Gateway::joinGroup($client_id, session($this->room_key));

        // 设置session
        Gateway::setSession($client_id, [
            'id'     => $id,
            'avatar' => Auth::user()->avatar,
            'name'   => Auth::user()->name,
        ]);
    }

    private function login()
    {
        $data = [
            'type' => 'say',
            'data' => [
                'avatar'     => Auth::user()->avatar,
                'name'       => Auth::user()->name,
                'to_name'    => '所有人',
                'content'    => '我来了',
                'time'       => date('Y-m-d H:i:s', time()),
                'is_private' => 0,
            ]
        ];

        Gateway::sendToGroup(session($this->room_key), json_encode($data));
    }

    private function history()
    {
        $data = ['type' => 'history'];

        $chats = Chat::with('user')->where('room_id', session($this->room_key))->orderBy('id', 'desc')->limit(5)->get();

        $data['data'] = $chats->map(function ($item, $key) {
            return [
                'avatar'     => $item->user->avatar,
                'name'       => $item->user->name,
                'to_name'    => User::where('id', $item->to_user_id)->value('name') ?: '所有人',
                'content'    => $item->content,
                'time'       => $item->created_at->format('Y-m-d H:i:s'),
                'is_private' => !empty($item->to_user_id),
            ];
        });
        // 给指定用户发送方法
        Gateway::sendToUid(Auth::id(), json_encode($data));
    }

    private function users()
    {
        $data = [
            'type'  => 'users',
            'data'  => Gateway::getClientSessionsByGroup(session($this->room_key)),
            'count' => Gateway::getClientCountByGroup(session($this->room_key)),
        ];
        // 给所有用户发送在线用户
        Gateway::sendToGroup(session($this->room_key), json_encode($data));
    }
}
