@extends('layouts.private')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<div class="card-title">Редактирование проекта {{ $project->name }}</div>
					{!! Form::model($project, ['route' => ['projects.update', $project->id], 'method' => 'PUT']) !!}
					@include('projects.partials.form')
					{!! \Form::close(); !!}
				</div>
			</div>
		</div>
	</div>
@endsection
