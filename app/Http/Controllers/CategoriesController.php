<?php

namespace App\Http\Controllers;

use App\Link;
use App\Topic;
use App\Category;
use App\User;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function show(Request $request, Category $category, Topic $topic, User $user, Link $link)
    {
        // 读取分类 ID 关联的话题，并按每 20 条分页
        $topics = $topic->withOrder($request->order)->where('category_id', $category->id)->paginate(20);

        // 活跃用户列表
        $active_users = $user->getActiveUsers();

        // 推荐资源链接
        $links = $link->getAllCached();

        return view('topics.index', compact('category', 'topics', 'active_users', 'links'));
    }
}
