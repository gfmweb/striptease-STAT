@extends('layouts.private')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<div class="card-title">Мои проекты</div>
					<div class="table-responsive">
						<table class="table table-striped table-sm">
							<thead>
								<tr>
									<th>Проект</th>
									<th>Подпроект</th>
									<th>Канал</th>
									<th>Назначен</th>
									<th>Статус</th>
									<th>Комментарий</th>
								</tr>
							</thead>
							<tbody>
								@foreach($userTargets as $userTarget)
									<tr data-subproject="{{ $userTarget->id }}">
										<td>{{ $userTarget->userSubProject->subProject->project->name }}</td>
										<td>{{ $userTarget->userSubProject->subProject->name }}</td>
										<td>{{ $userTarget->channel->name }}</td>
										<td>{{ $userTarget->created_at->format('d.m.Y') }}</td>
										<td>{{ $userTarget->status->name }}</td>
										<td>Коммент</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@push('js')
	<script type="text/javascript" src="/js/helpers/delete-button.js"></script>
@endpush