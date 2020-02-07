@extends('layouts.private')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<div class="card-title mb-4">
						Список партнеров
						<a href="{{ route('partners.create') }}"
						   class="btn btn-sm btn-primary pull-right" title="Добавить партнера"><i class="fa fa-plus"></i> Создать нового партнера</a>
					</div>
					<div class="table-responsive">
						<table class="table table-striped table-sm">
							<thead>
								<tr>
									<th>#</th>
									<th>Имя</th>
									<th>E-mail</th>
									<th>Создан</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								@foreach($partners as $partner)
									<tr>
										<td>{{ $partner->id }}</td>
										<td>{{ $partner->name }}</td>
										<td>{{ $partner->email }}</td>
										<td>{{ $partner->created_at->format('d.m.Y') }}</td>
										<td class="text-right">
											<a href="{{ route('partners.edit',$partner->id) }}"
											   class="btn btn-xs btn-outline-dark"><i class="fa fa-pencil"></i>
											</a>
											<a href="{{ route('partners.destroy',$partner->id) }}"
											   class="btn btn-xs btn-danger"><i class="fa fa-remove"></i>
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