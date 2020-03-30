@extends('layouts.admin')

@section('page-content')
    <div class="row">
        Количество статей: {{ $countArticles }} шт.
    </div>
    <div class="row">
        Количество фотографий: {{ $countPhotos }} шт.
    </div>
    <div class="row">
        Количество лайков: {{ $countLikes }} шт.
    </div>
@endsection
