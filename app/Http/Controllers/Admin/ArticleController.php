<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $articles = Article::with(['author', 'likes'])->simplePaginate(5);

        return view('admin.articles.index', compact('articles'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.articles.create');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Article $article)
    {
        return view('admin.articles.show', compact('article'));
    }

    /**
     * @param Article $article
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    /**
     * @param Request $request
     * @param Article $article
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Article $article)
    {
        if($request->has('title') && $request->get('title') !== $article->title) {
            $article->title = $request->get('title');
        }

        if($request->has('content') && $request->get('content') !== $article->content) {
            $article->content = $request->get('content');
        }

        $article->save();

        return redirect("/admin/articles/{$article->id}")->with('success', 'Новое фото обновлено!');
    }

    /**
     * @param Article $article
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return redirect("/admin/articles/")->with('success', 'Статья удалена успешно!');
    }
}
