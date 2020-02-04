@extends('layouts.private')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<div class="card-title mb-4">Редактирование проекта {{ $project->name }}</div>
					{!! Form::model($project, ['route' => ['projects.update', $project->id], 'method' => 'PUT']) !!}
						<div class="row">
							<div class="col-sm-10">
								{!! Form::text('name',null, ['class' => 'form-control', 'required' => "true"] )!!}
							</div>
							<div class="col-sm-2">
								{!! \Form::submit('Изменить имя',['class'=> 'btn btn-dark']) !!}
							</div>
						</div>
					{!! \Form::close(); !!}

					<hr>

					<h5 class="mb-3">Сайты проекта:</h5>
					<table class="table">
						<thead>
							<tr>
								<th>Имя</th>
								<th>URL</th>
								<th>Город</th>
								<th>Добавлен</th>
							</tr>
						</thead>
						@foreach($subProjects as $subProject)
							<tr>
								<td>{{ $subProject->name }}</td>
								<td>{{ $subProject->url }}</td>
								<td>
									@if ($subProject->city)
										{{ $subProject->city->name }}
									@endif
								</td>
								<td>{{ $subProject->created_at }}</td>
							</tr>
						@endforeach
					</table>
					<hr>
					<h5 class="mb-4">Добавить новый подпроект</h5>
					<form method="POST" action="/projects/{{ $project->id }}/addsubproject">
						<div class="form-group row">
							<label for="sub_project_name" class="col-sm-2 col-form-label">Имя</label>
							<div class="col-sm-10">
								<input type="text" name="sub_project_name" class="form-control" required>
							</div>
						</div>
						<div class="form-group row">
							<label for="sub_project_url" class="col-sm-2 col-form-label">Ссылка на сайт</label>
							<div class="col-sm-10">
								<input type="text" name="sub_project_url" class="form-control" required>
							</div>
						</div>
						<div class="form-group row">
							<label for="sub_project_city" class="col-sm-2 col-form-label">Город</label>
							<div class="col-sm-4">
								<select name="sub_project_city" id="sub_project_city" class="form-control">
									@foreach ($cities as $city)
										<option value="{{ $city->id }}">{{ $city->name }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							<input type="submit" value="Добавить" class="btn btn-dark">
							{{ csrf_field() }}
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
