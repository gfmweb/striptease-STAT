<div class="form-row">
	<div class="form-group col-md-6">
		<label for="name">Пароль</label>
		{!! Form::text('name',null, ['class' => 'form-control form-control-sm', 'required' => "true"] )!!}
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
	<label for="comment">Комментарий</label>
	{!! Form::text('comment',null, ['class' => 'form-control form-control-sm'] )!!}
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
	</script>
@endpush

@push('css')
	<link rel="stylesheet" type="text/css" href="{{ asset('/vendor/select2/select2.min.css') }}">
@endpush