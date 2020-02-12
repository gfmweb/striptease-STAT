<table class="f-s-13 font-family-arial table table-bordered table-sm table-striped">
	<thead>
		<tr>
			<th>Город</th>
			<th>Подпроект / Сайт</th>
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
		<tr class="text-right bg-grey">
			<td colspan="5">Суммарно:</td>
			<td>{{ $report->sum('leads') }}</td>
			<td>{{ $report->sum('activations') }}</td>
			<td>{{ $report->sum('cost') }}</td>
			<td title="[сумма Затраты] / [сумма Кол. лидов]">{{ App\Helpers\TextHelper::numberFormat($report->cplSum(),2) }}</td>
			<td title="[сумма Затраты] / [сумма Кол. активаций]">{{ App\Helpers\TextHelper::numberFormat($report->activationPriceSum(),2) }}</td>
			<td title="[сумма Кол. активаций] / [сумма Кол. лидов] * 100">{{ App\Helpers\TextHelper::numberFormat($report->conversionSum(),2) }} %</td>
		</tr>
	</thead>
	@forelse($report->items as $item)
		<tr>
			<td>{{ $item['city'] }}</td>
			<td class="f-s-12">
				<b>{{ $item['projectName'] }}</b><br>
				{{ $item['subProjectName'] }}<br>
				<a href="{{ $item['url'] }}">{{ $item['shortUrl'] }}</a>
			</td>
			<td>{{ $item['partner'] }}</td>
			<td>{{ $item['channel'] }}</td>
			<td class="text-right nowrap line-height-2">
				с {{ $item['dateFrom']->format('d.m.Y') }}<br>
				по {{ $item['dateTo']->format('d.m.Y')}}
			</td>
			<td class="text-right">{{ $item['leads'] }}</td>
			<td class="text-right">{{ $item['activations'] }}</td>
			<td class="text-right">{{ $item['cost'] }}</td>

			<td class="text-right nowrap">{{ App\Helpers\TextHelper::numberFormat($item['cpl'],2) }}</td>
			<td class="text-right">{{ App\Helpers\TextHelper::numberFormat($item['activationPrice'],2) }}</td>
			<td class="text-right">{{ App\Helpers\TextHelper::numberFormat($item['conversionSum'],2) }}%</td>
		</tr>
	@empty
		<tr>
			<td colspan="10">Данных нет</td>
		</tr>
	@endforelse
</table>