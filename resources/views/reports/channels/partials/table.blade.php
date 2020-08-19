<div class="scroll-x">
	<table class="f-s-13 font-family-arial table table-bordered table-sm table-striped report-table"
		   data-order='[[ 2, "asc" ]]'
		   data-page-length='25'>
		<thead>
			<tr class="text-center">
				<th>Город</th>
				<th>Проект</th>
				<th>Подпроект / Сайт</th>
				<th>Канал</th>
				<th>Статус</th>
			</tr>
		</thead>
		<tbody>
			@forelse($report->items as $item)
				<tr class="report-row">
					<td>{{ $item['city'] }}</td>
					<td>{{ $item['projectName'] }}</td>
					<td class="f-s-12">
						<b>{{ $item['subProjectName'] }}</b><br>
						<a href="{{ $item['url'] }}">{{ $item['shortUrl'] }}</a>
						@if(!empty($item['subProjectTags'])) <br> @endif
						@foreach($item['subProjectTags'] as $tag)
							<span class="badge {{ $tag['class'] }} badge-sx" title="тег: {{ $tag['name']  }}">{{ $tag['name'] }}</span>
						@endforeach
					</td>
					<td>{{ $item['channel'] }}</td>
					<td class="text-middle text-center bg-{{ $item['statusClass'] }}">{{ $item['status'] }}</td>
				</tr>
			@empty
				<tr>
					<td colspan="5">Данных нет</td>
				</tr>
			@endforelse
		</tbody>
	</table>
</div>