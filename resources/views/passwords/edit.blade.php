@extends('layouts.private')

@section('content')
	<div class="row page-titles">
		<div class="col p-0">
			<h4>Редактирование проекта "{{ $password->name }}"</h4>
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
					hr>
					<h5 class="mb-4">Добавить новый подпроект</h5>
					<form method="POST" action="{{ route('password-city.create', $password->id) }}">
						<div class="form-group row">
							<label for="sub_password_city" class="col-sm-2 col-form-label">Город</label>
							<div class="col-sm-4">
								<select name="city_id" id="city_id" class="form-control">
									@foreach ($cities as $city)
										<option value="{{ $city->id }}">{{ $city->name }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							@csrf
							<input type="submit" value="Добавить подпроект" class="btn btn-primary">
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>
@endsection