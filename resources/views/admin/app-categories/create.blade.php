@extends('layouts.admin')
@section('title', __('Add App Category'))

@section('content')
    {{-- Breadcrumb --}}
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm mb-2 text-[var(--text-muted)]">
            <a href="{{ route('admin.app-categories.index') }}" class="text-[var(--primary)]">{{ __('App Categories') }}</a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
            <span>{{ __('Add App Category') }}</span>
        </div>
        <h1 class="page-title">{{ __('Add New App Category') }}</h1>
        <p class="page-subtitle">{{ __('Create a new category to organize apps') }}</p>
    </div>

    <form action="{{ route('admin.app-categories.store') }}" method="POST">
        @csrf
        <div class="card mb-6">
            @include('admin.app-categories._form')
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="btn btn-primary">
                <i data-lucide="plus" class="w-4 h-4"></i> {{ __('Create Category') }}
            </button>
            <a href="{{ route('admin.app-categories.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
        </div>
    </form>
@endsection
