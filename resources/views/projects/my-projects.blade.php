@extends('layouts.private')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<div class="card-title mb-4">Мои проекты</div>
					<div class="table-responsive">
						<table class="table table-sm">
							<thead>
								<tr>
									<th>Проект</th>
									<th>Подпроект</th>
									<th>Город</th>
									<th>Назначен</th>
									<th>Ссылка</th>
									<th>Каналов</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								@foreach($subProjects as $subProject)
									<tr>
										<td><a href="{{ route('my-projects.channels',$subProject['project']->id) }}">{{ $subProject['project']->name }}</a></td>
										<td>{{ $subProject['name'] }}</td>
										<td>{{ $subProject['city'] ? $subProject['city']->name : '-' }}</td>
										<td>{{ $subProject['appointedAt']->format('d.m.Y') }}</td>
										<td>
											@empty($subProject['url'])
											@else
												<a href="{{$subProject['fullUrl']}}" target="_blank">{{$subProject['url']}}</a>
											@endempty
										</td>
										<td>
											@if ($subProject['channelsCount'] > 0)
												<a href="{{ route('my-projects.channels',$subProject['project']->id) }}">{{ $subProject['channelsCount'] }}</a>
											@else
												{{$subProject['channelsCount']}}
											@endif
										</td>
										<td><a href="{{ route('my-projects.channels.edit',$subProject['id']) }}" title="Добавить каналы"><i class="fa fa-plus"></i></a></td>
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