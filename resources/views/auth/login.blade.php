<x-guest-layout>

@extends('layouts.app')
    <div class="blog_1r1 p-4 mt-4 text-white" style="background:#1e293b; border-radius:12px; max-width:400px; margin:auto;">
        <h4 class="text-center text-white">Login <span class="col_red">Form</span></h4>
        <hr class="line mb-4" style="border: 1px solid #facc15; width: 60px; margin:auto;">

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="input-group input-group-merge mt-3">
                <div class="input-group-text bg-transparent text-white border-end-0">
                    <span class="fa fa-user"></span>
                </div>
                <input type="email" id="email" name="email" 
                    class="form-control bg-transparent text-white border-start-0"
                    placeholder="Email" value="{{ old('email') }}" required autofocus autocomplete="username">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />

            <div class="input-group input-group-merge mt-3">
                <div class="input-group-text bg-transparent text-white border-end-0">
                    <span class="fa fa-lock"></span>
                </div>
                <input type="password" id="password" name="password"
                    class="form-control bg-transparent text-white border-start-0"
                    placeholder="Password" required autocomplete="current-password">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />

            <div class="form-check mt-3">
                <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                <label class="form-check-label" for="remember_me">Remember Me</label>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn bg_red text-white px-4 py-2" style="border-radius:8px;">
                    <i class="fa fa-long-arrow-right me-1"></i> Login
                </button>
            </div>

            <div class="text-center mt-4">
                <h6>
                    <a class="col_red text-decoration-none" href="{{ route('register') }}">
                        Create an account <i class="fa fa-long-arrow-right ms-1"></i>
                    </a>
                </h6>

                @if (Route::has('password.request'))
                    <h6 class="mt-2">
                        <a class="col_red text-decoration-none" href="{{ route('password.request') }}">
                            Forgot your password?
                        </a>
                    </h6>
                @endif
            </div>
        </form>
    </div>
</x-guest-layout>
