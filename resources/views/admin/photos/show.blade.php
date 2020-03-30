@extends('layouts.admin')

@section('page-content')
    <div class="row">
        <div class="col-10">
            <h1>Фотография # {{ $photo->id }}</h1>

        </div>
        <div class="col-2">
            <a href="{{ route('admin.photos.index') }}" class="btn btn-primary">Назад</a>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <label for="title">Название</label>
            <input id="title" name="title" class="form-control" type="text" disabled value="{{ $photo->title }}">
        </div>

        <div class="form-group">
            <label for="image">Файл</label>
            <img src="{{ asset($photo->getMedia('payload')->first()->getUrl('thumb')) }}" alt="{{ $photo->title }}">
        </div>
    </div>
@endsection
