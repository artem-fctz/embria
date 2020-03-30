<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Like;
use App\Photo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    //
    public function index()
    {
        $countArticles = Article::count();
        $countPhotos = Photo::count();
        $countLikes = Like::count();

        return view('admin.index', compact('countArticles', 'countPhotos', 'countLikes'));
    }
}
