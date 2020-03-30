<?php

namespace App\Http\Controllers\Api;

use App\Article;
use App\Like;
use App\Photo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class LikeController
 * @package App\Http\Controllers\Api
 */
class LikeController extends Controller
{
    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        $type = $request->get('entityType');
        $id = intval($request->get('entityId'));

        if($type === 'article') {
            $type = Article::class;
        } elseif($type === 'photo') {
            $type = Photo::class;
        } else {
            return response()->json(['status' => 'fail', 'message' => 'Unprocessable entity type.']);
        }

        try {
            $entity = $type::where('id', $id)->firstOrFail();
        } catch (\Throwable $exception) {
            return response()->json(['status' => 'fail', 'message' => 'Entity is absent in DB.']);
        }

        return response()->json(['status' => 'success', 'count' => $entity->likes->count()]);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function toggle(Request $request)
    {
        $type = $request->get('entityType');
        $id = intval($request->get('entityId'));
        $authorId = intval($request->get('userID'));

        if($type === 'article') {
            $type = Article::class;
        } elseif($type === 'photo') {
            $type = Photo::class;
        } else {
            return response()->json(['status' => 'fail', 'message' => 'Unprocessable entity type.']);
        }

        $likeInDb = Like::where([
            'user_id'      => $authorId,
            'likable_id'   => $id,
            'likable_type' => $type,
        ])->first();

        if ($likeInDb !== null) {
            Like::destroy($likeInDb->id);

            return response()->json(['status' => 'success', 'message' => 'Like deleted.']);
        }

        $like = new Like();
        $like->user_id = $authorId;
        $like->likable_id = $id;
        $like->likable_type = $type;

        $like->save();

        return response()->json(['status' => 'success', 'message' => 'Like created.']);
    }

    public function detect(Request $request)
    {
        $type = $request->get('entityType');
        $id = intval($request->get('entityId'));
        $authorId = intval($request->get('userID'));

        if($type === 'article') {
            $type = Article::class;
        } elseif($type === 'photo') {
            $type = Photo::class;
        } else {
            return response()->json(['status' => 'fail', 'message' => 'Unprocessable entity type.']);
        }

        $likeInDb = Like::where([
            'user_id'      => $authorId,
            'likable_id'   => $id,
            'likable_type' => $type,
        ])->first();

        if ($likeInDb !== null) {
            return response()->json(['status' => 'success', 'detected' => true]);
        }

        return response()->json(['status' => 'success', 'detected' => false]);
    }
}
