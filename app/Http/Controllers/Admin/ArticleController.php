<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Http\Requests\StoreArticle;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

/**
 * Class ArticleController
 *
 * @package App\Http\Controllers\Admin
 */
class ArticleController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index()
    {
        $articles = Article::with(['author', 'likes'])->simplePaginate(5);

        return view('admin.articles.index', compact('articles'));
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        return view('admin.articles.create');
    }

    /**
     * @param StoreArticle $request
     *
     * @return RedirectResponse|Redirector
     */
    public function store(StoreArticle $request)
    {
        $title = $request->input('title');
        $content = $request->input('content');

        $article = new Article();
        $article->title = $title;
        $article->content = $content;
        $article->author()->associate(auth()->user());
        $article->save();

        return redirect("/admin/articles/{$article->id}")->with('success', 'Новая статья добавлена!');
    }

    /**
     * @param Article $article
     *
     * @return Factory|View
     */
    public function show(Article $article)
    {
        return view('admin.articles.show', compact('article'));
    }

    /**
     * @param Article $article
     *
     * @return Factory|View
     */
    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    /**
     * @param StoreArticle $request
     * @param Article $article
     *
     * @return RedirectResponse|Redirector
     */
    public function update(StoreArticle $request, Article $article)
    {
        $title = $request->get('title');
        $content = $request->get('content');

        if ($title !== $article->title) {
            $article->title = $title;
        }

        if ($content !== $article->content) {
            $article->content = $content;
        }

        $article->save();

        return redirect("/admin/articles/{$article->id}")->with('success', 'Статья обновлена!');
    }

    /**
     * @param Article $article
     *
     * @return RedirectResponse|Redirector
     * @throws \Exception
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return redirect("/admin/articles/")->with('success', 'Статья удалена успешно!');
    }
}
