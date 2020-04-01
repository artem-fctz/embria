<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StorePhoto;
use App\Http\Requests\UpdatePhoto;
use App\Photo;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\DiskDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig;

/**
 * Class PhotoController
 *
 * @package App\Http\Controllers\Admin
 */
class PhotoController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index()
    {
        $photos = Photo::with('media')->simplePaginate(5);

        return view('admin.photos.index', compact('photos'));
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        return view('admin.photos.create');
    }

    /**
     * @param StorePhoto $request
     *
     * @return RedirectResponse|Redirector
     *
     * @throws DiskDoesNotExist
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function store(StorePhoto $request)
    {
        $title = $request->input('title');

        $photo = new Photo();
        $photo->title = $title;
        $photo->author()->associate(auth()->user());
        $photo->save();

        $photo->addMediaFromRequest('image')->toMediaCollection('payload');

        return redirect("/admin/photos/{$photo->id}")->with('success', 'Новое фото добавлено!');
    }

    /**
     * @param Photo $photo
     *
     * @return Factory|View
     */
    public function show(Photo $photo)
    {
        return view('admin.photos.show', compact('photo'));
    }

    /**
     * @param Photo $photo
     *
     * @return Factory|View
     */
    public function edit(Photo $photo)
    {
        return view('admin.photos.edit', compact('photo'));
    }

    /**
     * @param UpdatePhoto $request
     * @param Photo   $photo
     *
     * @return RedirectResponse|Redirector
     *
     * @throws DiskDoesNotExist
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function update(UpdatePhoto $request, Photo $photo)
    {
        $title = $request->get('title');

        if ($title !== $photo->title) {
            $photo->title = $title;

            $photo->save();
        }

        //Store Image
        if ($request->hasFile('image')) {
            $photo->addMediaFromRequest('image')->toMediaCollection('payload');
        }

        return redirect("/admin/photos/{$photo->id}")->with('success', 'Информация о фото обновлена!');
    }

    /**
     * @param Photo $photo
     *
     * @return RedirectResponse|Redirector
     *
     * @throws \Exception
     */
    public function destroy(Photo $photo)
    {
        $photo->delete();

        return redirect("/admin/photos/")->with('success', 'Фото удалено успешно!');
    }
}
