@extends('layouts.private')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<div class="card-title">Список проектов</div>
					<div class="table-responsive">
						<a href="{{ route('channels.create') }}"
						   class="btn btn-xs btn-outline-dark pull-right" title="Добавить канал"><i
									class="fa fa-plus-square-o"></i></a>
						<table class="table table-striped table-sm">
							<thead>
								<tr>
									<th>#</th>
									<th>Название</th>
									<th>Создан</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								@foreach($projects as $project)
									<tr>
										<td>{{ $project->id }}</td>
										<td>{{ $project->name }}</td>

										<td>{{ $project->created_at->format('d.m.Y') }}</td>
										<td>
											<a href="{{ route('projects.edit',$project->id) }}"
											   class="btn btn-xs btn-outline-dark"><i class="fa fa-pencil"></i>
											</a>
											<a href="{{ route('projects.destroy',$project->id) }}"
											   class="btn btn-xs btn-outline-dark btn-destroy"><i class="fa fa-remove"></i>
											</a>
										</td>
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