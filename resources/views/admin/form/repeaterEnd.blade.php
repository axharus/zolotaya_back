</div>
<div class="form-group ">
    @if($priority)
    <label>Приоритет <small></small></label>
    <input class="form-control" style="width: 160px; margin-bottom: 10px;" type="number" name="num" placeholder="Приоритет">
        <button type="button" class="delete btn btn-danger">Удалить</button>
    @endif
</div>

</div>
<div class="body" data-i="{{ (isset($input) && isset($input[$name]) ? $input[$name] :  "") }}">

</div>
<button type="button" class="add btn btn-success">Добавить</button>
</div>
<script>
    $(function () {
        repeater('.{{$name}}')
    })
</script>