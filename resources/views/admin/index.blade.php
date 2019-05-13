@extends('admin.template.master')

@section('pageName', "Главная страница")

@section('content')
    <div class="col-xs-12">
        {!! F::o("/superuser/index") !!}
            {!! F::repeaterOpen('slider', 'Главный слайдер') !!}
                {!! F::image('background', "Фон слайда", 1140, 415) !!}
                {!! F::input('head', 'Оглавление') !!}
                {!! F::textarea('description', 'Описание') !!}
                {!! F::input('link', 'Ссылка «Подробнее»') !!}
            {!! F::repeaterClose('slider') !!}

            {!! F::separ('Популярные товары') !!}
            {!! F::chosen('popularIndex', 'Популярные товары', 'product', 'name_ru', false) !!}
        {!!F::c()!!}
    </div>
@endsection