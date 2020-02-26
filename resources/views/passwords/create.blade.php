@extends('layouts.private')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<div class="card-title mb-4">Добавление пароля {{ $password->name }}</div>
					{!! Form::model($password, ['route' => ['passwords.store'], 'method' => 'POST']) !!}
					@include('passwords.partials.form')
					{!! \Form::close(); !!}
				</div>
			</div>
		</div>
	</div>
@endsection
