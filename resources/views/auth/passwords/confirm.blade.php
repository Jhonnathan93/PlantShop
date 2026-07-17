@extends('layouts.app')

@section('content')
<div class="container auth-page">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="auth-card">
                <div class="auth-card__header">{{ __('passwords.confirm_title') }}</div>

                <div class="auth-card__body">
                    {{ __('passwords.confirm_description') }}

                    <form method="POST" action="{{ route('passwords.confirm') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('passwords.password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('passwords.confirm_title') }}
                                </button>

                                @if (Route::has('passwords.request'))
                                    <a class="btn btn-link" href="{{ route('passwords.request') }}">
                                        {{ __('passwords.forgot') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
