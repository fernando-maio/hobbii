@extends('template.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <h1 class="mt-4">{{ __('Dashboard') }}</h1>

        @if(session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                {!! implode('', $errors->all('<div>:message</div>')) !!}
            </div>   
        @endif
        
        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    @if(count($actions))
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">{{ __('Project') }}</th>
                                    <th class="px-4 py-2">{{ __('Client') }}</th>
                                    <th class="px-4 py-2">{{ __('Time Spent') }}</th>
                                    <th class="px-4 py-2">{{ __('Status') }}</th>
                                    <th class="px-4 py-2">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($actions as $project)
                                    <tr>
                                        <td>{{ $project->name }}</td>
                                        <td>{{ $project->client->client_name }}</td>
                                        <td>{{ $project->time }}</td>
                                        @if($project->status == "stopped")
                                            <td class="text-danger">
                                        @else
                                            <td class="text-success">
                                        @endif
                                        {{ ucfirst($project->status) }}</td>
                                        <td>
                                            @if($project->status == "stopped")
                                                <a class="m-1" href="{{ route('actions.run', array($project->id)) }}" title="Run"><i class="far fa-play-circle text-success"></i></a>
                                                <a class="m-1" href="{{ route('projects.edit', array($project->id)) }}" title="Edit Project"><i class="fas fa-project-diagram text-info"></i></a>
                                                <a class="m-1" href="{{ route('projects.finish', array($project->id)) }}" title="Finish Project" onclick="return confirm('{{ __('Do you really want to finish this project?') }}');">
                                                    <i class="fas fa-clipboard-check text-warning"></i>
                                                </a>
                                                <a class="m-1" target="_blank" href="{{ route('actions.invoice', array($project->id)) }}" title="Generate Invoice" onclick="return confirm('{{ __('Do you really want to generate an invoice?') }}');">
                                                    <i class="fas fa-file-invoice-dollar text-dark"></i>
                                                </a>
                                            @else
                                                <a class="m-1" href="{{ route('actions.stop', array($project->id)) }}" title="Stop"><i class="far fa-stop-circle text-danger"></i></a>
                                                <a class="m-1" href="{{ route('projects.edit', array($project->id)) }}" title="Edit Project"><i class="fas fa-project-diagram text-info"></i></i></a>
                                            @endif
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
        <div class="text-right m-4">
            <i class="far fa-play-circle text-success"></i> Run | 
            <i class="far fa-stop-circle text-danger"></i> Stop | 
            <i class="fas fa-project-diagram text-info"></i> Edit Project |
            <i class="fas fa-clipboard-check text-warning"></i> Finish Project |
            <i class="fas fa-file-invoice-dollar text-dark"></i> Generate Invoice
        </div>
    </div>
@endsection