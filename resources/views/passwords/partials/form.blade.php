<div class="form-row">
	<div class="form-group col-md-6">
		<label for="name">Пароль</label>
		{!! Form::text('name',null, ['class' => 'form-control form-control-sm', 'required' => "true"] )!!}
	</div>
	<div class="form-group col-md-6">
		<label for="comment">Комментарий</label>
		{!! Form::text('comment',null, ['class' => 'form-control form-control-sm'] )!!}
	</div>
</div>

<div class="form-row">
	<div class="form-group col-md-6">
		<label for="cities">Города</label>
		<select id="cities" name="cities[]" class="form-control" multiple>
			@php
				$passwordCities = [];
				if ($password->cities) {
					foreach ($password->cities as $passwordCity) $passwordCities[] = $passwordCity->id;
				}
			@endphp
			@foreach ($cities as $city_id => $city_name)
				<option value="{{ $city_id }}" @if (in_array($city_id, $passwordCities)) selected="selected" @endif>{{ $city_name }}</option>
			@endforeach
		</select>
	</div>
	<div class="form-group col-md-6">
		<label for="tags">Тип аудитории</label>
		<select id="tags" name="tags[]" class="form-control" multiple>
			@php
				$passwordTags = [];
				if ($password->tags) {
					foreach ($password->tags as $passwordTag) $passwordTags[] = $passwordTag->id;
				}
			@endphp
			@foreach ($tags as $tag_id => $tag_name)
				<option value="{{ $tag_id }}" @if (in_array($tag_id, $passwordTags)) selected="selected" @endif>{{ $tag_name }}</option>
			@endforeach
		</select>
	</div>
</div>

<div class="form-group">
	{!! \Form::submit('Сохранить', ['class'=> 'btn btn-primary']) !!}
</div>

@push('js')
	<script type="text/javascript" src="{{ asset('/vendor/select2/select2.full.min.js') }}"></script>
	<script>
		$('#tags').select2({
			placeholder: "Выберите тэги",
		});
		$('#cities').select2({
			placeholder: "Выберите город",
		});
	</script>
@endpush

@push('css')
	<link rel="stylesheet" type="text/css" href="{{ asset('/vendor/select2/select2.min.css') }}">
@endpush