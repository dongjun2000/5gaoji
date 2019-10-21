<?php

// 定义公共辅助函数文件

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}