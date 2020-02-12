<table class="table table-striped table-sm f-s-13">
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
			<th title="[Затраты] / [Кол. лидов]">CPL, руб.</th>
			<th title="[Затраты] / [Кол. активаций]">Стоимость активации</th>
			<th title="[Кол. активаций] / [Кол. лидов] * 100">Конверсия, %</th>
		</tr>
	</thead>
	@forelse($report as $row)
		<tr>
			<td>{{ $row['city'] }}</td>
			<td class="f-s-12">
				{{ $row['subProject'] }}
				<br>
				{{ $row['url'] }}
			</td>
			<td>{{ $row['partner'] }}</td>
			<td>{{ $row['channel'] }}</td>
			<td class="text-right nowrap">
				с {{ $row['dateFrom']->format('d.m.Y') }}<br>
				по {{ $row['dateTo']->format('d.m.Y')}}
			</td>
			<td class="text-right">{{ $row['leads'] }}</td>
			<td class="text-right">{{ $row['activations'] }}</td>
			<td class="text-right">{{ $row['cost'] }}</td>

			<td class="text-right nowrap">{{ App\Helpers\TextHelper::numberFormat(App\Helpers\CalcHelper::cpl($row['leads'], $row['cost']),2) }}</td>
			<td class="text-right">{{ App\Helpers\TextHelper::numberFormat(App\Helpers\CalcHelper::cpl($row['activations'], $row['cost']),2) }}</td>
			<td class="text-right">{{ App\Helpers\TextHelper::numberFormat(App\Helpers\CalcHelper::percent($row['activations'], $row['leads']),2) }}%</td>
		</tr>
	@empty
		<tr>
			<td colspan="10">Данных нет</td>
		</tr>
	@endforelse
</table>