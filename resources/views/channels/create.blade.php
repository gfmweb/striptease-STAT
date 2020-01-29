@php /** @var $channel \App\Channel */ @endphp
@extends('layouts.private')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">Создание канала {{ $channel->name }}</div>
                    {!! Form::model($channel, ['route' => ['channels.store'], 'method' => 'POST']) !!}
                    @include('channels.partials.form')
                    {!! \Form::close(); !!}
                </div>
            </div>
        </div>
    </div>
@endsection
