@extends('template.app')

@section('title', 'Projects')

@section('content')
    <div class="container-fluid">
        <h1 class="mt-4">{{ __('Projects') }}</h1>
        <a href="{{ route('projects.create') }}" class="btn btn-primary button-new" role="button">{{ __('New project') }}</a>

        @if(session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        
        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    @if(count($projects))
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">{{ __('Name') }}</th>
                                    <th class="px-4 py-2">{{ __('Client') }}</th>
                                    <th class="px-4 py-2">{{ __('Time Spent') }}</th>
                                    <th class="px-4 py-2">{{ __('Status') }}</th>
                                    <th class="px-4 py-2">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($projects as $key => $project)
                                    <tr>
                                        <td>{{ $project->name }}</td>
                                        <td>{{ $project->client->client_name }}</td>
                                        <td>{{ $project->time }}</td>
                                        @if($project->status == "stopped")
                                            <td class="text-danger">
                                        @elseif($project->status == "running")
                                            <td class="text-success">
                                        @else
                                            <td class="text-warning">
                                        @endif
                                        {{ ucfirst($project->status) }}</td>
                                        <td>
                                            <form role="form" method="POST" action="{{ route('projects.remove', array($project->id)) }}">
                                                @method('DELETE')
                                                @csrf
                                                <a href="{{ route('projects.edit', array($project->id)) }}" title="Edit" class="ml-2 text-decoration-none">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="ml-2 alert-danger bg-white border-0" title="Remove" onclick="return confirm('{{ __('Do you really want to remove this project? It will remove all interactions realized.') }}');">
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