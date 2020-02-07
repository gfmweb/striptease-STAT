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
									<th>Канал</th>
									<th>Назначен</th>
									<th>Статус</th>
									<th>Последний комментарий</th>
								</tr>
							</thead>
							<tbody>
								@foreach($userTargets as $userTarget)
									<tr class="table-{{ $userTarget->status->class }}">
										<td>{{ $userTarget->userSubProject->subProject->project->name }}</td>
										<td>{{ $userTarget->userSubProject->subProject->name }}</td>
										<td>
											@if ($userTarget->userSubProject->subProject->city)
												{{ $userTarget->userSubProject->subProject->city->name }}
											@endif
										</td>
										<td>{{ $userTarget->channel->name }}</td>
										<td>{{ $userTarget->created_at->format('d.m.Y') }}</td>
										<td>
											<form action="{{ route('user-targets.update') }}" method="POST" name="update_target" data-target="{{ $userTarget->id }}">
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
					{{ $userTargets->links() }}
				</div>
			</div>
		</div>
	</div>
@endsection
@push('js')
	<script>
		$(function(){
			// смена статуса и комментария у таргета
			$('select[name=target_status]').on('change', function(){
				var status = this.value;
				var $form = $(this).closest('form[data-target]');
				var target = $form.data('target');

				$form.find('[data-target-edit]').slideDown(200);
			})
		})
	</script>
@endpush