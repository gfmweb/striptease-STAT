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
									<option value="">Партнер</option>
									@foreach ($users as $user)
										<option value="{{ $user->id }}">{{ $user->name }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group mb-2 col-md-3">
								<select name="project" class="form-control form-control-sm">
									<option value="">Проект</option>
									@foreach ($projects as $project)
										<option value="{{ $project->id }}">{{ $project->name }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group mb-2 col-md-3">
								<select name="channel" class="form-control form-control-sm">
									<option value="">Канал</option>
									@foreach ($channels as $channel)
										<option value="{{ $channel->id }}">{{ $channel->name }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group mb-2 col-md-3">
								<select name="status" class="form-control form-control-sm">
									<option value="">Статус</option>
									@foreach ($statuses as $status)
										<option value="{{ $status->id }}">{{ $status->name }}</option>
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
									<th>Канал</th>
									<th>Статус</th>
									<th>Создан</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($targets as $target)
									<tr class="table-{{ $target->status->class }}">
										<td>{{ $target->id }}</td>
										<td>{{ $target->userSubProject->user->name }}</td>
										<td>{{ $target->userSubProject->subProject->project->name }}</td>
										<td>{{ $target->userSubProject->subProject->name }}</td>
										<td>{{ $target->channel->name }}</td>
										<td>{{ $target->status->name }}</td>
										<td>{{ $target->created_at }}</td>
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