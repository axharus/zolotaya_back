@extends('admin.template.master')
@section('pageName', 'Комментарии')

@section('content')
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>E-mail</th>
                <th>Комментарий</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $list)
                <tr>
                    <td>{{$list->id}} </td>
                    <td>{{$list->name}} </td>
                    <td>{{$list->user_info->email }}</td>
                    <td>{{$list->text}} </td>
                    <td>
                        @if($list->approved == 0)<a href="/superuser/comments/approve/{{$list->id}}" class="btn btn-sm btn-primary">Утвердить</a>@endif
                        <a href="/superuser/comments/delete/{{$list->id}}" class="btn btn-sm btn-danger deleteButton">Удалить</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection