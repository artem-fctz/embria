<?php

namespace App\Http\Controllers\Admin;

use App\Article;
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
     * @param Request $request
     *
     * @return RedirectResponse|Redirector
     */
    public function store(Request $request)
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
     * @param Request $request
     * @param Article $article
     *
     * @return RedirectResponse|Redirector
     */
    public function update(Request $request, Article $article)
    {
        if ($request->has('title') && $request->get('title') !== $article->title) {
            $article->title = $request->get('title');
        }

        if ($request->has('content') && $request->get('content') !== $article->content) {
            $article->content = $request->get('content');
        }

        $article->save();

        return redirect("/admin/articles/{$article->id}")->with('success', 'Новое фото обновлено!');
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
