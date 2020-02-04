<div class="form-group row">
	{!! Form::label('name', 'Название', ['class' => 'col-sm-2 col-form-label']) !!}
	<div class="col-sm-10">
		{!! Form::text('name',null, ['class' => 'form-control', 'required' => "true"] )!!}
	</div>
</div>

<div class="form-group row">
	<div class="col-sm-10">
		{!! \Form::submit('Сохранить',['class'=> 'btn btn-dark']) !!}
	</div>
</div>
