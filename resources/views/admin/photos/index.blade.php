@extends('layouts.admin')

@section('page-content')
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
                <th>Название</th>
                <th>Превью</th>
                <th>Кол-во лайков</th>
                <th>Редактировать</th>
                <th>Удалить</th>
            </tr>
            @foreach($photos as $photo)

                <tr>
                    <td>{{ $photo->title }}</td>
                    <td><img src="{{ $photo->getMedia('payload')->first()->getUrl('thumb') }}" alt="{{ $photo->title }}"></td>
                    <td>{{ $photo->likes->count() }}</td>
                    <td><a href="{{ route('admin.photos.edit', $photo->id) }}">Редактировать</a></td>
                    <td>
                        <form action="{{ route('admin.photos.destroy', $photo->id) }}" method="POST">
                            @method('DELETE')
                            @csrf

                            <input type="submit" value="Удалить">
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
        {{ $photos->links() }}
    @else
        До сих пор ни одной фотографии!
    @endif
@endsection
