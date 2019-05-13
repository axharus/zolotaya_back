<div class="form-group  ">
    {{--has-error--}}
    <label>{{ $desc }} @if($require) <span style="color: red; font-size: large;">*</span> @endif</label>
    <br>

    @foreach(F::langs() as $nameL => $language)

        @if($lang)
            <?php $nameG = $name . $language;?>
        @else
            <?php $nameG = $name;?>
        @endif
        @if($lang)
            <small>{{ $nameL }}</small>@endif
        <input type="{{ $type }}" class="form-control" name="{{ $nameG }}" placeholder="{{ $placeholder }}"
               @if($type!="checkbox")
               value="{{ (isset($input) && isset($input[$nameG]) ? $input[$nameG] : (Request::old($nameG) ? Request::old($nameG) : "")) }}"
               @else
               {{isset($input) && isset($input[$nameG]) && $input[$nameG] ? "checked" : ""}}
               @endif
               {{$disable ? "disabled" : ""}}
               @if($require) required="required" @endif
        >
        @if(!$lang) @break @endif
    @endforeach
</div>