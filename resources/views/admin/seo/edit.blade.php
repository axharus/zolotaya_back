@extends('admin.template.master')
@section('pageName', "SEO")
@if(isset($input) && $input)
    @section('pageSubName')
        <a href="/superuser/seo/delete/{{$input["id"]}}" class="btn btn-sm btn-danger deleteButton">Удалить</a>
    @endsection
@endif

@section('content')
    <div class="col-xs-12">
        {!! F::o('/superuser/seo/edit') !!}
            {!! F::hide('id')!!}
            {!! F::input('url', 'Url страницы для которой предназначено seo описание', true, 'text', false, false) !!}
            {!! F::textarea('keywords', 'Keywords ключи, записывать нужно через запятую') !!}
            {!! F::textarea('description', 'Description описание') !!}

            {!! F::textarea('title', 'Title, Название страницы') !!}
            {!! F::input('name', 'Название для визуального seo блока (если оно там предусмотренно)', false) !!}
            {!! F::textarea('sub', 'Подзаголовок для визуального seo блока') !!}
            {!! F::textarea('content', 'Описание для визуального seo блока') !!}
        {!!F::c()!!}
    </div>

@endsection