<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::with(['author', 'likes'])->simplePaginate(5);

        return view('admin.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.articles.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
     * Display the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return view('admin.articles.show', compact('article'));
    }


    /**
     * EDIT the specified resource.
     *
     * @param  \App\Article  $article
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return redirect("/admin/articles/")->with('success', 'Статья удалена успешно!');
    }
}
