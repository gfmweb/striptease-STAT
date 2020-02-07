<table class="table table-striped table-sm">
	<thead>
		<tr>
			<th>Город</th>
			<th>Подпроект<br>Сайт</th>
			<th>Партнер</th>
			<th>Канал</th>
			<th>Неделя</th>
			<th>Лидов</th>
			<th>Активаций</th>
			<th>Затраты, руб.</th>
			<th>CPL, руб.</th>
			<th>Стоимость активации</th>
			<th>Конверсия, %</th>
		</tr>
	</thead>
	@forelse($report as $row)
		<tr>
			<td>{{ $row['city'] }}</td>
			<td class="nowrap" >
				{{ $row['subProject'] }}
				<br>
				{{ $row['url'] }}
			</td>
			<td>{{ $row['partner'] }}</td>
			<td>{{ $row['channel'] }}</td>
			<td style="white-space:nowrap">
				{{ $row['dateFrom']->format('d.m.Y') }}
				- {{ $row['dateTo']->format('d.m.Y')}}
			</td>
			<td class="text-right">{{ $row['leads'] }}</td>
			<td class="text-right">{{ $row['activations'] }}</td>
			<td class="text-right">{{ $row['cost'] }}</td>

			<td class="text-right nowrap">{{ App\Helpers\TextHelper::numberFormat(App\Helpers\CalcHelper::cpl($row['leads'], $row['price'] * $row['activations']),2) }}</td>
			<td class="text-right">{{ $row['price'] }}</td>
			<td class="text-right">{{ App\Helpers\TextHelper::numberFormat(App\Helpers\CalcHelper::percent($row['activations'], $row['leads']),2) }}%</td>
		</tr>
	@empty
		<tr>
			<td colspan="10">Данных нет</td>
		</tr>
	@endforelse
</table>