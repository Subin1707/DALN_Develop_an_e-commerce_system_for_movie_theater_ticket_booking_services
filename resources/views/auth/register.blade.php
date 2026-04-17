<x-guest-layout>

@extends('layouts.app')
    <div class="blog_1r1 p-4 mt-4 text-white" style="background:#1e293b; border-radius:12px; max-width:450px; margin:auto;">
        <h4 class="text-center text-white">Register <span class="col_red">Form</span></h4>
        <hr class="line mb-4" style="border: 1px solid #facc15; width: 60px; margin:auto;">

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="input-group input-group-merge mt-3">
                <div class="input-group-text bg-transparent text-white border-end-0">
                    <span class="fa fa-user"></span>
                </div>
                <input type="text" id="name" name="name"
                    class="form-control bg-transparent text-white border-start-0"
                    placeholder="Full Name" value="{{ old('name') }}" required autofocus autocomplete="name">
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger" />

            <div class="input-group input-group-merge mt-3">
                <div class="input-group-text bg-transparent text-white border-end-0">
                    <span class="fa fa-envelope"></span>
                </div>
                <input type="email" id="email" name="email"
                    class="form-control bg-transparent text-white border-start-0"
                    placeholder="Email" value="{{ old('email') }}" required autocomplete="username">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />

            <div class="input-group input-group-merge mt-3">
                <div class="input-group-text bg-transparent text-white border-end-0">
                    <span class="fa fa-lock"></span>
                </div>
                <input type="password" id="password" name="password"
                    class="form-control bg-transparent text-white border-start-0"
                    placeholder="Password" required autocomplete="new-password">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />

            <div class="input-group input-group-merge mt-3">
                <div class="input-group-text bg-transparent text-white border-end-0">
                    <span class="fa fa-check"></span>
                </div>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class="form-control bg-transparent text-white border-start-0"
                    placeholder="Confirm Password" required autocomplete="new-password">
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-danger" />

            <div class="text-center mt-4">
                <button type="submit" class="btn bg_red text-white px-4 py-2" style="border-radius:8px;">
                    <i class="fa fa-user-plus me-1"></i> Register
                </button>
            </div>

            <div class="text-center mt-4">
                <h6>
                    <a class="col_red text-decoration-none" href="{{ route('login') }}">
                        Already have an account? <i class="fa fa-long-arrow-right ms-1"></i>
                    </a>
                </h6>
            </div>
        </form>
    </div>
</x-guest-layout>
