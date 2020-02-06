@extends('layouts.private')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<div class="card-title mb-4">Статусы проектов</div>
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