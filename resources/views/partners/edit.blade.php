@extends('layouts.private')

@section('content')
	<div class="card">
		<div class="card-body">
			<div class="card-title mb-4">Редактирование партнера {{ $partner->name }}</div>
			{!! Form::model($partner, ['route' => ['partners.update', $partner->id], 'method' => 'PUT']) !!}
				@include('partners.partials.form')
			{!! \Form::close(); !!}
		</div>
	</div>


	<div class="card" style="margin-bottom: 100px;">
		<div class="card-body">
			<div class="card-title mb-4">Проекты партнера {{ $partner->name }}</div>
			@if (count($userSubProjects) > 0)
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Проект</th>
							<th>Подпроект</th>
							<th>URL</th>
							<th>Город</th>
							<th>Добавлен</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($userSubProjects as $userSubProject)
							<tr>
								<td>{{ $userSubProject->project->name }}</td>
								<td>{{ $userSubProject->name }}</td>
								<td>{{ $userSubProject->url }}</td>
								<td>
									@if ($userSubProject->city)
										{{ $userSubProject->city->name }}
									@endif
								</td>
								<td>{{ $userSubProject->created_at }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			@else
				<p>У партнера пока не добавлено проектов.</p>
			@endif
			<hr>
			<h5 class="mb-4">Добавить партнеру новый проект</h5>
			<form action="{{ route('partners.addsubproject', $partner->id) }}" name="add_project_form" method="POST">
				<div class="form-group">
					<label for="project_id">Проект</label>
					<select name="project_id" class="form-control">
						<option value="">Выберите проект</option>
						@foreach ($projects as $project)
							<option value="{{ $project->id }}">{{ $project->name }}</option>
						@endforeach
					</select>
				</div>

				<div id="select_sub_project" style="display: none;">
					<div class="form-group" id="subprojects_list">
						<label for="sub_project_id">Подпроект</label>
						<select name="sub_project_id" class="form-control" required>
							<option value="">Выберите подпроект</option>
							@foreach ($subProjects as $subProject)
								<option data-project="{{ $subProject->project_id }}" value="{{ $subProject->id }}" hidden>
									{{ $subProject->name }} @if ($subProject->city) ({{ $subProject->city->name }}) @endif
								</option>
							@endforeach
						</select>
					</div>
					{{ csrf_field() }}
					<input type="submit" value="Добавить" class="btn btn-dark">
				</div>
			</form>
		</div>
	</div>

@endsection


@push('js')
	<script>
		$(function(){
			$('select[name=project_id]').on('change', function(){
				$('#select_sub_project').hide();
				$('select[name=sub_project_id]').val('');
				$('select[name=sub_project_id] option[data-project]').attr('hidden', 'hidden');
				if (this.value != '') {
					$('#select_sub_project').fadeIn(200);
					var project = this.value;
					$('select[name=sub_project_id] option[data-project='+project+']').removeAttr('hidden');
				}
			})
		})
	</script>
@endpush