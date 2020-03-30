@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-3">
                <ul>
                    <li><a href="/admin/">Главная</a></li>
                    <li><a href="/admin/articles">Статьи</a></li>
                    <li><a href="/admin/photos">Фото</a></li>
                </ul>
            </div>
            <div class="col-9">
                @yield('page-content')
            </div>
        </div>
    </div>
@endsection
