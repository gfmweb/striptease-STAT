@php /** @var $channel \App\Channel */ @endphp
<div class="form-group row">
	{!! Form::label('name', 'Название', ['class' => 'col-sm-2 col-form-label']) !!}
	<div class="col-sm-10">
		{!! Form::text('name',null, ['class' => 'form-control', 'required' => "true"] )!!}
	</div>
</div>
<fieldset @if($channel->hasSubChannels()) disabled="disabled" @endif >
	<div class="form-group row">
		{!! Form::label('parent_id', 'Вложен в (другой канал)', ['class' => 'col-sm-2 col-form-label']) !!}
		<div class="col-sm-10">
			{!! Form::select('parent_id', $channels, $channel->parent_id, ['class' => 'form-control'] + ($channel->hasSubChannels() ? ['readonly' => 'readonly']: [] )) !!}
		</div>
	</div>
</fieldset>

<div class="form-group row">
	<div class="col-sm-10">
		{!! \Form::submit('Сохранить',['class'=> 'btn btn-dark']) !!}
	</div>
</div>
