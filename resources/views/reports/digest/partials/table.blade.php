<table class="table table-bordered table-sm table-striped report-table">
	<thead>
		<tr>
			<th colspan="2" rowspan="2">Наши действия</th>
			<th colspan="4" class="text-center">
				{{ $report->params['dateFrom'] ? $report->params['dateFrom']->format('d.m.y') : '' }} -
				{{ $report->params['dateTo'] ? $report->params['dateTo']->format('d.m.y') : '' }}
			</th>
		</tr>
		<tr>
			<th>Получатели</th>
			<th>Лиды</th>
			<th>Активации</th>
			<th>Бюджет</th>
		</tr>
	</thead>
	<tbody>
		@foreach($report->items as $group)
			@foreach ($group as $digest)
				<tr>
					@if ($loop->first)
						<th rowspan="{{ count($group) }}">{{ $digest['group_name'] }}</th>
					@endif
					<td>{{ $digest['name'] }}</td>
					<td>
						@if (!empty($digest['data']['coverage']))
							{{ $digest['data']['coverage'] }}
						@else
							-
						@endif
					</td>
					<td>
						@if (!empty($digest['data']['leads']))
							{{ $digest['data']['leads'] }}
						@else
							-
						@endif
					</td>
					<td>
						@if (!empty($digest['data']['activations']))
							{{ $digest['data']['activations'] }}
						@else
							-
						@endif
					</td>
					<td>
						@if (!empty($digest['data']['budget']))
							{{ $digest['data']['budget'] }}
						@else
							-
						@endif
					</td>
				</tr>
			@endforeach
		@endforeach
	</tbody>
</table>