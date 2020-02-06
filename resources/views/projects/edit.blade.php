@extends('layouts.private')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<div class="card-title mb-4">Редактирование проекта {{ $project->name }}</div>
					{!! Form::model($project, ['route' => ['projects.update', $project->id], 'method' => 'PUT']) !!}
						@include('projects.partials.form')
					{!! \Form::close(); !!}

					@if (count($subProjects) > 0)
						<hr>
						<h5 class="mb-3">Подпроекты:</h5>
						<table class="table">
							<thead>
								<tr>
									<th>Имя</th>
									<th>URL</th>
									<th>Город</th>
									<th>Добавлен</th>
									<th></th>
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
									<td>
										<a href="#" data-delete data-toggle="tooltip" data-placement="top" title="Удалить"><i class="fa fa-close color-danger"></i></a>
										<form action="/projects/{{ $project->id }}/subproject/delete" method="POST" class="d-none">
											@csrf
											<input type="hidden" name="sub_project_id" value="{{ $subProject->id }}">
										</form>
									</td>
								</tr>
							@endforeach
						</table>
					@endif

					<hr>
					<h5 class="mb-4">Добавить новый подпроект</h5>
					<form method="POST" action="/projects/{{ $project->id }}/subproject/add">
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
							{{ csrf_field() }}
							<input type="submit" value="Добавить" class="btn btn-dark">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection

@push('js')
	<script>
		$(function(){
			$('[data-delete]').click(function(e){
				e.preventDefault();
				if (confirm('Удалить подпроект?')) $(this).closest('td').find('form').submit();
			})
		})
	</script>
@endpush