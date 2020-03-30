<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Like;
use App\Photo;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

/**
 * Class AdminController
 *
 * @package App\Http\Controllers\Admin
 */
class AdminController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index()
    {
        $countArticles = Article::count();
        $countPhotos = Photo::count();
        $countLikes = Like::count();

        return view('admin.index', compact('countArticles', 'countPhotos', 'countLikes'));
    }
}
