@extends('layouts.private')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<div class="card-title mb-4">Редактирование партнера {{ $partner->name }}</div>
					{!! Form::model($partner, ['route' => ['partners.update', $partner->id], 'method' => 'PUT']) !!}
						@include('partners.partials.form')
					{!! \Form::close(); !!}
				</div>
			</div>
		</div>
	</div>
@endsection
