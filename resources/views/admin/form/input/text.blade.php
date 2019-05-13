<div class="form-group">
    <label>{{ $desc }} @if($require) <span style="color: red; font-size: large;">*</span> @endif</label>
    @foreach(F::langs() as $nameL => $language)
        @if($lang)
            <?php $nameG = $name . $language;?>
        @else
            <?php $nameG = $name;?>
        @endif
        @if($lang)
            <br><small>{{ $nameL }}</small>
        @endif
        <textarea class="form-control" name="{{ $nameG }}" @if($require) required="required" @endif rows="3"
                  placeholder="{{ $placeholder }}">{{ (isset($input) && isset($input[$nameG]) ? $input[$nameG] : (Request::old($nameG) ? Request::old($nameG) : "")) }}</textarea>

        @if(!$lang) @break @endif
    @endforeach
</div>