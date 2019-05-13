<div class="form-group @if($require) imageRqui @endif" >
    <label>{{ $desc }} <small>Ширина: {{explode(',',$width)[0]}}; Высота: {{explode(',',$height)[0]}}; Формат: *.jpg, *.png</small> @if($require) <span style="color: red; font-size: large;">*</span> @endif</label>
    <input type="file" class="form-control fileInput"  name="inP{{ $name }}" multiple   value="{{ (isset($input) && isset($input[$name]) ? H::isJsonFalse($input[$name]) : "") }}"
            data-name="{{$name}}"
            data-width="{{$width}}"
            data-height="{{$height}}"
            data-input="{!! isset($input) && isset($input[$name]) && $input[$name] ? H::isJsonFalse($input[$name]) : "" !!}"
            data-max="{{$max}}">
    {!!  \F::hide($name, isset($input) && isset($input[$name]) && $input[$name] ? H::isJsonFalse($input[$name]) : "") !!}
</div>
@if(!$rep)
<script>
    fileInput(
            "{{$name}}",
            "{{$width}}",
            "{{$height}}",
            {{$max}}
            {!! isset($input) && isset($input[$name]) && $input[$name] ? ', \''.H::isJsonFalse($input[$name]).'\'' : "" !!}
    );
</script>
    @endif