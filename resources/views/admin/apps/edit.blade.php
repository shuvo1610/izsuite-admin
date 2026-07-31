@extends('layouts.admin')
@section('title', __('Edit App') . ' — ' . $app->name)

@section('content')
    {{-- Breadcrumb --}}
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm mb-2 text-[var(--text-muted)]">
            <a href="{{ route('admin.apps.index') }}" class="text-[var(--primary)]">{{ __('Apps') }}</a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
            <span>{{ $app->name }}</span>
        </div>
        <h1 class="page-title">{{ __('Edit App') }}</h1>
        <p class="page-subtitle">{{ __('Update app details, logo and status') }}</p>
    </div>

    <form action="{{ route('admin.apps.update', $app->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card mb-6">
            @include('admin.apps._form')
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="btn btn-primary">
                <i data-lucide="save" class="w-4 h-4"></i> {{ __('Save Changes') }}
            </button>
            <a href="{{ route('admin.apps.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
        </div>
    </form>
@endsection
