@extends('layouts.admin')

@section('page-content')
    Количество статей: {{ $countArticles }} шт.
    Количество фотографий: {{ $countPhotos }} шт.
    Количество лайков: {{ $countLikes }} шт.
@endsection
