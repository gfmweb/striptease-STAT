@extends('layouts.private')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<div class="card-title mb-4">Мои проекты</div>
					<div class="table-responsive">
						<table class="table table-sm table-striped">
							<thead>
								<tr>
									<th>Проект</th>
									<th>Подпроект</th>
									<th>Город</th>
									<th>Ссылка</th>
									<th>Назначен</th>
									<th colspan="2">Каналы</th>
								</tr>
							</thead>
							<tbody>
								@foreach($subProjects as $subProject)
									<tr>
										<td><a href="{{ route('my-projects.channels',$subProject['id']) }}">{{ $subProject['project']->name }}</a></td>
										<td>{{ $subProject['name'] }}</td>
										<td>{{ $subProject['city'] ? $subProject['city']->name : '-' }}</td>
										<td>
											@empty($subProject['url'])
											@else
												<a href="{{$subProject['fullUrl']}}" target="_blank">{{$subProject['url']}}</a>
											@endempty
										</td>
										<td>{{ $subProject['appointedAt']->format('d.m.Y') }}</td>
										<td>
											@if ($subProject['channelsCount'] > 0)
												<a href="{{ route('my-projects.channels',$subProject['id']) }}">{{ $subProject['channelsCount'] }}</a>
											@else
												{{$subProject['channelsCount']}}
											@endif
										</td>
										<td><a class="btn btn-sm btn-secondary btn-group" href="{{ route('my-projects.channels.edit',$subProject['id']) }}" title="Добавить каналы"><i class="fa fa-plus"></i></a></td>
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