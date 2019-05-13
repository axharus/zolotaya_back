@extends('admin.template.master')
@section('pageName', \App\Http\Controllers\Admin\MetaController::name($type))
@section('pageSubName')
    <a href="/superuser/meta/edit/{{$type}}/0" class="btn btn-success">Добавить</a>
    <a href="/superuser/meta/section" class="btn btn-info">Разделы</a>
    <a href="/superuser/meta/cat" class="btn btn-info">Категории</a>
    <a href="/superuser/meta/color" class="btn btn-info">Цвета</a>
    <a href="/superuser/meta/size" class="btn btn-info">Размеры</a>
    <a href="/superuser/meta/tags" class="btn btn-info">Теги для блога</a>
    <a href="/superuser/meta/footer" class="btn btn-info">Футер</a>
    <a href="/superuser/meta/menu" class="btn btn-info">Меню</a>
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>Название</th>
                <th>Сортировка</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $someelse)
                <tr>
                    <td>{{$someelse->{H::lang('name')} ? $someelse->{H::lang('name')} : "Нету"}}</td>
                    <td>{{$someelse->sort}}</td>
                    <td>
                        <a href="/superuser/meta/edit/{{$type}}/{{$someelse->id}}" class="btn btn-sm btn-primary">Редактировать</a>
                        <a href="/superuser/meta/delete/{{$someelse->id}}"
                           class="btn btn-sm btn-danger deleteButton">Удалить</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection