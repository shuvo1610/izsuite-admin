@extends('layouts.admin')
@section('title', __('Edit Role') . ' — ' . $role->name)

@section('content')
    {{-- Breadcrumb --}}
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm mb-2 text-[var(--text-muted)]">
            <a href="{{ route('admin.roles.index') }}" class="text-[var(--primary)]">{{ __('Roles') }}</a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
            <span>{{ $role->name }}</span>
        </div>
        <h1 class="page-title">{{ __('Edit Role') }}</h1>
        <p class="page-subtitle">{{ __('Update role name and permissions') }}</p>
    </div>

    <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.roles._form')
    </form>
@endsection
