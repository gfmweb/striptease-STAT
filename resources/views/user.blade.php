@extends('layouts.private')

@section('content')
	<div class="row page-titles">
		<div class="col p-0">
			<h4><span>Карточка пользователя</span> {{ $user->first_name }} {{ $user->last_name }}</h4>
		</div>
		<div class="col p-0">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a>
				</li>
				<li class="breadcrumb-item active">Карточка пользователя {{ $user->username }}</li>
			</ol>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<div class="card-title">Привычки</div>
					@if (count($user->problems))
						<div class="table-responsive">
							<table class="table table-striped">
								<thead>
									<tr>
										<th>#</th>
										<th>Привычка</th>
										<th>Причина бросить</th>
										<th>Кайф</th>
										<th>Добавлено</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($user->problems as $problem)
										<tr>
											<td>{{ $problem->id }}</td>
											<td>{{ $problem->text }}</td>
											<td>{{ $problem->why_drop }}</td>
											<td>{{ $problem->buzz }}</td>
											<td>{{ $problem->created_at ? $problem->created_at->format('d.m.Y') : '' }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					@else
						Пользователь еще не добавлял привычек.
					@endif
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">Платежи</h4>
					@if ($user->moneyMovements->isEmpty())
						Оплат еще не было.
					@else
						<div class="timeline-">
							<ul class="timeline">
								@foreach ($user->moneyMovements as $mm)
									<li>
										<div class="timeline-badge success"></div>
										<span href="#" class="timeline-panel">
											<span class=" text-muted">{{ $mm->created_at ? $mm->created_at->format('d.m.Y') : '' }}</span>
											<b class="text-success">+{{ $mm->value }} руб.</b>
											<b class="m-t-5">{{ $mm->info }}</b>
										</span>
									</li>
								@endforeach
							</ul>
						</div>
					@endif
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">Приглашенные пользователи</h4>
					@if ($user->referrals->isEmpty())
						Еще нет приглашенных пользователей.
					@else
						<div class="timeline-">
							<ul class="timeline">
								@foreach ($user->referrals as $referral)
									<li>
										<div class="timeline-badge primary"></div>
										<span href="#" class="timeline-panel">
											<span class=" text-muted">{{ $referral->created_at ? $referral->created_at->format('d.m.Y') : '' }}</span>

											<a href="{{ route('users.show',$referral->id) }}" data-toggle="tooltip"
											   data-placement="top" title="Профиль">
												{{ $referral->fullName }} @if($referral->username)
													({{ $referral->username }})@endif
												</a>

												<a href="{{ route('send',['users'=>[$referral->id]]) }}" class="ml-2"
												   data-toggle="tooltip" data-placement="top"
												   title="Отправить сообщение"><i class="fa fa-send-o"></i></a>

										</span>
									</li>
								@endforeach
							</ul>
						</div>
					@endif
				</div>
			</div>
		</div>
	</div>
@endsection
