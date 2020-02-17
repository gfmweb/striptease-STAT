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
			<div class="clearfix">
				<ul class="pull-right text-right">
					<li><b>Проект:</b> {{ $subProject->project->name }}</li>
					<li><b>Подпроект:</b> {{ $subProject->name }}</li>
					<li><b>Город:</b> {{ $subProject->city ?  $subProject->city->name : '-' }}</li>
				</ul>
				<div class="card-title mb-4">Укажите необходимые каналы из доступных</div>
			</div>
			<div>

				{!! \Form::open(['route' => ['my-projects.channels.update',$subProject->id],'method'=>'POST']) !!}
				<ul>
					@foreach($channels as $id => $name)
						<li class="list-group-item">
							{!! \Form::checkbox('channels[]', $id,null, ['id'=> 'channel_' . $id]) !!}
							<label for="channel_{{$id}}" class="cursor-pointer mb-0">{{ $name }}</label>
						</li>
					@endforeach
				</ul>
				<a href="/my-projects/{{ $subProject->id }}/channels" class="btn btn-outline-secondary">Назад</a>
				{!! \Form::submit('Добавить',['class'=>'btn btn-primary ml-2','id'=>'add-channels-submit', 'style'=>'display:none']) !!}

				{!! \Form::close() !!}
			</div>
		</div>
	</div>
@endsection
@push('js')
	<script>
		$(() => {
			const checkboxList = $('input[name="channels[]"]');
			const submitButton = $('#add-channels-submit');
			checkboxList.change(() => {
				if (checkboxList.filter(':checked').length > 0) {
					submitButton.show();
				} else {
					submitButton.hide();
				}
			});
		});
	</script>
@endpush