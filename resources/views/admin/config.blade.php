@extends('admin.template.master')

@section('pageName', "Настройки сайта")

@section('content')
    <div class="col-xs-12">
        {!! F::o("/superuser/config") !!}
            {!!F::input("usd", "Курс доллара США", true, 'text', false, false)!!}
            {!!F::input("admin_mail", "E-mail для отправки форм с сайта")!!}
            {!!F::input("phone", "Номер телефона в оглавлении", true, 'text', false, false)!!}
            {!! F::image('logo', "Логотип", 150, 65) !!}

            {!! F::separ('Главная') !!}
            <div class="row">
                <div class="col-xs-4">
                    {!! F::input('main_news', 'Выводить новости', false, 'checkbox', false, false) !!}
                </div>
                <div class="col-xs-4">
                    {!! F::input('main_articles', 'Выводить статьи', false, 'checkbox', false, false) !!}
                </div>
                <div class="col-xs-4">
                    {!! F::input('main_reviews', 'Выводить обзоры', false, 'checkbox', false, false) !!}
                </div>
            </div>

            {!! F::separ('Настройки меню') !!}
            {!! F::chosen('publicSections', 'Разделы в главном меню', 'meta', H::lang('name'), 3, ['type', 'section'], true) !!}
            {!! F::input('price_d1', 'Диапазон цены до', true, 'number', false, false) !!}
            <div class="row">
                <div class="col-xs-6">{!! F::input('price_d2_1', 'Диапазон цены 1 от', true, 'number', false, false) !!}</div>
                <div class="col-xs-6">{!! F::input('price_d2_2', 'Диапазон цены 1 до', true, 'number', false, false) !!}</div>
            </div>
            <div class="row">
                <div class="col-xs-6">{!! F::input('price_d3_1', 'Диапазон цены 2 от', true, 'number', false, false) !!}</div>
                <div class="col-xs-6">{!! F::input('price_d3_2', 'Диапазон цены 2 до', true, 'number', false, false) !!}</div>
            </div>
            <div class="row">
                <div class="col-xs-6">{!! F::input('price_d4_1', 'Диапазон цены 3 от', true, 'number', false, false) !!}</div>
                <div class="col-xs-6">{!! F::input('price_d4_2', 'Диапазон цены 3 до', true, 'number', false, false) !!}</div>
            </div>
            <div class="row">
                <div class="col-xs-6">{!! F::input('price_d5_1', 'Диапазон цены 4 от', true, 'number', false, false) !!}</div>
                <div class="col-xs-6">{!! F::input('price_d5_2', 'Диапазон цены 4 до', true, 'number', false, false) !!}</div>
            </div>
            {!! F::input('price_d6', 'Диапазон цены от', true, 'number', false, false) !!}

            {!! F::separ('Соц. сети') !!}
            {!! F::input('Vkontakte', 'Vkontakte', false) !!}
            {!! F::input('Facebook', 'Facebook', false) !!}
            {!! F::input('Instagram', 'Instagram', false) !!}
            {!! F::input('Twitter', 'Twitter', false) !!}

            {!! F::separ('Товары') !!}
            {!! F::textarea('delivery_text', 'Текст доставки') !!}

            {!! F::wys('conf', 'Политика конфиденциальности') !!}


        {!!F::c()!!}
    </div>

@endsection