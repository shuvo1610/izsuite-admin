@extends('layouts.admin')
@section('title', __('Create Plan'))

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="page-title">{{ __('Create Plan') }}</h1>
            <p class="page-subtitle">{{ __('Add a new subscription plan') }}</p>
        </div>
        <a href="{{ route('admin.plans.index') }}" class="btn btn-secondary">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> {{ __('Back') }}
        </a>
    </div>

    <div class="card p-6">
        <form action="{{ route('admin.plans.store') }}" method="POST">
            @csrf
            @include('admin.plans._form')
            <div class="mt-6">
                <button type="submit" class="btn btn-primary">{{ __('Create Plan') }}</button>
            </div>
        </form>
    </div>
@endsection
