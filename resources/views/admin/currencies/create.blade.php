@extends('layouts.admin')
@section('title', __('New Currency'))

@section('content')
    <div class="mb-6">
        <h1 class="page-title">{{ __('New Currency') }}</h1>
        <p class="page-subtitle">{{ __('Add a new currency') }}</p>
    </div>

    @if($errors->any())
        <div class="p-3 rounded-xl mb-4 text-sm font-medium bg-[var(--danger-light)] text-[var(--danger)]">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('admin.currencies.store') }}" method="POST">
        @csrf
        @include('admin.currencies._form')
    </form>
@endsection
