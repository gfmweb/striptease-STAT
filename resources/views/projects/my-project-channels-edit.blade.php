@extends('layouts.private')

@section('content')
	<div class="row page-titles">
		<div class="col p-0">
			<h4>Каналы проекта "{{ $subProject->fullname }}"</h4>
		</div>
		<div class="col p-0">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/my-projects">Мои проекты</a></li>
				<li class="breadcrumb-item"><a href="/my-projects/{{ $subProject->id }}/channels">{{ $subProject->fullname }}</a></li>
				<li class="breadcrumb-item active">Добавление каналов</li>
			</ol>
		</div>
	</div>
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
				<ul>
					@foreach($channels as $id => $name)
						<li>
							{!! \Form::checkbox('channels[]', $id,null, ['id'=> 'channel_' . $id]) !!}
							<label for="channel_{{$id}}" class="cursor-pointer mb-0">{{ $name }}</label>
						</li>
					@endforeach
				</ul>
				<a href="/my-projects/{{ $subProject->id }}/channels" class="pull-left btn btn-outline-dark">Назад</a>
				{!! \Form::submit('Добавить',['class'=>'btn btn-success ml-3']) !!}

				{!! \Form::close() !!}
			</div>
		</div>
	</div>
@endsection