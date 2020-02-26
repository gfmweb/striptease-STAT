<table class="f-s-13 font-family-arial table table-bordered table-sm table-striped report-table"
	   data-order='[[ 2, "asc" ]]'
	   data-page-length='25'>
	<thead>
		<tr>
			<th>Пароль</th>
			<th>Неделя</th>
			<th>Москва</th>
			<th>Санкт-Петербург</th>
			<th>Казань</th>
			<th>Чебоксары</th>
		</tr>
	</thead>
	<tbody>
		@forelse($report->items as $item)
			<tr>
				<td>
					{{ $item['passwordName'] }}
					@if(!empty($item['tags'])) <br> @endif
					@foreach($item['tags'] as $tag)
						<span class="badge {{ $tag['class'] }} badge-sx" title="тег: {{ $tag['name']  }}">{{ $tag['name'] }}</span>
					@endforeach
				</td>
				<td class="text-right nowrap line-height-2">
					с {{ $item['dateFrom']->format('d.m.Y') }}<br>
					по {{ $item['dateTo']->format('d.m.Y')}}
				</td>
				@if(isset($item['msk']))
					<td>{{ $item['msk'] }}</td> @else
					<td>—</td> @endif
				@if(isset($item['spb']))
					<td>{{ $item['spb'] }}</td> @else
					<td>—</td> @endif
				@if(isset($item['kzn']))
					<td>{{ $item['kzn'] }}</td> @else
					<td>—</td> @endif
				@if(isset($item['che']))
					<td>{{ $item['che'] }}</td> @else
					<td>—</td> @endif
			</tr>
		@empty
			<tr>
				<td colspan="6">Данных нет</td>
			</tr>
		@endforelse
	</tbody>
</table>