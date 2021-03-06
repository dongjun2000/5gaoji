<?php

namespace App\Http\Controllers;

use App\Link;
use App\User;
use Auth;
use App\Topic;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Requests\TopicRequest;
use App\Handlers\ImageUploadHandler;
use Illuminate\Support\Facades\Redis;

class TopicsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['index', 'show']
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Topic $topic, User $user, Link $link)
    {
        $topics = $topic->withOrder($request->order)->paginate(20);

        // 活跃用户列表
        $active_users = $user->getActiveUsers();
        // 获取资源推荐列表
        $links = $link->getAllCached();

        return view('topics.index', compact('topics', 'active_users', 'links'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Topic $topic)
    {
        $categories = Category::all();
        return view('topics.create_and_edit', compact('topic', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(TopicRequest $request, Topic $topic)
    {
        $topic->fill($request->all());
        $topic->user_id = Auth::id();
        $topic->save();

        return redirect()->to($topic->link())->with('success', '帖子创建成功！');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Topic $topic
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Topic $topic)
    {

//        Redis::set('name', 'dongjun');

        // URL矫正
        if (!empty($topic->slug) && $topic->slug != $request->slug) {
            return redirect($topic->link(), 301);
        }

        return view('topics.show', compact('topic'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Topic $topic
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Topic $topic)
    {
        $this->authorize('update', $topic);
        $categories = Category::all();
        return view('topics.create_and_edit', compact('topic', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Topic $topic
     * @return \Illuminate\Http\Response
     */
    public function update(TopicRequest $request, Topic $topic)
    {
        $this->authorize('update', $topic);
        $topic->update($request->all());
        return redirect()->to($topic->link())->with('success', '更新成功！');
    }

    /**
     * @param Topic $topic
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Topic $topic)
    {
        $this->authorize('destroy', $topic);
        $topic->delete();

        return redirect()->route('topics.index')->with('success', '删除成功！');
    }

    /**
     * 编辑器图片上传
     *
     * @param Request $request
     * @param ImageUploadHandler $uploader
     * @return array
     */
    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        $data = [
            'success'   => false,
            'msg'       => '上传失败！',
            'file_path' => '',
        ];
        // 判断是否有上传文件，并赋值给 $file
        if ($file = $request->upload_file) {
            // 保存图片到本地
            $result = $uploader->save($file, 'topics', Auth::id(), 1024);
            // 图片保存成功的话
            if ($result) {
                $data['file_path'] = $result['path'];
                $data['msg']       = '上传成功！';
                $data['success']   = true;
            }
        }
        return $data;
    }
}
