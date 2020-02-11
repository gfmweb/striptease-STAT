@extends('layouts.private')

@section('content')
	<div class="row page-titles">
		<div class="col col-3 p-0">
			<h4>Редактирование подпроекта</h4>
		</div>
		<div class="col col-9 p-0">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/projects">Проекты</a></li>
				<li class="breadcrumb-item"><a href="/projects/{{ $project->id }}/edit">Проект "{{ $project->name }}"</a></li>
				<li class="breadcrumb-item active">{{ $subProject->name }} @if ($subProject->city) ({{ $subProject->city->name }})@endif</li>
			</ol>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<form method="POST" action="{{ route('projects.subproject.update', [$project->id, $subProject->id]) }}">
						<div class="form-group row">
							<label for="name" class="col-sm-2 col-form-label">Имя</label>
							<div class="col-sm-10">
								<input type="text" name="name" class="form-control" value="{{ $subProject->name }}" required>
							</div>
						</div>
						<div class="form-group row">
							<label for="url" class="col-sm-2 col-form-label">Ссылка на сайт</label>
							<div class="col-sm-10">
								<input type="text" name="url" class="form-control" value="{{ $subProject->url }}" required>
							</div>
						</div>
						<div class="form-group row">
							<label for="sub_project_city" class="col-sm-2 col-form-label">Город</label>
							<div class="col-sm-4">
								<select name="city_id" id="city_id" class="form-control">
									@foreach ($cities as $city_id => $city_name)
										<option value="{{ $city_id }}" @if ($subProject->city_id == $city_id) selected="selected" @endif>{{ $city_name }}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="form-group row">
							<label for="tags" class="col-sm-2 col-form-label">Тип аудитории</label>
							<div class="col-sm-4">
								<select id="tags" name="tags[]" class="form-control" multiple>
									@php
										$subProjectTags = [];
										if ($subProject->tags) {
											foreach ($subProject->tags as $subProjectTag) $subProjectTags[] = $subProjectTag->id;
										}
									@endphp
									@foreach ($tags as $tag_id => $tag_name)
										<option value="{{ $tag_id }}" @if (in_array($tag_id, $subProjectTags)) selected="selected" @endif>{{ $tag_name }}</option>
									@endforeach
								</select>
							</div>
						</div>


						<div class="form-group">
							@csrf
							<input type="submit" value="Изменить подпроект" class="btn btn-primary">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection

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