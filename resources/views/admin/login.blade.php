<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ C::val("siteName") }}</title>

    <!-- Bootstrap Core CSS -->
    <link href="/admin/css/bootstrap.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/admin/css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/admin/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">


    <!-- jQuery -->
    <script src="/admin/js/jquery.js"></script>


    <script src="/admin/js/bootstrap.min.js"></script>

    <script src="/admin/js/main.js"></script>
</head>

<body>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Вход</h3>
                </div>
                <div class="panel-body">
                    <form role="form" action="/login" method="post">
                        <fieldset>
                            <div class="form-group {{$errors && $errors->first('login') ? "has-error" : ""}}">
                                <input class="form-control" placeholder="Email" name="login" type="text" autofocus>
                                @if($errors && $errors->first('login'))
                                    @foreach($errors->get('login') as $item)
                                        <span style="color: red">{{$item}}</span>
                                    @endforeach
                                @endif
                            </div>
                            <div class="form-group {{$errors && $errors->first('password') ? "has-error" : ""}} ">
                                <input class="form-control" placeholder="Пароль" name="password" type="password"
                                       value="">
                                @if($errors && $errors->first('password'))
                                    @foreach($errors->get('password') as $item)
                                        <span style="color: red">{{$item}}</span>
                                    @endforeach
                                @endif
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input name="remember" type="checkbox" value="Remember Me">Запомнить
                                </label>
                            </div>
                            <!-- Change this to a button or input when using this as a form -->
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <button class="btn btn-lg btn-success btn-block">Войти</button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>