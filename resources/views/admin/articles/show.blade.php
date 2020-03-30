@extends('layouts.admin')

@section('page-content')
    <div class="row">
        <div class="col-10">
            <h1>Статья # {{ $article->id }}</h1>

        </div>
        <div class="col-2">
            <a href="{{ route('admin.articles.index') }}" class="btn btn-primary">Назад</a>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <label for="title">Название</label>
            <input id="title" name="title" class="form-control" type="text" disabled value="{{ $article->title }}">
        </div>

        <div class="form-group">
            <label for="image">Содержание</label>
            <p>{{ $article->content }}</p>
        </div>
    </div>
@endsection
