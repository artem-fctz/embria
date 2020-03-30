@extends('layouts.admin')

@section('page-content')
    <div class="row">
        <div class="col-10">
            <h1>Создание новой Статьи</h1>

        </div>
        <div class="col-2">
            <a href="{{ route('admin.articles.index') }}" class="btn btn-primary">Назад</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.articles.store') }}" method="POST"  enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="title">Название</label>
                    <input id="title" name="title" class="form-control" type="text" tabindex="1">

                    @if ($errors->has('title'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('title') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="content">Содержание</label>
                    <textarea id="content" name="content" class="form-control" tabindex="2"></textarea>
                </div>

                <input type="submit" value="Сохранить" class="btn btn-success">
            </form>
        </div>
    </div>
@endsection
