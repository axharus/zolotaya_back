<div class="form-group summenrInstall">
    <label>{{ $desc }}</label>
    @foreach(F::langs() as $nameL => $lang)
        <small>{{ $nameL }}</small>
    <div class="summer_{{ $name.$lang }}">

    </div>
    <textarea name="{{ $name.$lang }}" style="display:none;">{!! (isset($input) && isset($input[$name.$lang]) ? $input[$name.$lang] : (Request::old($name.$lang) ? Request::old($name.$lang) : "")) !!}</textarea>

        <script>
            @if(!$repeat)
                    summenrInstall('{{$name.$lang}}');
            @endif
        </script>
    @endforeach
</div>
