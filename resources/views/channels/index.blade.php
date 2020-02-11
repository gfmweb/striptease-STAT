@php /** @var $channel \App\Channel */ @endphp
@extends('layouts.private')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<div class="card-title mb-4">
						Список каналов
						<a href="{{ route('channels.create') }}"
						   class="btn btn-sm btn-primary pull-right" title="Добавить канал"><i class="fa fa-plus"></i> Создать новый канал</a>
					</div>
					<div class="table-responsive">
						<table class="table table-striped table-sm">
							<thead>
								<tr>
									<th>#</th>
									<th>Название</th>
									<th>Группа каналов</th>
									<th>Создан</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								@foreach($channels as $channel)
									<tr>
										<td>{{ $channel->id }}</td>
										<td>{{ $channel->name }}</td>
										<td>{{ $channel->group ? $channel->group->name : '—'}}</td>
										<td>{{ $channel->created_at->format('d.m.Y') }}</td>
										<td class="text-right">
											<a href="{{ route('channels.edit', $channel->id) }}"
											   class="btn btn-xs btn-outline-dark"><i class="fa fa-pencil"></i>
											</a>
											<a href="{{ route('channels.destroy',$channel->id) }}"
											   class="btn btn-xs btn-danger btn-destroy"><i class="fa fa-remove"></i>
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