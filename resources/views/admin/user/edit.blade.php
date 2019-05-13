<?php global $currInput; $priceAll = 0;?>
@extends('admin.template.master')
@section('pageName', "Пользователь ID ".$currInput['id'])
@if(isset($input) && $input)
@section('pageSubName')
    <a href="/superuser/user/delete/{{$input["id"]}}" class="btn btn-sm btn-danger deleteButton">Удалить</a>
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
                        <p>Имя Фамилия:{{$currInput['name'].' '.$currInput['second']}}</p>
                        <p>E-mail:{{ $currInput['email'] }}</p>
                        <p>Пол:{{ $currInput['sex'] == 1 ? "Мужской" : ($currInput['sex'] == 0 ? "Женский" : "Не указан") }}</p>
                        @if($currInput['phone'])<p>Номер телефона: {{$currInput['phone']}}</p>@endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Аддрес</h3>
                </div>
                <div class="panel-body">
                    <div>
                        @if(isset($currInput['address']['country']) &&$currInput['address']['country'])<p>
                            Страна: {{$currInput['address']['country']}}</p>@endif

                        @if(isset($currInput['address']['state']) && $currInput['address']['state'])<p>
                            Регион: {{$currInput['address']['state']}}</p>@endif

                        @if(isset($currInput['address']['city']) &&$currInput['address']['city'])<p>
                            Город: {{$currInput['address']['city']}} </p>@endif

                        @if(isset($currInput['address']['street']) &&$currInput['address']['street'])<p>
                            Улица: {{$currInput['address']['street']}}</p>@endif

                        @if(isset($currInput['address']['house']) &&$currInput['address']['house'])<p>
                            Дом: {{$currInput['address']['house']}}</p>@endif

                        @if(isset($currInput['address']['apartment']) &&$currInput['address']['apartment'])<p>
                            Квартира: {{$currInput['address']['apartment']}}</p>@endif

                        @if(isset($currInput['address']['index']) &&$currInput['address']['index'])<p>
                            Почтовый индекс: {{$currInput['address']['index']}}</p>@endif

                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Настройки рассылки</h3>
                </div>
                <div class="panel-body">
                    <div>
                        @if(isset($currInput['dispatch']['allNews']))<p> Показывать новые новости:{{$currInput['dispatch']['allNews']     ? "Да" : "Нет"}}</p>@endif
                        @if(isset($currInput['dispatch']['userUpdate']))<p> Показывать обновления пользователей:{{$currInput['dispatch']['userUpdate']  ? "Да" : "Нет"}}</p>@endif
                        @if(isset($currInput['dispatch']['seller']))<p> Отображать новости продавцов:           {{$currInput['dispatch']['seller']      ? "Да" : "Нет"}}</p>@endif
                        @if(isset($currInput['dispatch']['novelty']))<p> Показывать новинки:                     {{$currInput['dispatch']['novelty']     ? "Да" : "Нет"}}</p>@endif
                        @if(isset($currInput['dispatch']['sale']))<p> Показывать расспродажи:                 {{$currInput['dispatch']['sale']        ? "Да" : "Нет"}}</p>@endif
                        @if(isset($currInput['dispatch']['newNews']))<p> Показывать новые новости:               {{$currInput['dispatch']['newNews']     ? "Да" : "Нет"}}</p>@endif


                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection