@extends('layouts.private')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<div class="card-title">Список пользователей</div>
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>#</th>
									<th>Имя</th>
									<th>Username</th>
									<th>Баланс</th>
									<th>Язык</th>
									<th>Реферер</th>
									<th>Рефералов</th>
									<th>Дата регистрации</th>
									<th>Оплачен до</th>
									<th></th>
								</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">Последние платежи <span data-toggle="tooltip" data-placement="top"
																   title="Последние 10"
																   class="badge badge-success">10</span></h4>

				</div>
			</div>
		</div>
	</div>
@endsection
