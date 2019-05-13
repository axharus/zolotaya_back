@extends('admin.template.master')
@section('pageName', 'Заказы')
@section('pageSubName')
    <a href="/superuser/orders/edit/0" class="btn btn-success">Добавить</a>
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>ФИО</th>
                <th>Пользователь</th>
                <th>ID заказа</th>
                <th>Выполнен</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $list)
                <tr>
                    <td>{{$list->id}}</td>
                    <td>{{$list->contacts['name']}}</td>
                    <td>{{$list->profile ? $list->profile['name'] : 'Нету'}}</td>
                    <td>{{$list->orderid}}</td>
                    <td>{{$list->success}}</td>
                    <td>
                        <a href="/superuser/orders/edit/{{$list->id}}" class="btn btn-sm btn-primary">Просмотреть|Редактировать</a>
                        <a href="/superuser/orders/delete/{{$list->id}}"
                           class="btn btn-sm btn-danger deleteButton">Удалить</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection