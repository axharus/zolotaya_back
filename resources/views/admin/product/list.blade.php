@extends('admin.template.master')
@section('pageName', "Товары")
@section('pageSubName')
	<a href="/superuser/product/edit/0" class="btn btn-success">Добавить</a>
@endsection

@section('content')
	<div class="table-responsive">
		<table class="table table-bordered table-hover">
			<thead>
			<tr>
				<th>ID</th>
				<th>Фото</th>
				<th>Название</th>
				<th>Цена</th>
				<th>Раздел</th>
				<!--<th>Категория</th>-->
				<th>Наличие</th>
				<th>Действия</th>
			</tr>
			</thead>
			<tbody>
			@foreach($data as $item)
				<tr>
					<td>{{$item->id}}</td>
					<td><img src="{{isset(json_decode($item->gallery)[0]) ? \U::path(json_decode($item->gallery)[0]) : ''}}" alt="" width="100px"></td>
					<td>{{$item->{H::lang('name')} ? $item->{H::lang('name')} : "Нету"}}</td>
					<td class="hotPrice" data-id="{{$item->id}}">{{$item->price}}</td>
					<td>
						@if(isset($item->sec->{H::lang('name')}))
							{{ $item->sec->{H::lang('name')} }}
						@else
							{{ dd($item, '33') }}
						@endif
					</td>
					{{--<td>
						@if(isset($item->cat->{H::lang('name')}))
							{{ $item->cat->{H::lang('name')} }}
						@else
							{{ dd($item->cat, '40') }}
						@endif
					</td>--}}
					<td>{{ $item->stock }}</td>
					<td>
						<a href="/superuser/product/edit/{{$item->id}}" class="btn btn-sm btn-primary">Редактировать</a>
						<a href="/superuser/product/delete/{{$item->id}}"
						   class="btn btn-sm btn-danger deleteButton">Удалить</a>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>

@endsection