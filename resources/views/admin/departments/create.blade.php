@extends('layouts.admin')
@section('title', __('New Department'))

@section('content')
    {{-- Breadcrumb --}}
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm mb-2 text-[var(--text-muted)]">
            <a href="{{ route('admin.departments.index') }}" class="text-[var(--primary)]">{{ __('Departments') }}</a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
            <span>{{ __('New Department') }}</span>
        </div>
        <h1 class="page-title">{{ __('Add New Department') }}</h1>
        <p class="page-subtitle">{{ __('Create a new department and assign a recruiter') }}</p>
    </div>

    <form action="{{ route('admin.departments.store') }}" method="POST">
        @csrf
        <div class="card mb-6">
            {{-- Department Name --}}
            <div class="mb-4">
                <label for="name" class="form-label">{{ __('Department Name') }}</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-input" placeholder="{{ __('e.g. Engineering') }}" required>
                @error('name')
                    <p class="text-xs mt-1 text-[var(--danger)]">{{ $message }}</p>
                @enderror
            </div>

            {{-- Recruiter (dropdown) --}}
            <div class="mb-4">
                <label for="created_by" class="form-label">{{ __('Recruiter (Creator)') }}</label>
                <select id="created_by" name="created_by" class="form-input" required>
                    <option value="">{{ __('Select a recruiter') }}</option>
                    @foreach($recruiters as $recruiter)
                        <option value="{{ $recruiter->id }}" {{ old('created_by') == $recruiter->id ? 'selected' : '' }}>
                            {{ $recruiter->name }} ({{ $recruiter->email }})
                        </option>
                    @endforeach
                </select>
                @error('created_by')
                    <p class="text-xs mt-1 text-[var(--danger)]">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="btn btn-primary">
                <i data-lucide="plus" class="w-4 h-4"></i> {{ __('Create Department') }}
            </button>
            <a href="{{ route('admin.departments.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
        </div>
    </form>
@endsection
