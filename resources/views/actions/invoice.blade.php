@extends('template.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <h1 class="mt-4">{{ __('Invoice') }}</h1>
        
        <div class="alert alert-success" role="alert">
            <h3>Invoice generated with success:</h3>
            <p>Project: {{ $actions['project']->name }}</p>
            <p>Client: {{ $actions['project']->client->client_name }}</p>
            <p>Time spent in hours: {{ $actions['time'] }}</p>
            <p>Total: DKK{{ $actions['value'] }}</p>
        </div>
    </div>
@endsection