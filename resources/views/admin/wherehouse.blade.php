@extends('admin.template.master')

@section('pageName', "Оптовым покупателям")

@section('content')
    <div class="col-xs-12">
        {!! F::o("/superuser/wherehouse") !!}
            {!! F::input('name', 'Название') !!}
            {!! F::textarea('desc', 'Описание после оглавления') !!}

            {!! F::input('advantage_name1', 'Название преимущества 1') !!}
            {!! F::repeaterOpen('advantage1', 'Преимущества 1') !!}
                {!! F::input('name', 'Название преимущества') !!}
            {!! F::repeaterClose('advantage1') !!}

            {!! F::input('advantage_name2', 'Название преимущества 2') !!}
            {!! F::repeaterOpen('advantage2', 'Преимущества 2') !!}
                {!! F::input('name', 'Название преимущества') !!}
            {!! F::repeaterClose('advantage2') !!}


            {!! F::textarea('desc_close', 'Описание в конце') !!}

            {!! F::input('email', 'Почта для заявок', true, 'text', false, false) !!}
        {!!F::c()!!}
    </div>
@endsection