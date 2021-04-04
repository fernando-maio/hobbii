@extends('template.app')

@section('title', 'New Client')

@section('content')
    <div class="container-fluid">
        <h1 class="mt-4">{{ __('New Client') }}</h1>

        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                {!! implode('', $errors->all('<div>:message</div>')) !!}
            </div>   
        @endif

        <div class="card mb-4">
            <form method="POST" action="{{ route('clients.store') }}">
                @csrf            
                <div class="p-3">
                    <!-- Client Name -->
                    <div class="form-group">
                        <label class="small mb-1" for="clientName">Client Name</label>
                        <input class="form-control" name="client_name" type="text" value="{{ old('client_name') }}" placeholder="Enter client name" required />
                    </div>

                    <!-- Contact Name -->
                    <div class="form-group">
                        <label class="small mb-1" for="contactName">Contact Name</label>
                        <input class="form-control" name="contact_name" type="text" value="{{ old('contact_name') }}" placeholder="Enter contact name" required />
                    </div>

                    <div class="form-row">
                        <!-- Contact Name -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1" for="phone">Phone</label>
                                <input class="form-control" name="phone" type="text" value="{{ old('phone') }}" placeholder="Enter phone" required />
                            </div>
                        </div>

                        <!-- Contact Name -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1" for="email">Email</label>
                                <input class="form-control" name="email" type="email" value="{{ old('email') }}" placeholder="Enter email" required />
                            </div>
                        </div>
                    </div>

                    <div class="float-right mb-3">
                        <!-- Cancel -->
                        <a class="btn btn-secondary" href="{{ route('clients') }}">
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