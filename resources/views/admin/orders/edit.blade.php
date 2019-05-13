<?php global $currInput; $priceAll = 0;?>
@extends('admin.template.master')
@section('pageName', "Заказ №".$currInput['orderid'])
@if(isset($input) && $input)
@section('pageSubName')
    <a href="/superuser/blog/delete/{{$input["id"]}}" class="btn btn-sm btn-danger deleteButton">Удалить</a>
@endsection
@endif

@section('content')
    <div class="col-xs-12">
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Общая информация</h3>
                </div>
                <div class="panel-body">
                    <div>
                        <h4>ID Заказа: {{$currInput['orderid']}}</h4>
                        <p>Создан:{{ date('d M Y - H:i:s', $currInput['created_at']) }}</p>
                        @if($currInput['note'])<p>Дополнение от менеджера: <span style="color: #fe7075; font-size: 18px">{{$currInput['note']}}</span></p>@endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Контакты</h3>
                </div>
                <div class="panel-body">
                    <?php  $user = \App\User::getSingle($currInput['user'], []);?>
                    <div>
                        <h4>ФИО: {{ $currInput['contacts']['name'] }}</h4>
                        <p>Телефон:{{$currInput['contacts']['phone']}}</p>
                        @if(isset($currInput['contacts']['delivery']) &&$currInput['contacts']['delivery'])<p>
                            Доставка: {{$currInput['contacts']['delivery'] == 'self' ? 'Самовывоз' : 'Новая почта'}}</p>@endif
                        @if(isset($currInput['contacts']['pay']) &&$currInput['contacts']['pay'])<p>Оплата:
                             {{$currInput['contacts']['pay'] == 'cash' ? 'Наличкой' : 'Картой'}}</p>@endif
                        @if(isset($currInput['contacts']['region']) &&$currInput['contacts']['region'])<p>
                            Область: {{$currInput['contacts']['region']}}</p>@endif
                        @if(isset($currInput['contacts']['city']) &&$currInput['contacts']['city'])<p>
                            Город: {{$currInput['contacts']['city']}}</p>@endif
                        @if(isset($currInput['contacts']['office']) &&$currInput['contacts']['office'])<p>
                            Отделение: {{$currInput['contacts']['office']}}</p>@endif
                        @if($currInput['user'])<a
                                href="/superuser/user/edit/{{$currInput['user']}}">Пользователь: {{$currInput['profile']['name']}} {{$currInput['profile']['second']}}</a>@endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Заказ</h3>
                </div>
                <div class="panel-body">
                    @foreach($currInput['order'] as $order)
                        <?php
                        $product = \App\Model\Product::getSingle($order['id'], []);
                        if ($product)
                            $priceAll += $product['price'] * $order['count'];
                        ?>
                        <div>
                            <h4>Название товара:
                                <a href="/superuser/product/edit/{{$order['id']}}">
                                    {{$product ?
                                    $product->name_ru : 'Удален'}}
                                </a>
                            </h4>
                            <p>
                                Размер:{{\App\Model\Meta::getOne($order['meta']['size']) ? \App\Model\Meta::getOne($order['meta']['size'])->name_ru : 'Удален'}}</p>
                            <p>
                                Цвет:{{\App\Model\Meta::getOne($order['meta']['color']) ? \App\Model\Meta::getOne($order['meta']['color'])->name_ru : 'Удален'}}</p>
                            <p>Цена за ед.: {{$product ? $product['price'] : 'Нету'}} у. е.</p>
                            <p>Количество:{{$order['count']}}</p>
                        </div>
                    @endforeach
                    <h3>Сумма: {{$priceAll}} у. е.</h3>
                </div>
            </div>
        </div>

        {!! F::o('/superuser/orders/edit') !!}
            {!! F::hide('id')!!}
            {!! F::select('success', 'Статус', true, $status, false) !!}
            {!! F::textarea('note', 'Дополнение от менеджера', false, false) !!}
        {!!F::c()!!}
    </div>

@endsection