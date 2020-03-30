<?php

namespace App\Http\Controllers\Api;

use App\Article;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

/**
 * Class ArticleController
 *
 * @package App\Http\Controllers\Api
 */
class ArticleController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        $articles = Article::with(['author'])->withCount('likes')->get();

        return response()->json(['articles' => $articles]);
    }
}
