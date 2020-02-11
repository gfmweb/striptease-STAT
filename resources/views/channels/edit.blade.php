@php /** @var $channel \App\Channel */ @endphp
@extends('layouts.private')

@section('content')
	<div class="row page-titles">
		<div class="col p-0">
			<h4>Редактирование канала "{{ $channel->name }}"</h4>
		</div>
		<div class="col p-0">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/channels">Каналы</a></li>
				<li class="breadcrumb-item active">{{ $channel->name }}</li>
			</ol>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					{!! Form::model($channel, ['route' => ['channels.update', $channel->id], 'method' => 'PUT']) !!}
					@include('channels.partials.form')
					{!! \Form::close(); !!}
				</div>
			</div>
		</div>
	</div>
@endsection
