
<form role="form" action="{{ $action }}" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
