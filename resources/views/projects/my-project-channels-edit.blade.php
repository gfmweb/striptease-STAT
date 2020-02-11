@extends('layouts.private')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<div class="card-title mb-4">Укажите необходимые каналы из доступных</div>
					<div class="table-responsive">
						<ul>
							<li><b>Проект:</b> {{ $subProject->project->name }}</li>
							<li><b>Подпроект:</b> {{ $subProject->name }}</li>
							<li><b>Город:</b> {{ $subProject->city ?  $subProject->city->name : '-' }}</li>
						</ul>
						{!! \Form::open(['route' => ['my-projects.channels.update',$subProject->id],'method'=>'POST']) !!}
						<table class="table table-sm">
							<thead>
								<tr>
									<th style="width: 30px"></th>
									<th>Канал</th>
								</tr>
							</thead>
							<tbody>
								@foreach($channels as $id => $name)
									<tr>
										<td>{!! \Form::checkbox('channels[]', $id,null, ['id'=> 'channel_' . $id]) !!}</td>
										<td><label for="channel_{{$id}}" class="cursor-pointer mb-0">{{ $name }}</label></td>
									</tr>
								@endforeach
							</tbody>
						</table>
						<a href="{{ route('my-projects',$subProject->id) }}" class="pull-left btn btn-outline-dark">Назад</a>
						{!! \Form::submit('Добавить',['class'=>'btn btn-success ml-3']) !!}

						{!! \Form::close() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection