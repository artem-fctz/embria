@extends('layouts.admin')

@section('page-content')
    <div class="row">
        <div class="col-10">
            <h1>Изменение фотографии # {{ $photo->id }}</h1>

        </div>
        <div class="col-2">
            <a href="{{ route('admin.photos.index') }}" class="btn btn-primary">Назад</a>
        </div>
    </div>
    <div class="row">
        <form action="{{ route('admin.photos.update', $photo->id) }}" method="POST"  enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <div class="form-group">
                <label for="title">Название</label>
                <input id="title" name="title" class="form-control" type="text" value="{{ $photo->title }}">

                @if ($errors->has('title'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('title') }}</strong>
                    </span>
                @endif
            </div>

            <img src="{{ $photo->getMedia('payload')->first()->getUrl('thumb') }}" alt="{{ $photo->title }}">

            <div class="form-group">
                <label for="image">Файл</label>
                <input id="image" name="image" class="form-control-file" type="file" accept="image/*">
            </div>

            <input type="submit" value="Сохранить" class="btn btn-success">
        </form>
    </div>
@endsection
