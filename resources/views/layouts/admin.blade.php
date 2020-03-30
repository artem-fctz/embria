@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div id="sidebar" class="col-3 py-4">
                <ul>
                    <li><a href="/admin/">Главная</a></li>
                    <li><a href="/admin/articles">Статьи</a></li>
                    <li><a href="/admin/photos">Фото</a></li>
                </ul>
            </div>
            <div class="col-9 p-4">
                @yield('page-content')
            </div>
        </div>
    </div>
@endsection
