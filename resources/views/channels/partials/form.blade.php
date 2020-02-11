@php /** @var $channel \App\Channel */ @endphp
<div class="form-group row">
	{!! Form::label('name', 'Название', ['class' => 'col-sm-2 col-form-label']) !!}
	<div class="col-sm-10">
		{!! Form::text('name', null, ['class' => 'form-control', 'required' => "true"] )!!}
	</div>
</div>

<div class="form-group row">
	{!! Form::label('channel_group_id', 'Группа каналов', ['class' => 'col-sm-2 col-form-label']) !!}
	<div class="col-sm-10">
		<select class="form-control" id="channel_group_id" name="group_id">
			<option value="">Не указана</option>
			@foreach ($groups as $group_id => $group_name)
				<option value="{{ $group_id }}" @if ($group_id == $channel->group_id) selected="selected" @endif>{{ $group_name }}</option>
			@endforeach
		</select>
	</div>
</div>

<div class="form-group row">
	<div class="col-sm-10">
		{!! \Form::submit('Сохранить',['class'=> 'btn btn-primary']) !!}
	</div>
</div>
