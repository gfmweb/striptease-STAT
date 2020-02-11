@extends('layouts.private')

@section('content')
	<div class="row page-titles">
		<div class="col p-0">
			<h4>Статусы проекта "{{ $userSubProject->subProject->fullname }}"</h4>
		</div>
		<div class="col p-0">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/my-projects">Мои проекты</a></li>
				<li class="breadcrumb-item active">{{ $userSubProject->subProject->fullname }}</li>
			</ol>
		</div>
	</div>

	<div class="card">
		<div class="card-body">
			<div class="table-responsive">
				<a href="{{ route('my-projects.channels.edit',$userSubProject->subProject->id) }}" class="btn btn-success pull-right btn-sm">Добавить канал</a>
				<ul>
					<li><b>Проект:</b> {{ $userSubProject->subProject->project->name }}</li>
					<li><b>Подпроект:</b> {{ $userSubProject->subProject->name }}</li>
					<li><b>Город:</b> {{ $userSubProject->subProject->city ?  $userSubProject->subProject->city->name : '-' }}</li>
					<li><b>Назначен:</b> {{ $userSubProject->created_at->format('d.m.Y H:i') }}</li>
				</ul>
				<table class="table table-sm">
					<thead>
						<tr>
							<th>Канал</th>
							<th>Статус</th>
							<th>Последний комментарий</th>
						</tr>
					</thead>
					<tbody>
						@foreach($userSubProject->userTargets as $userTarget)
							<tr class="table-{{ $userTarget->status->class }}">
								<td>{{ $userTarget->channel->name }}</td>
								<td>
									<form action="{{ route('my-projects.update') }}" method="POST" name="update_target" data-target="{{ $userTarget->id }}">
										<div class="form-group mb-0">
											<select name="target_status" class="form-control form-control-sm">
												@foreach ($statuses as $status)
													<option value="{{ $status->id }}" @if ($status->id == $userTarget->status->id) selected="selected" @endif>{{ $status->name }}</option>
												@endforeach
											</select>
										</div>
										<div data-target-edit style="display: none;">
											<div class="form-group mt-2 mb-2">
												<textarea name="target_comment" class="form-control form-control-sm" style="height: 50px;" placeholder="Укажите комментарий к смене статуса"></textarea>
											</div>
											<div class="form-group mb-2">
												<input type="hidden" name="target_id" value="{{ $userTarget->id }}">
												@csrf
												<input type="submit" class="btn btn-primary btn-sm" value="Сменить статус">
											</div>
										</div>
									</form>
								</td>
								<td>
									@if ($userTarget->lastHistory)
										{{ $userTarget->lastHistory->comment }}
									@endif
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>

@endsection
@push('js')
	<script>
		$(function () {
			// смена статуса и комментария у таргета
			$('select[name=target_status]').on('change', function () {
				var status = this.value;
				var $form = $(this).closest('form[data-target]');
				var target = $form.data('target');

				$form.find('[data-target-edit]').slideDown(200);
			})
		})
	</script>
@endpush