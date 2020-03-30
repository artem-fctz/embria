<?php

namespace App\Http\Controllers\Admin;

use App\Photo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $photos = Photo::with('media')->simplePaginate(5);

        return view('admin.photos.index', compact('photos'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.photos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $title = $request->input('title');

        $photo = new Photo();
        $photo->title = $title;
        $photo->author()->associate(auth()->user());
        $photo->save();


        //Store Image
        if($request->hasFile('image') && $request->file('image')->isValid()){
            $photo->addMediaFromRequest('image')->toMediaCollection('payload');
        }

        return redirect("/admin/photos/{$photo->id}")->with('success', 'Новое фото добавлено!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Photo  $photo
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Photo $photo)
    {
        return view('admin.photos.show', compact('photo'));
    }

    /**
     * EDIT the specified resource.
     *
     * @param  \App\Photo  $photo
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Photo $photo)
    {
        return view('admin.photos.edit', compact('photo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Photo $photo)
    {
        if($request->has('title') && $request->get('title') !== $photo->title) {
            $photo->title = $request->get('title');

            $photo->save();
        }


        //Store Image
        if($request->hasFile('image') && $request->file('image')->isValid()){
            $photo->addMediaFromRequest('image')->toMediaCollection('payload');
        }


        return redirect("/admin/photos/{$photo->id}")->with('success', 'Новое фото обновлено!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {
        $photo->delete();

        return redirect("/admin/photos/")->with('success', 'Фото удалено успешно!');
    }
}
