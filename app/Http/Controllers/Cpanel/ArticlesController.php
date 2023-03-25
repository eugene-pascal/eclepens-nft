<?php

namespace App\Http\Controllers\Cpanel;

use App\Enums\ArticleTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cpanel\Articles\Request;

class ArticlesController extends Controller
{
    /**
     * Show the page for showing of list articles
     */
    public function list(Request $request)
    {
        return view('cpanel.articles.list');
    }


    /**
     * Show the page for adding a new article
     */
    public function add(Request $request)
    {
        return view('cpanel.articles.manage');
    }


}
