@extends('layouts.private')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<div class="card-title mb-4">Создание проекта {{ $project->name }}</div>
					{!! Form::model($project, ['route' => ['projects.store'], 'method' => 'POST']) !!}
					@include('projects.partials.form')
					{!! \Form::close(); !!}
				</div>
			</div>
		</div>
	</div>
@endsection
