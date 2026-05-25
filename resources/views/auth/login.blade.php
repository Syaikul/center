@extends('layouts.kai')

@push('styles')
<style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        font-family: 'Inter', system-ui, sans-serif;
        min-height: 100vh;
        overflow: hidden;
    }

    .login-page {
        position: relative;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
    }

    .login-page__bg {
        position: absolute;
        inset: 0;
        background: url('{{ asset('template/assets/img/bg.jpg') }}') center / cover no-repeat;
    }

    .login-page__overlay {
        position: absolute;
        inset: 0;
        background: rgba(15, 20, 30, 0.25);
    }

    .login-card {
        position: relative;
        z-index: 1;
        width: 100%;
        max-width: 420px;
        padding: 2.5rem 2.25rem 2rem;
        border-radius: 24px;
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.28);
        box-shadow: 0 24px 64px rgba(0, 0, 0, 0.35);
        backdrop-filter: blur(3px);
        -webkit-backdrop-filter: blur(3px);
    }

    .login-card__logo-wrap {
        display: flex;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .login-card__logo {
        max-width: 200px;
        height: auto;
        display: block;
    }

    .login-card__brand {
        text-align: center;
        color: #fff;
        margin-bottom: 1.75rem;
    }

    .login-card__brand-title {
        font-size: 1.125rem;
        font-weight: 700;
        letter-spacing: 0.02em;
        line-height: 1.3;
    }

    .login-card__brand-sub {
        font-size: 0.7rem;
        font-weight: 500;
        letter-spacing: 0.35em;
        text-transform: uppercase;
        opacity: 0.75;
        margin-top: 0.25rem;
    }

    .login-card__heading {
        text-align: center;
        color: #fff;
        margin-bottom: 1.75rem;
    }

    .login-card__heading h1 {
        font-size: 1.625rem;
        font-weight: 700;
        margin-bottom: 0.35rem;
    }

    .login-card__heading p {
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.65);
        font-weight: 400;
    }

    .login-field {
        margin-bottom: 1rem;
    }

    .login-field__wrap {
        position: relative;
        display: flex;
        align-items: center;
    }

    .login-field__icon {
        position: absolute;
        left: 1rem;
        width: 18px;
        height: 18px;
        color: rgba(255, 255, 255, 0.55);
        pointer-events: none;
        flex-shrink: 0;
    }

    .login-field__input {
        width: 100%;
        height: 50px;
        padding: 0 3rem 0 2.75rem;
        border-radius: 14px;
        border: 1px solid rgba(255, 255, 255, 0.22);
        background: rgba(30, 35, 45, 0.55);
        color: #fff;
        font-size: 0.9375rem;
        font-family: inherit;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .login-field__input::placeholder {
        color: rgba(255, 255, 255, 0.4);
    }

    .login-field__input:focus {
        border-color: rgba(255, 255, 255, 0.45);
        box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.08);
    }

    .login-field__input.is-invalid {
        border-color: #f87171;
    }

    .login-field__toggle {
        position: absolute;
        right: 0.875rem;
        background: none;
        border: none;
        padding: 0.25rem;
        cursor: pointer;
        color: rgba(255, 255, 255, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color 0.2s;
    }

    .login-field__toggle:hover {
        color: rgba(255, 255, 255, 0.85);
    }

    .login-field__error {
        display: block;
        margin-top: 0.4rem;
        font-size: 0.8rem;
        color: #fca5a5;
        padding-left: 0.25rem;
    }

    .login-btn {
        width: 100%;
        height: 52px;
        margin-top: 0.5rem;
        border: none;
        border-radius: 14px;
        background: linear-gradient(90deg, #3b82f6 0%, #1d4ed8 100%);
box-shadow: 0 8px 24px rgba(59, 130, 246, 0.45);
        color: #fff;
        font-size: 1rem;
        font-weight: 700;
        font-family: inherit;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        box-shadow: 0 8px 24px rgba(158, 69, 64, 0.45);
        transition: transform 0.15s, box-shadow 0.2s, filter 0.2s;
        position: relative;
        overflow: hidden;
    }

    .login-btn:hover {
        filter: brightness(1.06);
        box-shadow: 0 10px 28px rgba(158, 69, 64, 0.55);
    }

    .login-btn:active {
        transform: scale(0.98);
    }

    .login-btn__arrow {
        position: absolute;
        right: 1.25rem;
        width: 20px;
        height: 20px;
    }
</style>
@endpush

@section('content')
<div class="login-page">
    <div class="login-page__bg" aria-hidden="true"></div>
    <div class="login-page__overlay" aria-hidden="true"></div>

    <div class="login-card">
        <div class="login-card__logo-wrap">
            <img
                src="{{ asset('template/assets/img/logo-baru.png') }}"
                alt="{{ config('app.name', 'Data Pusat') }}"
                class="login-card__logo"
            >
        </div>

        <!-- <div class="login-card__brand">
            <div class="login-card__brand-title">{{ config('app.name', 'Data Pusat') }}</div>
            <div class="login-card__brand-sub">Sistem Informasi</div>
        </div> -->

        <div class="login-card__heading">
            <h1>Selamat datang</h1>
            <p>Masuk untuk melanjutkan</p>
        </div>

        <form method="POST" action="{{ route('login') }}" novalidate>
            @csrf

            <div class="login-field">
                <div class="login-field__wrap">
                    <svg class="login-field__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        class="login-field__input @error('email') is-invalid @enderror"
                        value="{{ old('email') }}"
                        placeholder="Email"
                        required
                        autocomplete="email"
                        autofocus
                    >
                </div>
                @error('email')
                    <span class="login-field__error" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <div class="login-field">
                <div class="login-field__wrap">
                    <svg class="login-field__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        class="login-field__input @error('password') is-invalid @enderror"
                        placeholder="Password"
                        required
                        autocomplete="current-password"
                    >
                    <button type="button" class="login-field__toggle" id="togglePassword" aria-label="Tampilkan password">
                        <svg id="eyeIcon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
                @error('password')
                    <span class="login-field__error" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="login-btn">
                Masuk
                <svg class="login-btn__arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                    <path d="M5 12h14M13 6l6 6-6 6"/>
                </svg>
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('togglePassword')?.addEventListener('click', function () {
        const input = document.getElementById('password');
        const icon = document.getElementById('eyeIcon');
        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        icon.innerHTML = isHidden
            ? '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>'
            : '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
        this.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Tampilkan password');
    });
</script>
@endpush
