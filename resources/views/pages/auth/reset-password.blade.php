@extends('layouts.auth', ['title' => __('site.reset_password')])
@section('content')
    @push('styles')
    @endpush

    <div class="card card-primary">
        <div class="card-header">
            <h4>{{ __('site.reset_password') }}</h4>
        </div>
        <div class="card-body">
            <p class="text-muted">{{ __('site.enter_new_password') }}</p>
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
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group">
                    <label for="email">{{ __('email') }}</label>
                    <input id="email" type="email" class="form-control" name="email" tabindex="1" required>
                </div>

                <div class="form-group">
                    <label for="password">{{ __('site.new_password') }}</label>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                </div>

                <div class="form-group">
                    <label for="password-confirm">{{ __('password_confirm') }}</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" tabindex="3"
                        required>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                        {{ __('site.reset_password') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    @endpush
@endsection
