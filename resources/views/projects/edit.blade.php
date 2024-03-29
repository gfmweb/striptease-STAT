@extends('layouts.private')

@section('content')
	<div class="row page-titles">
		<div class="col p-0">
			<h4>Редактирование проекта "{{ $project->name }}"</h4>
		</div>
		<div class="col p-0">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/projects">Проекты</a></li>
				<li class="breadcrumb-item active">Проект "{{ $project->name }}"</li>
			</ol>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					{!! Form::model($project, ['route' => ['projects.update', $project->id], 'method' => 'PUT']) !!}
						@include('projects.partials.form')
					{!! \Form::close(); !!}

					@if (count($subProjects) > 0)
						<hr>
						<h5 class="mb-3">Подпроекты:</h5>
						<table class="table table-sm table-striped">
							<thead>
								<tr>
									<th>#</th>
									<th>Имя</th>
									<th>URL</th>
									<th>Аудитория</th>
									<th>Город</th>
									<th>Добавлен</th>
									<th></th>
								</tr>
							</thead>
							@foreach($subProjects as $subProject)
								<tr>
									<td>{{ $subProject->id }}</td>
									<td>{{ $subProject->name }}</td>
									<td>{{ $subProject->url }}</td>
									<td>
										@if ($subProject->tags)
											@foreach ($subProject->tags as $tag)
												<span class="badge badge-sm badge-warning">
													{{ $tag->name }}
												</span>
											@endforeach
										@endif
									</td>
									<td>
										@if ($subProject->city)
											{{ $subProject->city->name }}
										@endif
									</td>
									<td>{{ $subProject->created_at->format('d.m.Y') }}</td>
									<td class="text-right">
										<a href="{{ route('projects.subproject.edit', [$project->id, $subProject->id]) }}"
										   class="btn btn-xs btn-outline-dark"><i class="fa fa-pencil"></i>
										</a>
										<a href="{{ route('projects.subproject.delete', [$project->id, $subProject->id]) }}"
										   class="btn btn-xs btn-danger btn-destroy"><i class="fa fa-remove"></i>
										</a>
									</td>
								</tr>
							@endforeach
						</table>

						<div class="text-right">
							<p class="mb-2">Применить выбранный тип аудитории ко всем подпроектам в проекте:</p>
							<form action="{{ route('projects.addtags', $project->id) }}" method="POST" class="form-inline pull-right">
								<select name="tags[]" id="tags" multiple class="form-control w-80pc">
									@foreach ($tags as $tag_id => $tag_name)
										<option value="{{ $tag_id }}">{{ $tag_name }}</option>
									@endforeach
								</select>
								@csrf
								<input type="submit" value="Применить" class="btn btn-primary ml-2">
							</form>
						</div>
						<div class="clearfix"></div>
					@endif

					<hr>
					<h5 class="mb-4">Добавить новый подпроект</h5>
					<form method="POST" action="{{ route('projects.subproject.add', $project->id) }}">
						<div class="form-group row">
							<label for="name" class="col-sm-2 col-form-label">Имя</label>
							<div class="col-sm-10">
								<input type="text" name="name" class="form-control" required>
							</div>
						</div>
						<div class="form-group row">
							<label for="url" class="col-sm-2 col-form-label">Ссылка на сайт</label>
							<div class="col-sm-10">
								<input type="text" name="url" class="form-control" required>
							</div>
						</div>
						<div class="form-group row">
							<label for="sub_project_city" class="col-sm-2 col-form-label">Город</label>
							<div class="col-sm-4">
								<select name="city_id" id="city_id" class="form-control">
									@foreach ($cities as $city)
										<option value="{{ $city->id }}">{{ $city->name }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							@csrf
							<input type="submit" value="Добавить подпроект" class="btn btn-primary">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection

@push('js')
	<script src="{{ asset('/vendor/select2/select2.full.min.js') }}"></script>
	<script>
		$(function(){
			$('#tags').select2()

			/*$('[data-delete]').click(function(e){
				e.preventDefault();
				if (confirm('Удалить подпроект?')) $(this).closest('td').find('form').submit();
			})*/
		})
	</script>
@endpush

@push('css')
	<link rel="stylesheet" type="text/css" href="{{ asset('/vendor/select2/select2.min.css') }}">
@endpush