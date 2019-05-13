@extends('admin.template.master')
@section('pageName', 'Страницы')
@if(isset($input) && $input)
@section('pageSubName')
    <a href="/superuser/pages/delete/{{$input["id"]}}" class="btn btn-sm btn-danger deleteButton">Удалить</a>
@endsection
@endif

@section('content')
    <div class="col-xs-12">
        {!! F::o('/superuser/pages/edit') !!}
            {!! F::hide('id')!!}
            {!! F::input('name', 'Название') !!}
            {!! F::image('photo', 'Фото', 1903, 552, 1, true) !!}
            {!! F::wys('text', 'Контент') !!}
        {!!F::c()!!}
    </div>

@endsection