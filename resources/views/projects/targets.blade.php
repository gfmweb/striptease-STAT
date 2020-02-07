@extends('layouts.private')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<div class="card-title mb-4">Статусы проектов</div>
					<form name="targets_filter" class="basic-form mb-4" action="" method="GET">
						<div class="form-row">
							<div class="form-group mb-2 col-md-3">
								<select name="user" class="form-control form-control-sm">
									<option value="">Выберите партнера</option>
									@foreach ($users as $user_id => $user_name)
										<option value="{{ $user_id }}" @if (Request::input('user') == $user_id) selected="selected" @endif>{{ $user_name }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group mb-2 col-md-3">
								<select name="project" class="form-control form-control-sm">
									<option value="">Выберите проект</option>
									@foreach ($projects as $project_id => $project_name)
										<option value="{{ $project_id }}" @if (Request::input('project') == $project_id) selected="selected" @endif>{{ $project_name }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group mb-2 col-md-3">
								<select name="city" class="form-control form-control-sm">
									<option value="">Выберите город</option>
									@foreach ($cities as $city_id => $city_name)
										<option value="{{ $city_id }}" @if (Request::input('city') == $city_id) selected="selected" @endif>{{ $city_name }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group mb-2 col-md-3">
								<select name="channel" class="form-control form-control-sm">
									<option value="">Выберите канал</option>
									@foreach ($channels as $channel)
										<option value="{{ $channel->id }}" @if (Request::input('channel') == $channel->id) selected="selected" @endif>{{ $channel->name }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group mb-2 col-md-3">
								<select name="status" class="form-control form-control-sm">
									<option value="">Выберите статус</option>
									@foreach ($statuses as $status_id => $status_name)
										<option value="{{ $status_id }}" @if (Request::input('status') == $status_id) selected="selected" @endif>{{ $status_name }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							<input type="submit" value="Отфильтровать" class="btn btn-secondary btn-sm">
						</div>
					</form>

					<hr>

					<div class="table-responsive">
						<table class="table table-sm">
							<thead>
								<tr>
									<th>#</th>
									<th>Партнер</th>
									<th>Проект</th>
									<th>Подпроект</th>
									<th>Город</th>
									<th>Канал</th>
									<th>Статус</th>
									<th>Последний комментарий</th>
									<th>Создан</th>
									<th>В работе с</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($targets as $target)
									<tr class="table-{{ $target->status->class }}">
										<td>{{ $target->id }}</td>
										<td>{{ $target->userSubProject->user->name }}</td>
										<td>{{ $target->userSubProject->subProject->project->name }}</td>
										<td>{{ $target->userSubProject->subProject->name }}</td>
										<td>
											@if ($target->userSubProject->subProject->city)
												{{ $target->userSubProject->subProject->city->name }}
											@endif
										</td>
										<td>{{ $target->channel->name }}</td>
										<td>{{ $target->status->name }}</td>
										<td>
											@if ($target->lastHistory)
												{{ $target->lastHistory->comment }}
											@endif
										</td>
										<td>{{ $target->created_at->format('H:i d.m.y') }}</td>
										<td>
											@if ($target->started_at)
												{{ $target->started_at->format('H:i d.m.y') }}
											@endif
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					{{ $targets->links() }}
				</div>
			</div>
		</div>
	</div>
@endsection