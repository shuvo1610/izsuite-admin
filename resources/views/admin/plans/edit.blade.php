@extends('layouts.admin')
@section('title', __('Edit Plan'))

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="page-title">{{ __('Edit Plan') }}</h1>
            <p class="page-subtitle">{{ __('Update') }} "{{ $plan->name }}"</p>
        </div>
        <a href="{{ route('admin.plans.index') }}" class="btn btn-secondary">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> {{ __('Back') }}
        </a>
    </div>

    <div class="card p-6">
        <form action="{{ route('admin.plans.update', $plan->id) }}" method="POST">
            @csrf @method('PUT')
            @include('admin.plans._form')
            <div class="mt-6">
                <button type="submit" class="btn btn-primary">{{ __('Update Plan') }}</button>
            </div>
        </form>
    </div>
@endsection
