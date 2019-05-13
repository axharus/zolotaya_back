@extends('admin.template.master')
@section('pageName', \App\Http\Controllers\Admin\BlogController::names($type))
@section('pageSubName')
    <a href="/superuser/blog/{{$type}}/full/edit/0" class="btn btn-success">Добавить Тип 1</a>
    <a href="/superuser/blog/{{$type}}/short/edit/0" class="btn btn-success">Добавить Тип 2</a>
    <a href="/superuser/blog/news" class="btn btn-info">{{\App\Http\Controllers\Admin\BlogController::names('news')}}</a>
    <a href="/superuser/blog/articles" class="btn btn-info">{{\App\Http\Controllers\Admin\BlogController::names('articles')}}</a>
    <a href="/superuser/blog/reviews" class="btn btn-info">{{\App\Http\Controllers\Admin\BlogController::names('reviews')}}</a>
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Автор</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $list)
                <tr>
                    <td>{{$list->id}}</td>
                    <td>{{$list->name_ru}}</td>
                    <td>{{$list->author}}</td>
                    <td>
                        <a href="/superuser/blog/{{$type}}/{{$list->page}}/edit/{{$list->id}}" class="btn btn-sm btn-primary">Просмотреть|Редактировать</a>
                        <a href="/superuser/blog/delete/{{$list->id}}"
                           class="btn btn-sm btn-danger deleteButton">Удалить</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection