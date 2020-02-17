<div class="row">
	<div class="col-sm-10">
		{!! Form::text('name',null, ['class' => 'form-control form-control-sm', 'required' => "true"] )!!}
	</div>
	<div class="col-sm-2">
		{!! \Form::submit('Указать имя', ['class'=> 'btn btn-primary']) !!}
	</div>
</div>