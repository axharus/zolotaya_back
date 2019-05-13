<div class="form-group  ">
    <label>{{ $desc }} @if($require) <span style="color: red; font-size: large;">*</span> @endif</label>
    <br>

    @foreach(F::langs() as $nameL => $language)
        @if($lang)
            <?php $nameG = $name . $language;?>
        @else
            <?php $nameG = $name;?>
        @endif
        @if($lang)
            <small>{{ $nameL }}</small>
        @endif
        <select name="{{$nameG}}" {{$disable ? "disabled" : ""}} {{$require ? "required" : ""}}>
            @foreach($data as $name => $option)
                <option value="{{$option}}" {{isset($input) && isset($input[$nameG]) &&  $input[$nameG] == $option? "selected" : ""}}>{{$name}}</option>
            @endforeach
        </select>
        @if(!$lang) @break @endif
    @endforeach
</div>