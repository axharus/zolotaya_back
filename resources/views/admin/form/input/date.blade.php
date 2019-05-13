<div class="form-group @if($errors->any() && isset($errors->toArray()[$name])) has-error @endif" style="    position: relative;">
    <label>{{ $desc }} <small>{{ (isset($errors->toArray()[$name][0]) ? "(".$errors->toArray()[$name][0].")" : '') }}</small></label>
    <input class="form-control datetimepicker withtimestamp" data-format="{{$format}}"  id="idform{{ $name }}" name="{{ $name }}" placeholder="{{ $placeholder }}" value="{{ $input }}" @if($require) required="required" @endif>
</div>

<script>
    $(function () {
        $('#idform{{ $name }}').datetimepicker({
            locale: 'ru',
            format: "{{$format}}"
            //sideBySide: true
        });
    });
</script>