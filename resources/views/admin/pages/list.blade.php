@extends('admin.template.master')
@section('pageName', 'Страницы')
@section('pageSubName')
    <a href="/superuser/pages/edit/0" class="btn btn-success">Добавить</a>
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Ссылка</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $list)
                <tr>
                    <td>{{$list->id}}</td>
                    <td>{{$list->name_ru}}</td>
                    <td>{{env('FRONT').'/ru'.'/page/'.$list->id}}</td>
                    <td>
                        <a href="/superuser/pages/edit/{{$list->id}}" class="btn btn-sm btn-primary">Редактировать</a>
                        <a href="/superuser/pages/delete/{{$list->id}}"
                           class="btn btn-sm btn-danger deleteButton">Удалить</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection