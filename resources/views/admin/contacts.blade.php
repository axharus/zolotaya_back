@extends('admin.template.master')

@section('pageName', "Контакты")

@section('content')
    <div class="col-xs-12">
        {!! F::o("/superuser/contacts") !!}
            {!! F::repeaterOpen('slider', 'Контакты') !!}
                {!! F::input('name', 'Название офиса') !!}
                {!! F::textarea('desc', 'Описание офиса') !!}
                {!! F::input('phone1', 'Телефон 1') !!}
                {!! F::input('phone2', 'Телефон 2') !!}
                {!! F::input('phone3', 'Телефон 3') !!}
            {!! F::repeaterClose('slider') !!}
            {!! F::separ('Карта') !!}
            {!! F::input('lat', 'Latitude', true, 'text', false, false) !!}
            {!! F::input('lng', 'Longitude', true, 'text', false, false) !!}
        {!!F::c()!!}
    </div>
@endsection