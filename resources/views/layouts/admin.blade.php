@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
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
