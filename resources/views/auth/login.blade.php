@extends('layouts.guest')
@section('title', 'Sign In')

@section('content')
    <h2 class="text-xl font-bold mb-1 text-[var(--text-primary)]">Welcome back</h2>
    <p class="text-sm mb-6 text-[var(--text-secondary)]">Sign in to access your dashboard</p>

    @if($errors->any())
        <div class="mb-4 p-3 rounded-lg text-sm bg-[var(--danger-light)]">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-4">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-input" placeholder="you@example.com" required autofocus>
        </div>

        <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" class="form-input" placeholder="********" required>
        </div>

        <div class="flex items-center justify-between mb-6">
            <label class="flex items-center gap-2 text-sm text-[var(--text-secondary)]">
                <input type="checkbox" name="remember" class="rounded text-[var(--primary)] accent-[var(--primary)]">
                Remember me
            </label>
        </div>

        <button type="submit" class="btn btn-primary w-full">
            Sign In
        </button>
    </form>
@endsection
