@extends('layouts.admin')
@section('title', __('Edit App Category') . ' — ' . $appCategory->name)

@section('content')
    {{-- Breadcrumb --}}
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm mb-2 text-[var(--text-muted)]">
            <a href="{{ route('admin.app-categories.index') }}" class="text-[var(--primary)]">{{ __('App Categories') }}</a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
            <span>{{ $appCategory->name }}</span>
        </div>
        <h1 class="page-title">{{ __('Edit App Category') }}</h1>
        <p class="page-subtitle">{{ __('Update category name and active status') }}</p>
    </div>

    <form action="{{ route('admin.app-categories.update', $appCategory->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card mb-6">
            @include('admin.app-categories._form')
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="btn btn-primary">
                <i data-lucide="save" class="w-4 h-4"></i> {{ __('Save Changes') }}
            </button>
            <a href="{{ route('admin.app-categories.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
        </div>
    </form>
@endsection
