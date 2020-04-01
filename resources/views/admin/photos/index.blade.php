@extends('layouts.admin')

@section('page-content')
    <div class="photo-list">
        <div class="row">
            <div class="col-10">
                <h1>Фотографии</h1>
            </div>

            <div class="col-2">
                <a href="{{ route('admin.photos.create') }}" class="btn btn-success">Создать</a>
            </div>
        </div>
        @if(count($photos))
            <table>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Превью</th>
                    <th>Кол-во лайков</th>
                    <th>Редактировать</th>
                    <th>Удалить</th>
                </tr>
                @foreach($photos as $photo)
                    <tr class="underline">
                        <td>{{ $photo->id }}</td>
                        <td>{{ $photo->title }}</td>
                        <td>
                            @if($photo->getMedia('payload')->first())
                                <img src="{{ $photo->getMedia('payload')->first()->getUrl('thumb') }}" alt="{{ $photo->title }}" class="preview">
                            @else
                                No image :(
                            @endif
                        </td>
                        <td>{{ $photo->likes->count() }}</td>
                        <td><a href="{{ route('admin.photos.edit', $photo->id) }}">Редактировать</a></td>
                        <td>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{$photo->id}}">
                                Удалить
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="deleteModal{{$photo->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Удаление изображения</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Вы уверены, что хотите удалить изображение #{{ $photo->id }}?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Нет</button>
                                            <form action="{{ route('admin.photos.destroy', $photo->id) }}" id="deleteModalForm{{$photo->id}}" method="POST">
                                                @method('DELETE')
                                                @csrf

                                                <button class="btn btn-primary" type="submit" form="deleteModalForm{{$photo->id}}">Удалить</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
            {{ $photos->links() }}
        @else
            До сих пор ни одной фотографии!
        @endif
    </div>
@endsection
