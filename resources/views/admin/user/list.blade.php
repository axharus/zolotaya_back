@extends('admin.template.master')
@section('pageName', $name)

@section('content')
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>ФИО</th>
                <th>E-mail</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $list)
                <tr>
                    <td>{{$list->id}}</td>
                    <td>{{$list->name}} {{$list->second}}</td>
                    <td>{{$list->email }}</td>
                    <td>
                        <a href="/superuser/user/edit/{{$list->id}}" class="btn btn-sm btn-primary">Просмотреть</a>
                        <a href="/superuser/user/delete/{{$list->id}}"
                           class="btn btn-sm btn-danger deleteButton">Удалить</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection