@extends('template.app')

@section('title', 'Clients')

@section('content')
    <div class="container-fluid">
        <h1 class="mt-4">{{ __('Clients') }}</h1>
        <a href="{{ route('clients.create') }}" class="btn btn-primary button-new" role="button">{{ __('New Client') }}</a>

        @if(session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        
        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    @if(count($clients))
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">{{ __('Name') }}</th>
                                    <th class="px-4 py-2">{{ __('Contact Name') }}</th>
                                    <th class="px-4 py-2">{{ __('Phone') }}</th>
                                    <th class="px-4 py-2">{{ __('Email') }}</th>
                                    <th class="px-4 py-2">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($clients as $key => $client)
                                    <tr>
                                        <td>{{ $client->client_name }}</td>
                                        <td>{{ $client->contact_name }}</td>
                                        <td>{{ $client->phone }}</td>
                                        <td>{{ $client->email }}</td>
                                        <td>
                                            <form role="form" method="POST" action="{{ route('clients.remove', array($client->id)) }}">
                                                @method('DELETE')
                                                @csrf
                                                <a href="{{ route('clients.edit', array($client->id)) }}" title="Edit" class="ml-2 text-decoration-none">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="ml-2 alert-danger bg-white border-0" title="Remove" onclick="return confirm('{{ __('Do you really want to remove this client?') }}');">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach                                
                            </tbody>
                        </table>
                    @else
                        <h6>
                            {{ __('Any result was found') }} :(
                        </h6>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection