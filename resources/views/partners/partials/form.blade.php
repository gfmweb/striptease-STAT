<div class="form-group row">
	{!! Form::label('name', 'Имя', ['class' => 'col-sm-2 col-form-label']) !!}
	<div class="col-sm-10">
		{!! Form::text('name',null, ['class' => 'form-control', 'required' => "true"] )!!}
	</div>
</div>
<div class="form-group row">
	{!! Form::label('email', 'E-mail', ['class' => 'col-sm-2 col-form-label']) !!}
	<div class="col-sm-10">
		{!! Form::text('email',null, ['class' => 'form-control', 'required' => "true"] )!!}
	</div>
</div>
<div class="form-group row">
	{!! Form::label('login', 'Логин', ['class' => 'col-sm-2 col-form-label']) !!}
	<div class="col-sm-10">
		{!! Form::text('login',null, ['class' => 'form-control', 'required' => "true"] )!!}
	</div>
</div>
<div class="form-group row">
	{!! Form::label('password', 'Пароль', ['class' => 'col-sm-2 col-form-label']) !!}
	<div class="col-sm-10">
		{!! Form::password('password', ['class' => 'form-control', 'required' => "true"] )!!}
	</div>
</div>
<div class="form-group row">
	<div class="col-sm-10">
		{!! \Form::submit('Сохранить',['class'=> 'btn btn-dark']) !!}
	</div>
</div>