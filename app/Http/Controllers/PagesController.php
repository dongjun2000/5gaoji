<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PagesController extends Controller
{
    public function home()
    {
        Cache::put('dongjun', '123', 60*60);
        return view('pages.home');
    }
}
