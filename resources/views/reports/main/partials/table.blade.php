<table class="f-s-13 font-family-arial table table-bordered table-sm table-striped report-table"
	   data-order='[[ 2, "asc" ]]'
	   data-page-length='25'>
	<thead>
		<tr>
			<th>Город</th>
			<th>Подпроект / Сайт</th>
			<th>Партнер</th>
			<th>Канал</th>
			<th>Неделя</th>
			<th>Охват</th>
			<th>Клики</th>
			<th>Лидов</th>
			<th>CTR,&nbsp;%</th>
			<th>Активаций</th>
			<th>Затраты, руб.</th>
			<th title="[Затраты] / [Кол. лидов]">CPL, руб.</th>
			<th title="[Затраты] / [Кол. активаций]">Стоимость активации</th>
			<th title="[Кол. активаций] / [Кол. лидов] * 100">Конверсия, %</th>
		</tr>
		<tr class="text-right bg-grey">
			<td colspan="5">Суммарно:</td>
			<td>{{ $report->sum('coverage') }}</td>
			<td>{{ $report->sum('clicks') }}</td>
			<td>{{ $report->sum('leads') }}</td>
			<td></td>
			<td>{{ $report->sum('activations') }}</td>
			<td>{{ App\Helpers\TextHelper::numberFormat($report->sum('cost')) }}</td>
			<td title="[сумма Затраты] / [сумма Кол. лидов]">{{ App\Helpers\TextHelper::numberFormat($report->cplSum(),2) }}</td>
			<td title="[сумма Затраты] / [сумма Кол. активаций]">{{ App\Helpers\TextHelper::numberFormat($report->activationPriceSum(),2) }}</td>
			<td title="[сумма Кол. активаций] / [сумма Кол. лидов] * 100">{{ App\Helpers\TextHelper::numberFormat($report->conversionSum(),2) }} %</td>
		</tr>
	</thead>
	<tbody>
		@forelse($report->items as $item)
			<tr>
				<td>{{ $item['city'] }}</td>
				<td class="f-s-12">
					<b>{{ $item['projectName'] }}</b><br>
					{{ $item['subProjectName'] }}<br>
					<a href="{{ $item['url'] }}">{{ $item['shortUrl'] }}</a>
					@if(!empty($item['subProjectTags'])) <br> @endif
					@foreach($item['subProjectTags'] as $tag)
						<span class="badge {{ $tag['class'] }} badge-sx" title="тег: {{ $tag['name']  }}">{{ $tag['name'] }}</span>
					@endforeach
				</td>
				<td>{{ $item['partner'] }}</td>
				<td>{{ $item['channel'] }}</td>
				<td class="text-right nowrap line-height-2">
					с {{ $item['dateFrom']->format('d.m.Y') }}<br>
					по {{ $item['dateTo']->format('d.m.Y')}}
				</td>
				<td class="text-right">{{ $item['coverage'] }}</td>
				<td class="text-right">{{ $item['clicks'] }}</td>
				<td class="text-right">{{ $item['leads'] }}</td>
				<td class="text-right">{{ $item['ctr'] }}%</td>
				<td class="text-right">{{ $item['activations'] }}</td>
				<td class="text-right">{{ App\Helpers\TextHelper::numberFormat($item['cost']) }}</td>

				<td class="text-right nowrap">{{ App\Helpers\TextHelper::numberFormat($item['cpl'],2) }}</td>
				<td class="text-right">{{ App\Helpers\TextHelper::numberFormat($item['activationPrice'],2) }}</td>
				<td class="text-right">{{ App\Helpers\TextHelper::numberFormat($item['conversionSum'],2) }}%</td>
			</tr>
		@empty
			<tr>
				<td colspan="10">Данных нет</td>
			</tr>
		@endforelse
	</tbody>
</table>