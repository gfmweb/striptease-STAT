@extends('layouts.private')

@section('content')
	<div class="row page-titles">
		<div class="col p-0">
			<h4>Редактирование пароля</h4>
		</div>
		<div class="col p-0">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/passwords">Пароли</a></li>
				<li class="breadcrumb-item active">Пароль "{{ $password->name }}"</li>
			</ol>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					{!! Form::model($password, ['route' => ['passwords.update', $password->id], 'method' => 'PUT']) !!}
						@include('passwords.partials.form')
					{!! \Form::close(); !!}
				</div>
			</div>
		</div>
	</div>
@endsection