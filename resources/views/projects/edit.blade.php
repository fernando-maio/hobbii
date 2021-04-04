@extends('template.app')

@section('title', 'Edit Project')

@section('content')
    <div class="container-fluid">
        <h1 class="mt-4">{{ __('Edit Project') }}</h1>

        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                {!! implode('', $errors->all('<div>:message</div>')) !!}
            </div>   
        @endif

        <div class="card mb-4">
            <form method="POST" action="{{ route('projects.update', array($project->id)) }}">
                @method('PATCH')
                @csrf
                <div class="p-3">
                    <div class="form-row">
                        <!-- Project Name -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1" for="ProjectName">{{ __('Name') }}</label>
                                <input class="form-control" name="name" type="text" value="{{ $project->name }}" placeholder="Enter project name" required />
                            </div>
                        </div>

                        <!-- Client -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1" for="contactName">{{ __('Client') }}</label>
                                <select name="client_id" class="form-control">                                    
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}" {{ $project->client_id == $client->id ? "selected":"" }}>{{ $client->client_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="float-right mb-3">
                        <!-- Cancel -->
                        <a class="btn btn-secondary" href="{{ route('projects') }}">
                            {{ __('Cancel') }}
                        </a>

                        <!-- Submit -->
                        <button type="submit" class="btn btn-primary">
                            {{ __('Submit') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection