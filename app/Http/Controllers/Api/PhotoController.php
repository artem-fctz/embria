<?php

namespace App\Http\Controllers\Api;

use App\Photo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PhotoController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $photos = Photo::with(['author', 'media'])->withCount('likes')->get();

        return response()->json(['photos' => $photos]);
    }
}
