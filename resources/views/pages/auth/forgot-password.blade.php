@extends('layouts.auth', ['title' => __('site.forgot_password')])
@section('content')
    @push('styles')
    @endpush

    <div class="card card-primary">
        <div class="card-header">
            <h4>{{ __('site.forgot_password') }}</h4>
        </div>
        <div class="card-body">
            <p class="text-muted">
                {{ __('site.send_link_password') }}
            </p>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    @if ($errors->count() == 1)
                        <!-- Display the first error if there is only one -->
                        {{ $errors->first() }}
                    @else
                        <ul>
                            <!-- Loop through all errors and display them in a list -->
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endif
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="form-group">
                    <label for="email">{{ __('email') }}</label>
                    <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus />
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                        {{ __('site.forgot_password')}}
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    @endpush
@endsection
