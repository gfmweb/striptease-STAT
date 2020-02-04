@php /** @var $channel \App\Channel */ @endphp
@extends('layouts.private')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">Редактирование канала {{ $channel->name }}</div>
                    {!! Form::model($channel, ['route' => ['channels.update', $channel->id], 'method' => 'PUT']) !!}
                    @include('channels.partials.form')
                    {!! \Form::close(); !!}
                </div>
            </div>
        </div>
    </div>
@endsection
