@extends('layouts.admin')

@section('page-content')
    <div class="row">
        <div class="col-10">
            <h1>Статьи</h1>
        </div>

        <div class="col-2">
            <a href="{{ route('admin.articles.create') }}" class="btn btn-success">Создать</a>
        </div>
    </div>
    @if(count($articles))
        <table>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Кол-во лайков</th>
                <th>Редактировать</th>
                <th>Удалить</th>
            </tr>
            @foreach($articles as $article)
                <tr>
                    <td>{{ $article->id }}</td>
                    <td>{{ $article->title }}</td>
                    <td>{{ $article->likes->count() }}</td>
                    <td><a href="{{ route('admin.articles.edit', $article->id) }}">Редактировать</a></td>
                    <td>
                        <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST">
                            @method('DELETE')
                            @csrf

                            <input type="submit" value="Удалить">
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>

        {{ $articles->links() }}
    @else
        До сих пор ни одной Статьи!
    @endif
@endsection
