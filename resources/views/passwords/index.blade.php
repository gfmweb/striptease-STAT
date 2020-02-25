@extends('layouts.private')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<div class="card-title mb-4">
						Список паролей
						<a href="{{ route('passwords.create') }}"
						   class="btn btn-sm btn-primary pull-right" title="Добавить проект"><i class="fa fa-plus"></i> Добавить новый пароль</a>
					</div>
					<div class="table-responsive">

						<table class="table table-striped table-sm">
							<thead>
								<tr>
									<th>#</th>
									<th>Название</th>
									<th>Комментарий</th>
									<th>Создан</th>
									<th class="text-right">Действия</th>
								</tr>
							</thead>
							<tbody>
								@foreach($passwords as $password)
									<tr>
										<td>{{ $password->id }}</td>
										<td>{{ $password->name }}</td>
										<td>{{ $password->comment }}</td>
										<td>{{ $password->created_at->format('d.m.Y') }}</td>
										<td class="text-right">
											<a href="{{ route('passwords.edit',$password->id) }}"
											   class="btn btn-xs btn-outline-dark"><i class="fa fa-pencil"></i>
											</a>
											<a href="{{ route('passwords.destroy',$password->id) }}"
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