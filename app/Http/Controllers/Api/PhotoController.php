<?php

namespace App\Http\Controllers\Api;

use App\Photo;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

/**
 * Class PhotoController
 *
 * @package App\Http\Controllers\Api
 */
class PhotoController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        $photos = Photo::with(['author', 'media'])->withCount('likes')->get();

        return response()->json(['photos' => $photos]);
    }
}
