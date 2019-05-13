@extends('admin.template.master')
@section('pageName', \App\Http\Controllers\Admin\BlogController::names($type))
@if(isset($input) && $input)
@section('pageSubName')
    <a href="/superuser/blog/delete/{{$input["id"]}}" class="btn btn-sm btn-danger deleteButton">Удалить</a>
@endsection
@endif

@section('content')
    <div class="col-xs-12">
        {!! F::o('/superuser/blog/edit') !!}
            {!! F::hide('id')!!}
            {!! F::hide('type', $type)!!}
            {!! F::hide('page', 'full')!!}
            {!! F::hide('author', isset($input) && $input['author'] ? $input['author'] : \Auth::user()->id) !!}
            {!! F::input('name', 'Название') !!}
            {!! F::input('sub', 'Краткое описание') !!}
            {!! F::image('img', 'Фото', '1005,1005,1903,360', '366,441,552,200', 1, true) !!}
            {!! F::wys('content', 'Контент') !!}
            {!! F::select('for', 'Для кого', true, ['Мужчинам'=>'man', 'Женщинам'=>'woman'],false) !!}
            {!! F::chosen('tags', 'Рубрики', 'meta', 'name_ru', 5, ['type', 'tags']) !!}
        {!!F::c()!!}
    </div>

@endsection