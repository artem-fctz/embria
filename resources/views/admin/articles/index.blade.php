@extends('layouts.admin')

@section('page-content')
    <div class="article-list">
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
                    <tr class="underline">
                        <td>{{ $article->id }}</td>
                        <td>{{ $article->title }}</td>
                        <td>{{ $article->likes->count() }}</td>
                        <td><a href="{{ route('admin.articles.edit', $article->id) }}">Редактировать</a></td>
                        <td>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{$article->id}}">
                                Удалить
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="deleteModal{{$article->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Удаление статьи</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Вы уверены, что хотите удалить статью #{{ $article->id }}?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Нет</button>
                                            <form action="{{ route('admin.articles.destroy', $article->id) }}" id="deleteModalForm{{$article->id}}" method="POST">
                                                @method('DELETE')
                                                @csrf

                                                <button class="btn btn-primary" type="submit" form="deleteModalForm{{$article->id}}">Удалить</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>

            {{ $articles->links() }}
        @else
            До сих пор ни одной Статьи!
        @endif
    </div>
@endsection
