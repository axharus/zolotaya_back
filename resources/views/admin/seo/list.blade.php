@extends('admin.template.master')
@section('pageName', "SEO")
@section('pageSubName')
    <a href="/superuser/seo/edit/0" class="btn btn-success">Добавить</a>
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>URL</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{ $item->url }}</td>
                    <td>
                        <a href="/superuser/seo/edit/{{$item->id}}" class="btn btn-sm btn-primary">Редактировать</a>
                        <a href="/superuser/seo/delete/{{$item->id}}"
                           class="btn btn-sm btn-danger deleteButton">Удалить</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection