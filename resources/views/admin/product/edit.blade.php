@extends('admin.template.master')
@section('pageName', "Товар")
@if(isset($input) && $input)
    @section('pageSubName')
        <a href="/superuser/product/delete/{{$input["id"]}}" class="btn btn-sm btn-danger deleteButton">Удалить</a>
    @endsection
@endif

@section('content')
    <div class="col-xs-12">
        {!! F::o('/superuser/product/edit') !!}
            {!! F::hide('id')!!}
            {!! F::input('name', 'Название') !!}
            {!! F::chosen('section', 'Меню', 'meta', H::lang('name'), 1, ['type', 'section'], true) !!}
            {!! F::chosen('insection', 'В разделе', $inSection, H::lang('name'), 4, false, false) !!}
            {!! F::chosen('cat', 'Категория', 'meta', H::lang('name'), 1, ['type', 'cat'], true) !!}
            {!! F::input('price', 'Цена', true, 'number', false, false) !!}
            {!! F::input('bprice', 'Старая Цена', false, 'number', false, false) !!}

            {!! F::chosen('color', 'Цвет', 'meta', 'name_ru', false, ['type', 'color'], true) !!}

            {!! F::repeaterOpen('gallery_color', 'Галерея по цветах', 'rep_color') !!}
                {!! F::image('photo', 'Галерея по цветах', '466,89,240', '702,133,308', 1, true) !!}
            {!! F::repeaterClose('gallery_color') !!}

            {!! F::chosen('size', 'Размер', 'meta', H::lang('name'), false, ['type', 'size'], true) !!}
            <div class="row">
                <div class="col-xs-12 col-sm-6"> {!! F::image('gallery', 'Главное фото', '466,89,240', '702,133,308', 1, true) !!}</div>
                <div class="col-xs-12 col-sm-6">{!! F::image('gallery_hover', 'Главное фото (наведено) ', '466,89,240', '702,133,308', 1, true) !!}</div>
            </div>
            {!! F::textarea('data', 'Описание','true') !!}
            {!! F::input('vendor', 'Артикул', true, 'text', false, false) !!}
            {!! F::chosen('related', 'С этим товаром покупают', 'product', H::lang('name'), 20, false, false) !!}
            {!! F::chosen('to_buy', 'С этим товаром сочитается', 'product', H::lang('name'), 20, false, false) !!}
            {!! F::input('stock', 'Количество в наличии', true, 'number', false, false) !!}

        {!!F::c()!!}
    </div>

@endsection