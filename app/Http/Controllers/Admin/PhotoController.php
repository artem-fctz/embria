<?php

namespace App\Http\Controllers\Admin;

use App\Photo;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
     * @param Request $request
     *
     * @return RedirectResponse|Redirector
     *
     * @throws DiskDoesNotExist
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function store(Request $request)
    {
        $title = $request->input('title');

        $photo = new Photo();
        $photo->title = $title;
        $photo->author()->associate(auth()->user());
        $photo->save();

        //Store Image
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $photo->addMediaFromRequest('image')->toMediaCollection('payload');
        } else {
            $photo->delete();

            return redirect("/admin/photos/")->with('error', 'Ошибка при сохранении изображения!');
        }

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
     * @param Request $request
     * @param Photo   $photo
     *
     * @return RedirectResponse|Redirector
     *
     * @throws DiskDoesNotExist
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function update(Request $request, Photo $photo)
    {
        if ($request->has('title') && $request->get('title') !== $photo->title) {
            $photo->title = $request->get('title');

            $photo->save();
        }

        //Store Image
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
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
