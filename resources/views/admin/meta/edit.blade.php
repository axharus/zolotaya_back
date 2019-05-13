@extends('admin.template.master')
@section('pageName', \App\Http\Controllers\Admin\MetaController::name($type))
@if(isset($input) && $input)
    @section('pageSubName')
        <a href="/superuser/meta/delete/{{$type}}/{{$input["id"]}}" class="btn btn-sm btn-danger deleteButton">Удалить</a>
    @endsection
@endif

@section('content')
    <div class="col-xs-12">
        {!! F::o('/superuser/meta/edit/'.$type.'') !!}
            {!! F::hide('id')!!}
            {!! F::input('name', 'Название') !!}
            @if( $type == 'color' )
                {!! F::input('data', $type == 'color' ? 'Цвет' : 'Название', true, $type == 'color' ? 'color' : 'text', false, false) !!}
            @elseif( $type == 'footer' )
                {!! F::input('data', 'Ссылка', true, 'text', false, false) !!}
                {!! F::select('parent', 'Секция', 1, ['УСЛУГИ И СЕРВИС' => 1, 'КЛИЕНТАМ'=>2, 'О НАС'=>3], false) !!}
                {{--{!! F::chosen('parent', 'Родительский элемент', 'meta', 'name_ru', 1, ['type', 'sitemap'], false) !!}--}}
            @elseif($type == 'menu')
                {!! F::input('data', 'Ссылка', true, 'text', false, false) !!}
            @elseif($type == 'section')
                {!! F::image('data', 'Фото раздела', 460, 215) !!}
            @endif
            {!! F::input('sort', 'Приоритет в сортировке', false, 'number', false, false) !!}
        {!!F::c()!!}
    </div>

@endsection