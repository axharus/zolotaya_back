<div class="form-group chosen @if($errors->any() && isset($errors->toArray()[$name])) has-error @endif">
    <label>{{ $desc }} @if($require) <span style="color: red; font-size: large;">*</span> @endif
        <small>{{ (isset($errors->toArray()[$name][0]) ? "(".$errors->toArray()[$name][0].")" : '') }}</small>
    </label>
    <select class="form-control" name="{{ $name }}" multiple data-placeholder="{{$desc}}">
        @foreach($data as $d)
            <option {{ isset($input) && isset($input[$name]) && in_array($d->id, $input[$name]) ? "selected" : "" }} value="{{$d->id}}">{{ $d->{$var} }}</option>
        @endforeach
    </select>
</div>

<script>
    $("select[name='{{$name}}']").chosen(
            @if($max)
                {max_selected_options: {{$max}}}
            @endif
    );
    @if($require)
    $(function(){
        $('form button').on('click',function(){
            if($("select[name='{{$name}}']").parent().find('.chosen-choices .search-choice').length == 0 && $("select[name='{{$name}}']").parent().find('.chosen-container:visible').length != 0){
                $("select[name='{{$name}}']").parent().find('.chosen-choices').css('border', '2px solid red');
                return false;
            }
        })
    })
    @endif

</script>