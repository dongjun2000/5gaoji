<?php

namespace App\Http\Controllers;

use Auth;
use App\Reply;
use Illuminate\Http\Request;
use App\Http\Requests\ReplyRequest;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReplyRequest $request, Reply $reply)
    {
//        $reply->content = $request->get('content');
//        $reply->user_id = Auth::id();
//        $reply->topic_id = $request->get('topic_id');
//        $reply->save();

        $reply->fill($request->all());
        $reply->user_id = Auth::id();
        $reply->save();


        return view('topics._reply_item', compact('reply'));
//        return redirect()->to($reply->topic->link())->with('success', '评论创建成功！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Reply $reply
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('destroy', $reply);
        $reply->delete();

        return redirect()->to($reply->topic->link())->with('success', '评论删除成功！');
    }
}
